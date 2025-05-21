<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('You must be logged in to add a place.'); window.location.href = 'ad.php';</script>";
        exit;
    }
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Invalid CSRF token.');
    }

    $user_id       = $_SESSION['user_id'];
    $name          = trim($_POST['name'] ?? '');
    $price         = $_POST['price'] ?? '';
    $description   = trim($_POST['description'] ?? '');
    $tags          = trim($_POST['tags'] ?? '');
    $category_id   = (int)($_POST['category_id'] ?? 0);
    $email         = trim($_POST['email'] ?? '');
    $phone1        = trim($_POST['phone_1'] ?? '');
    $phone2        = trim($_POST['phone_2'] ?? '');
    $website       = trim($_POST['website'] ?? '');
    $facebook_url  = trim($_POST['facebook_url'] ?? '');
    $instagram_url = trim($_POST['instagram_url'] ?? '');
    $twitter_url   = trim($_POST['twitter_url'] ?? '');
    $country       = trim($_POST['country'] ?? '');
    $city          = trim($_POST['city'] ?? '');
    $address       = trim($_POST['address'] ?? '');
    $latitude      = floatval($_POST['latitude'] ?? 0);
    $longitude     = floatval($_POST['longitude'] ?? 0);
    $google_map_location = trim($_POST['google_map_location'] ?? '');
    $open_times    = $_POST['open_time'] ?? [];
    $close_times   = $_POST['close_time'] ?? [];

    $errors = [];
    if ($name === '') $errors[] = "Place name is required.";
    if (!in_array($price, ['$', '$$', '$$$'], true)) $errors[] = "Please select a valid price.";
    if ($category_id <= 0) $errors[] = "Please select a category.";
    if ($latitude < -90 || $latitude > 90 || $longitude < -180 || $longitude > 180) {
        $errors[] = "Invalid coordinates.";
    }
    if (strlen($address) > 100) {
        $errors[] = "Address is too long. Please use a shorter address (max 100 characters).";
    }

    if (empty($errors)) {
        $conn->begin_transaction();
        try {
            // Insert into places table
            $stmt = $conn->prepare("
                INSERT INTO places
                  (user_id, category_id, name, price, tags, description,
                   email, phone_1, phone_2, website,
                   facebook_url, instagram_url, twitter_url,
                   country, city, address, latitude, longitude, google_map_location)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param(
                "iissssssssssssssdds",
                $user_id, $category_id, $name, $price, $tags, $description,
                $email, $phone1, $phone2, $website,
                $facebook_url, $instagram_url, $twitter_url,
                $country, $city, $address, $latitude, $longitude, $google_map_location
            );
            $stmt->execute();
            $place_id = $stmt->insert_id;
            $stmt->close();

            // Opening hours
            $hoursStmt = $conn->prepare("
                INSERT INTO opening_hours (place_id, day, open_time, close_time)
                VALUES (?, ?, ?, ?)
            ");
            $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            foreach ($days as $day) {
                $o = $open_times[$day] ?? null;
                $c = $close_times[$day] ?? null;
                if ($o && $c) {
                    $hoursStmt->bind_param("isss", $place_id, $day, $o, $c);
                    $hoursStmt->execute();
                }
            }
            $hoursStmt->close();

            // Get category name
            $cat_stmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
            $cat_stmt->bind_param("i", $category_id);
            $cat_stmt->execute();
            $cat_result = $cat_stmt->get_result();
            $category = $cat_result->fetch_assoc();
            $cat_stmt->close();

            // Function to sanitize place name only
            function normalizeName($name) {
                return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $name)));
            }

            // Use the exact category name without normalization
            $category_name_safe = $category['name'];
            $place_name_safe = normalizeName($name);

            // Create folder structure
            $base_path = __DIR__ . "/assets/images/places/{$category_name_safe}/{$place_name_safe}";
            $featured_dir = "{$base_path}/featured/";
            $gallery_dir = "{$base_path}/gallery/";
            $menu_dir = "{$base_path}/menu/";

            foreach ([$featured_dir, $gallery_dir, $menu_dir] as $dir) {
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
            }

            // Featured image
            if (!empty($_FILES['featured_image']['name'])) {
                if (is_array($_FILES['featured_image']['name'])) {
                    throw new Exception('Only one featured image is allowed.');
                }

                if ($_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['featured_image']['tmp_name'];
                    $filename = uniqid('feat_', true) . '_' . basename($_FILES['featured_image']['name']);
                    $dest = $featured_dir . $filename;
                    move_uploaded_file($tmp_name, $dest);

                    $path = "assets/images/places/{$category_name_safe}/{$place_name_safe}/featured/" . $filename;
                    $stmt = $conn->prepare("UPDATE places SET featured_image = ? WHERE id = ?");
                    $stmt->bind_param("si", $path, $place_id);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            // Gallery images (limit to 8 max)
            if (!empty($_FILES['gallery_images']['name'][0])) {
                $galleryCount = count($_FILES['gallery_images']['name']);
                if ($galleryCount > 8) {
                    throw new Exception('You can only upload up to 8 gallery images.');
                }

                foreach ($_FILES['gallery_images']['tmp_name'] as $index => $tmp_name) {
                    if ($_FILES['gallery_images']['error'][$index] === UPLOAD_ERR_OK) {
                        $filename = uniqid('gal_', true) . '_' . basename($_FILES['gallery_images']['name'][$index]);
                        $dest = $gallery_dir . $filename;
                        move_uploaded_file($tmp_name, $dest);

                        $path = "assets/images/places/{$category_name_safe}/{$place_name_safe}/gallery/" . $filename;
                        $stmt = $conn->prepare("INSERT INTO place_gallery (place_id, image_url) VALUES (?, ?)");
                        $stmt->bind_param("is", $place_id, $path);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
            }

            // Menu items
            $menu_items_json = $_POST['menu_items_data'] ?? '';
            if ($menu_items_json) {
                $menu_items = json_decode($menu_items_json, true);
                if (is_array($menu_items)) {
                    $menuStmt = $conn->prepare("INSERT INTO menu_items (place_id, name, price, description, image) VALUES (?, ?, ?, ?, ?)");
                    foreach ($menu_items as $item) {
                        $item_name = $item['name'] ?? '';
                        $item_price = $item['price'] ?? 0.00;
                        $item_description = $item['description'] ?? '';
                        $base64_image = $item['image'] ?? '';
                        $image_path = '';

                        if ($base64_image) {
                            $data = preg_replace('#^data:image/\w+;base64,#i', '', $base64_image);
                            $data = base64_decode($data);

                            $filename = uniqid('menu_', true) . '.jpg';
                            $image_path = "assets/images/places/{$category_name_safe}/{$place_name_safe}/menu/" . $filename;
                            $save_path = __DIR__ . '/' . $image_path;

                            file_put_contents($save_path, $data);
                        }

                        if ($item_name && $image_path) {
                            $menuStmt->bind_param("isdss", $place_id, $item_name, $item_price, $item_description, $image_path);
                            $menuStmt->execute();
                        }
                    }
                    $menuStmt->close();
                }
            }

            // FAQs
            $faq_questions = $_POST['faq_questions'] ?? [];
            $faq_answers = $_POST['faq_answers'] ?? [];
            if (!empty($faq_questions) && !empty($faq_answers)) {
                $faqStmt = $conn->prepare("INSERT INTO faqs (place_id, question, answer) VALUES (?, ?, ?)");
                foreach ($faq_questions as $i => $question) {
                    $question = trim($question);
                    $answer = trim($faq_answers[$i] ?? '');
                    if ($question !== '' && $answer !== '') {
                        $faqStmt->bind_param("iss", $place_id, $question, $answer);
                        $faqStmt->execute();
                    }
                }
                $faqStmt->close();
            }

            $conn->commit();
            header("Location: single-place.php?place_id={$place_id}");
            exit;
        } catch (Exception $e) {
            $conn->rollback();
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}

$cats = $conn->query("SELECT id, name FROM categories ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);
include 'header.php';
?>

<main class="add-place">
  <?php if (!empty($errors)): ?>
    <div class="errors">
      <ul>
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="add-place_sidebar">
    <a href="#add-place-general">GENERAL</a>
    <a href="#add-place-location">LOCATION</a>
    <a href="#add-place-contact">CONTACT INFO</a>
    <a href="#add-place-social">SOCIAL NETWORKS</a>
    <a href="#add-place-opening">OPENING HOURS</a>
    <a href="#add-place-media">MEDIA</a>
    <a href="#add-place-menu">MENU</a>
    <a href="#add-place-faqs">FAQs</a>
  </div>

  <form class="add-place_main" method="POST" action="add-place.php" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

    <!-- GENERAL SECTION -->
    <div id="add-place-general" class="add-place_main--item add-place_main--general">
      <h2 class="add-place_title">GENERAL</h2>
      <div class="side-by-side_inbut">
        <input type="text" name="name" placeholder="PLACE NAME"
               class="input--red"
               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
        <select name="price" class="input--red" required>
          <option value="" disabled <?= empty($_POST['price']) ? 'selected' : '' ?>>PRICE</option>
          <option value="$"   <?= ($_POST['price'] ?? '') === '$'   ? 'selected' : '' ?>>$</option>
          <option value="$$"  <?= ($_POST['price'] ?? '') === '$$'  ? 'selected' : '' ?>>$$</option>
          <option value="$$$" <?= ($_POST['price'] ?? '') === '$$$' ? 'selected' : '' ?>>$$$</option>
        </select>
      </div>
      <textarea name="description" placeholder="DESCRIPTION …" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
      <div class="side-by-side_inbut">
        <input type="text" name="tags" placeholder="TAGS (comma-separated)"
               class="input--red"
               value="<?= htmlspecialchars($_POST['tags'] ?? '') ?>">
        <?php
$category_names = [
    'restaurants' => 'RESTAURANTS',
    'shopping' => 'SHOPPING',
    'active-life' => 'ACTIVE LIFE',
    'home s' => 'HOME SERVICES',
    'coffee' => 'COFFEE',
    'pets' => 'PETS',
    'plants' => 'PLANTS SHOP',
    'art' => 'ART',
    'hotal' => 'HOTELS',
    'edu' => 'EDUCATION',
    'health' => 'HEALTH',
    'workspace' => 'WORKSPACE'
];
?>
<select name="category_id" class="input--red" required>
    <option value="" disabled <?= empty($_POST['category_id']) ? 'selected' : '' ?>>CATEGORY</option>
    <?php foreach ($cats as $cat): ?>
        <?php
            $raw = strtolower($cat['name']);
            $display = $category_names[$raw] ?? htmlspecialchars($cat['name']);
        ?>
        <option value="<?= $cat['id'] ?>"
                <?= (($_POST['category_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
            <?= $display ?>
        </option>
    <?php endforeach; ?>
</select>
      </div>
    </div>

    <!-- LOCATION SECTION -->
    <div class="add-place_main--item add-place_main--location" id="add-place-location">
        <h2 class="add-place_title">LOCATION</h2>
        <div class="side-by-side_inbut">
            <input type="text" name="country" id="country" placeholder="COUNTRY"
                   class="input--red" value="<?= htmlspecialchars($_POST['country'] ?? '') ?>">
            <input type="text" name="city" id="city" placeholder="CITY"
                   class="input--red" value="<?= htmlspecialchars($_POST['city'] ?? '') ?>">
        </div>
        <input type="text" name="google_map_location" id="google_map_location" placeholder="Use the map or add the Google Maps link of the place"
               class="input--red" value="<?= htmlspecialchars($_POST['google_map_location'] ?? '') ?>">
        <div class="location-map">
            <h3 class="location-map_title">SET LOCATION ON MAP</h3>
            <div id="map" style="height: 400px;"></div>
            <p>Selected Coordinates: <span id="coordinates">31.9539, 35.9106</span></p>
        </div>
        <input type="hidden" name="address" id="address" value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">
        <input type="hidden" name="latitude" id="latitude" value="<?= htmlspecialchars($_POST['latitude'] ?? '31.9539') ?>">
        <input type="hidden" name="longitude" id="longitude" value="<?= htmlspecialchars($_POST['longitude'] ?? '35.9106') ?>">
    </div>

    <!-- CONTACT INFO SECTION -->
    <div id="add-place-contact" class="add-place_main--item add-place_main--contact">
      <h2 class="add-place_title">CONTACT INFO</h2>
      <input type="email" name="email" placeholder="EMAIL"
             class="input--red"
             value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
      <input type="text" name="phone_1" placeholder="PHONE NUMBER 1"
             class="input--red"
             value="<?= htmlspecialchars($_POST['phone_1'] ?? '') ?>">
      <input type="text" name="phone_2" placeholder="PHONE NUMBER 2 (OPTIONAL)"
             class="input--red"
             value="<?= htmlspecialchars($_POST['phone_2'] ?? '') ?>">
      <input type="url" name="website" placeholder="WEBSITE (OPTIONAL)"
             class="input--red"
             value="<?= htmlspecialchars($_POST['website'] ?? '') ?>">
    </div>

    <!-- SOCIAL NETWORKS SECTION -->
    <div id="add-place-social" class="add-place_main--item add-place_main--social">
      <h2 class="add-place_title">SOCIAL NETWORKS</h2>
      <input type="url" name="facebook_url" placeholder="FACEBOOK URL"
             class="input--red"
             value="<?= htmlspecialchars($_POST['facebook_url'] ?? '') ?>">
      <input type="url" name="instagram_url" placeholder="INSTAGRAM URL"
             class="input--red"
             value="<?= htmlspecialchars($_POST['instagram_url'] ?? '') ?>">
      <input type="url" name="twitter_url" placeholder="TWITTER URL"
             class="input--red"
             value="<?= htmlspecialchars($_POST['twitter_url'] ?? '') ?>">
    </div>

    <!-- OPENING HOURS SECTION -->
    <div id="add-place-opening" class="add-place_main--item add-place_main--opening">
      <h2 class="add-place_title">OPENING HOURS</h2>
      <?php
        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        foreach ($days as $day):
      ?>
      <div class="side-by-side_inbut">
        <input type="text" class="input--red" value="<?= $day ?>" readonly>
        <div class="side-by-side_inbut">
          <input type="time"
                 name="open_time[<?= $day ?>]"
                 class="input--red"
                 value="<?= htmlspecialchars($_POST['open_time'][$day]  ?? '09:00') ?>">
          <input type="time"
                 name="close_time[<?= $day ?>]"
                 class="input--red"
                 value="<?= htmlspecialchars($_POST['close_time'][$day] ?? '17:00') ?>">
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- MEDIA SECTION -->
    <div class="add-place_main--item add-place_main--media" id="add-place-media">
        <h2 class="add-place_title">MEDIA</h2>
        <div class="media-contanier">
            <div class="media-contanier_featured">
                <p class="media-contanier_title">FEATURED IMAGE</p>
                <div class="drop-area">
                    <p><i class="fa-solid fa-arrow-up"></i>
                        <label for="fileInput1" class="browse-btn"></label>
                    </p>
                    <input type="file" id="fileInput1" name="featured_image" class="file-input" accept="image/*" hidden>
                </div>
            </div>
            <div class="media-contanier_gallery">
                <p class="media-contanier_title">GALLERY IMAGES</p>
                <div class="drop-area gallery-drop-area">
                    <p><i class="fa-solid fa-arrow-up"></i> Drag & Drop files here
                        <label for="fileInput2" class="browse-btn"></label>
                    </p>
                    <input
                        type="file"
                        id="fileInput2"
                        name="gallery_images[]"
                        accept="image/*"
                        multiple
                        hidden
                    >
                </div>
            </div>
        </div>
        <div class="media_added">
            <div class=".media_added--fetured">
                <h3 class="media_added--title">ADDED FEATURED IMAGE</h3>
                <div class="media_added--fetured_img"></div>
            </div>
            <div class="media_added--gallery">
                <h3 class="media_added--title">ADDED IMAGES FOR GALLERY</h3>
                <div class="media_added--gallery_grid"></div>
            </div>
        </div>
    </div>

    <!-- MENU SECTION -->
    <div class="add-place_main--item add-place_main--menu" id="add-place-menu">
            <h2 class="add-place_title">MENU</h2>
            <div class="add-menu_item">
                <div class="add-menu_item--img">
                    <p class="media-contanier_title">MENU ITEM IMAGE</p>
                    <div class="drop-area">
                        <p><i class="fa-solid fa-arrow-up"></i>
                            <label for="fileInput3" class="browse-btn"></label>
                        </p>
                        <input type="file" id="fileInput3" class="file-input" accept="image/*">
                        <div class="file-list"></div>
                    </div>
                </div>
                <div class="add-menu_item--info">
                    <div class="side-by-side_inbut">
                        <input type="text" placeholder="MENU ITEM NAME" class="input--red" id="menuItemName">
                        <input type="text" placeholder="MENU ITEM PRICE" class="input--red" id="menuItemPrice">
                    </div>
                    <input type="text" placeholder="MENU ITEM DESCRIPTION" class="input--red" id="menuItemDescription">
                </div>
            </div>
            <button type="button" id="addMenuItemBtn" class="btn__red--s btn__red btn">ADD ITEM</button>
            <div class="add-menu_added">
                <h3>ADDED MENU ITEMS</h3>
                <div class="add-menu_added-grid" id="menuItemsContainer"></div>
            </div>
          <input type="hidden" name="menu_items_data" id="menuItemsInput">
<input type="hidden" name="deleted_menu_items" id="deletedMenuItemsInput">
      </div>

    <!-- FAQS SECTION -->
    <div class="add-place_main--item add-place_main--faqs" id="add-place-faqs">
        <h2 class="add-place_title">FAQs</h2>
        <input type="text" id="faq-question" placeholder="QUESTION" class="input--red">
        <input type="text" id="faq-answer" placeholder="ANSWER" class="input--red">
        <button type="button" class="btn__red--s btn__red btn" id="add-faq-btn">ADD QUESTION</button>
        <div class="added-faqs">
            <h3>ADDED FAQS</h3>
            <div class="added-faqs-grid" id="faqs-container"></div>
        </div>
    </div>

    <!-- CSRF Token -->
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

    <button type="submit" class="btn__red--l btn__red btn">ADD PLACE !</button>
  </form>
</main>

<script>
(() => {
  const dropArea = document.querySelector('.drop-area');
  const fileInput1 = document.getElementById('fileInput1');
  const previewContainer = document.querySelector('.media_added--fetured_img');

  function clearPreview() {
    previewContainer.innerHTML = '';
  }

  function showPreview(file) {
    console.log('showPreview called with file:', file);
    clearPreview();

    const reader = new FileReader();
    reader.onload = e => {
      console.log('FileReader loaded, displaying image');
      const wrapper = document.createElement('div');
      wrapper.innerHTML = `
        <div class="media_added--fetured_img">
          <img src="${e.target.result}" alt="Featured Image Preview">
          <button type="button" class="remove-featured">X</button>
        </div>
      `;
      previewContainer.appendChild(wrapper);

      wrapper.querySelector('.remove-featured').onclick = () => {
        fileInput1.value = '';
        clearPreview();
      };
    };
    reader.readAsDataURL(file);
  }

  fileInput1.addEventListener('change', () => {
    if (fileInput1.files.length > 1) {
      alert('Only one featured image is allowed.');
      fileInput1.value = '';
      clearPreview();
      return;
    }
    if (fileInput1.files.length === 1) {
      showPreview(fileInput1.files[0]);
    } else {
      clearPreview();
    }
  });

  dropArea.addEventListener('dragover', e => {
    e.preventDefault();
    dropArea.classList.add('dragover');
  });
  dropArea.addEventListener('dragleave', e => {
    e.preventDefault();
    dropArea.classList.remove('dragover');
  });
  dropArea.addEventListener('drop', e => {
    e.preventDefault();
    dropArea.classList.remove('dragover');

    const dtFiles = e.dataTransfer.files;
    if (dtFiles.length > 1) {
      alert('Only one featured image allowed.');
      return;
    }

    if (dtFiles.length === 1) {
      fileInput1.files = dtFiles;
      showPreview(dtFiles[0]);
    }
  });

  document.addEventListener('DOMContentLoaded', () => {
    const MAX_GALLERY_IMAGES = 8;
    const galInput     = document.getElementById('fileInput2');
    const galContainer = document.querySelector('.media_added--gallery_grid');
    const galDropArea  = document.querySelector('.gallery-drop-area');
    let galleryFiles   = [];

    galInput.addEventListener('change', () => {
      const newFiles = Array.from(galInput.files);
      if (galleryFiles.length + newFiles.length > MAX_GALLERY_IMAGES) {
        alert(`You can only upload up to ${MAX_GALLERY_IMAGES} gallery images.`);
        return;
      }
      galleryFiles = galleryFiles.concat(newFiles);
      updateGalInputFiles();
      renderGalleryPreviews();
    });

    function renderGalleryPreviews() {
      galContainer.innerHTML = '';
      galleryFiles.forEach((file, idx) => {
        const reader = new FileReader();
        reader.onload = e => {
          const wrapper = document.createElement('div');
          wrapper.className = 'media_added--gallery_grid_item';
          wrapper.innerHTML = `
            <img src="${e.target.result}" alt="Gallery Image">
            <button type="button" class="remove-gallery" data-idx="${idx}">X</button>
          `;
          wrapper.querySelector('.remove-gallery').onclick = () => {
            galleryFiles.splice(idx, 1);
            updateGalInputFiles();
            renderGalleryPreviews();
          };
          galContainer.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
      });
    }

    function updateGalInputFiles() {
      const dt = new DataTransfer();
      galleryFiles.forEach(f => dt.items.add(f));
      galInput.files = dt.files;
    }

    galDropArea.addEventListener('dragover', e => {
      e.preventDefault();
      galDropArea.classList.add('dragover');
    });
    galDropArea.addEventListener('dragleave', e => {
      e.preventDefault();
      galDropArea.classList.remove('dragover');
    });
    galDropArea.addEventListener('drop', e => {
      e.preventDefault();
      galDropArea.classList.remove('dragover');

      const dropped = Array.from(e.dataTransfer.files);
      if (galleryFiles.length + dropped.length > MAX_GALLERY_IMAGES) {
        alert(`You can only upload up to ${MAX_GALLERY_IMAGES} gallery images.`);
        return;
      }
      galleryFiles = galleryFiles.concat(dropped);
      updateGalInputFiles();
      renderGalleryPreviews();
    });
  });
})();
</script>

<script>
const addMenuItemBtn = document.getElementById('addMenuItemBtn');
const menuItemsContainer = document.getElementById('menuItemsContainer');
const menuItemsInput = document.getElementById('menuItemsInput');
const deletedMenuItemsInput = document.getElementById('deletedMenuItemsInput');
let menuItems = [];
let deletedMenuItemIds = [];
let editingIndex = null;

// Load existing menu items from PHP
<?php if (!empty($menu_items)): ?>
menuItems = <?= json_encode($menu_items) ?>.map(item => ({
    ...item,
    image: item.image // For existing, use image URL
}));
renderMenuItems();
<?php endif; ?>

addMenuItemBtn.addEventListener('click', async () => {
    const name = document.getElementById('menuItemName').value.trim();
    const price = document.getElementById('menuItemPrice').value.trim();
    const description = document.getElementById('menuItemDescription').value.trim();
    const fileInput = document.getElementById('fileInput3');
    let base64 = null;

    if (!name || !price || !description) {
        alert('Please fill all fields.');
        return;
    }

    if (editingIndex !== null) {
        // Edit mode
        if (fileInput.files[0]) {
            base64 = await toBase64(fileInput.files[0]);
        } else {
            base64 = menuItems[editingIndex].image;
        }
        menuItems[editingIndex] = {
            ...menuItems[editingIndex],
            name, price, description, image: base64
        };
        editingIndex = null;
    } else {
        // Add mode
        if (!fileInput.files[0]) {
            alert('Please select an image.');
            return;
        }
        base64 = await toBase64(fileInput.files[0]);
        menuItems.push({ name, price, description, image: base64 });
    }

    renderMenuItems();
    updateHiddenInput();
    clearInputs();
});

menuItemsContainer.addEventListener('click', (e) => {
    // Delete
    if (e.target.classList.contains('delete-menu-item')) {
        e.preventDefault();
        const itemDiv = e.target.closest('.add-menu_added-grid_item');
        const index = Array.from(menuItemsContainer.children).indexOf(itemDiv);
        // If existing, mark for deletion
        if (menuItems[index].id) {
            deletedMenuItemIds.push(menuItems[index].id);
        }
        menuItems.splice(index, 1);
        renderMenuItems();
        updateHiddenInput();
    }
    // Edit
    if (e.target.classList.contains('edit-menu-item') || e.target.closest('.edit-menu-item')) {
        e.preventDefault();
        const itemDiv = e.target.closest('.add-menu_added-grid_item');
        const index = Array.from(menuItemsContainer.children).indexOf(itemDiv);
        const item = menuItems[index];
        document.getElementById('menuItemName').value = item.name;
        document.getElementById('menuItemPrice').value = item.price;
        document.getElementById('menuItemDescription').value = item.description;
        // Show image preview if needed
        if (item.image && !item.image.startsWith('data:')) {
            document.querySelector('.file-list').innerHTML = `<img src="${item.image}" style="max-width:60px;">`;
        } else if (item.image) {
            document.querySelector('.file-list').innerHTML = `<img src="${item.image}" style="max-width:60px;">`;
        }
        editingIndex = index;
    }
});

function renderMenuItems() {
    menuItemsContainer.innerHTML = '';
    menuItems.forEach(item => {
        const div = document.createElement('div');
        div.className = 'add-menu_added-grid_item';
        div.innerHTML = `
            <img src="${item.image}" alt="">
            <div class="add-menu_added-grid_item--info">
                <h4>${item.name}</h4>
                <p>${item.description}</p>
                <p>${item.price}</p>
            </div>
            <a href="#" class="delete-menu-item">X</a>
            <a href="#" class="edit-menu-item"><i class="fa fa-edit"></i></a>
        `;
        menuItemsContainer.appendChild(div);
    });
    updateHiddenInput();
}

function updateHiddenInput() {
    menuItemsInput.value = JSON.stringify(menuItems);
    deletedMenuItemsInput.value = JSON.stringify(deletedMenuItemIds);
}

function clearInputs() {
    document.getElementById('menuItemName').value = '';
    document.getElementById('menuItemPrice').value = '';
    document.getElementById('menuItemDescription').value = '';
    document.getElementById('fileInput3').value = '';
    document.querySelector('.file-list').innerHTML = '';
}

function toBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
    });
}
const fileInput = document.getElementById('fileInput3');
const fileListPreview = document.querySelector('.file-list');

// Show preview when selecting a new image (for both add and edit)
fileInput.addEventListener('change', () => {
    fileListPreview.innerHTML = '';
    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            fileListPreview.innerHTML = `<img src="${e.target.result}" style="max-width:60px;">`;
        };
        reader.readAsDataURL(fileInput.files[0]);
    }
});
</script>>

<script>
(() => {
    const faqQuestionInput = document.querySelector('#add-place-faqs input[placeholder="QUESTION"]');
    const faqAnswerInput = document.querySelector('#add-place-faqs input[placeholder="ANSWER"]');
    const addFaqBtn = document.querySelector('#add-place-faqs .btn');
    const addedFaqsContainer = document.querySelector('.added-faqs-grid');
    const faqs = [];

    // Helper function to escape HTML characters
    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    function renderFaqs() {
        addedFaqsContainer.innerHTML = '';
        faqs.forEach((faq, index) => {
            const div = document.createElement('div');
            div.className = 'added-faqs-grid_item';
            div.innerHTML = `
                <h4>${escapeHtml(faq.question)}</h4>
                <p>${escapeHtml(faq.answer)}</p>
                <button onclick="removeFaq(${index})">X</button>
                <input type="hidden" name="faq_questions[]" value="${escapeHtml(faq.question)}">
                <input type="hidden" name="faq_answers[]" value="${escapeHtml(faq.answer)}">
            `;
            addedFaqsContainer.appendChild(div);
        });
    }

    function removeFaq(index) {
        faqs.splice(index, 1);
        renderFaqs();
    }

    addFaqBtn.addEventListener('click', (e) => {
        e.preventDefault();
        const question = faqQuestionInput.value.trim();
        const answer = faqAnswerInput.value.trim();
        if (question && answer) {
            faqs.push({ question, answer });
            faqQuestionInput.value = '';
            faqAnswerInput.value = '';
            renderFaqs();
        }
    });

    window.removeFaq = removeFaq;
})();
</script>



<?php include 'footer.php'; ?>