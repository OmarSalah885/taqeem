<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Generate CSRF token if needed
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle form submission in this file
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF check
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $errors[] = 'Invalid CSRF token';
    }

    // Validate and sanitize inputs
    $place_id    = (int)($_POST['place_id'] ?? 0);
    $name        = trim($_POST['name'] ?? '');
    $price       = $_POST['price'] ?? '';
    $description = trim($_POST['description'] ?? '');
    $tags        = trim($_POST['tags'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    $email       = trim($_POST['email'] ?? '');
    $phone_1     = trim($_POST['phone_1'] ?? '');
    $phone_2     = trim($_POST['phone_2'] ?? '');
    $website     = trim($_POST['website'] ?? '');

    // Basic validation
    if (!$name) $errors[] = 'Name is required.';
    if (!$price) $errors[] = 'Price is required.';
    if (!$description) $errors[] = 'Description is required.';
    // ... add other validations as needed

    if (empty($errors)) {
        // Update places table
        $stmt = $conn->prepare(
            "UPDATE places SET name=?, price=?, description=?, tags=?, category_id=?, email=?, phone_1=?, phone_2=?, website=? WHERE id=? AND user_id=?"
        );
        $stmt->bind_param(
            "ssssisissiii",
            $name, $price, $description, $tags, $category_id,
            $email, $phone_1, $phone_2, $website,
            $place_id, $_SESSION['user_id']
        );
        $stmt->execute();
        $stmt->close();

        // TODO: handle featured image upload, gallery uploads/removals,
        // opening hours save, menu items save, faqs save

        // Refresh CSRF token
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        // You can set a success message
        $success = 'Place updated successfully.';
    }
}

// After handling POST (or on GET), fetch the fresh data
if (!isset($_GET['place_id']) || !is_numeric($_GET['place_id'])) {
    die("Invalid Place ID");
}
$place_id = (int)$_GET['place_id'];
$user_id  = $_SESSION['user_id'];

// Fetch place
$stmt = $conn->prepare("SELECT * FROM places WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $place_id, $user_id);
$stmt->execute();
$place = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$place) die("Place not found or access denied");

// Fetch other data...
$cats = $conn->query("SELECT id, name FROM categories ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);

$ohStmt = $conn->prepare("SELECT day, open_time, close_time FROM opening_hours WHERE place_id = ?");
$ohStmt->bind_param("i", $place_id);
$ohStmt->execute();
$hours = $ohStmt->get_result()->fetch_all(MYSQLI_ASSOC);
$ohStmt->close();
$hours_map = [];
foreach ($hours as $h) {
    $hours_map[$h['day']] = $h;
}

$galleryStmt = $conn->prepare("SELECT id, image_url FROM place_gallery WHERE place_id = ?");
$galleryStmt->bind_param("i", $place_id);
$galleryStmt->execute();
$gallery_images = $galleryStmt->get_result();
$galleryStmt->close();

$menuStmt = $conn->prepare("SELECT id, name, price, description, image FROM menu_items WHERE place_id = ?");
$menuStmt->bind_param("i", $place_id);
$menuStmt->execute();
$menu_items = $menuStmt->get_result();
$menuStmt->close();

$faqStmt = $conn->prepare("SELECT id, question, answer FROM faqs WHERE place_id = ?");
$faqStmt->bind_param("i", $place_id);
$faqStmt->execute();
$faq_list = $faqStmt->get_result();
$faqStmt->close();

include 'header.php';
?>

<main class="add-place">
  <?php if (!empty($errors)): ?>
    <div class="errors"><ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div>
  <?php elseif (!empty($success)): ?>
    <div class="success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <div class="add-place_sidebar">
    <a href="#add-place-general">GENERAL</a>
    <a href="#add-place-highlight">HIGHLIGHTS</a>
    <a href="#add-place-location">LOCATION</a>
    <a href="#add-place-contact">CONTACT INFO</a>
    <a href="#add-place-social">SOCIAL NETWORKS</a>
    <a href="#add-place-opening">OPENING HOURS</a>
    <a href="#add-place-media">MEDIA</a>
    <a href="#add-place-menu">MENU</a>
    <a href="#add-place-faqs">FAQs</a>
  </div>

  <form class="add-place_main" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="place_id" value="<?= $place_id ?>">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <!-- GENERAL SECTION -->
    <div id="add-place-general" class="add-place_main--item add-place_main--general">
      <h2 class="add-place_title">GENERAL</h2>
      <div class="side-by-side_inbut">
        <input type="text" name="name" placeholder="PLACE NAME"
               class="input--red"
               value="<?= htmlspecialchars($_POST['name'] ?? $place['name']) ?>" required>
        <select name="price" class="input--red" required>
          <option value="" disabled>PRICE</option>
          <?php foreach (['$', '$$', '$$$'] as $p): ?>
            <option value="<?= $p ?>" <?= (($_POST['price'] ?? $place['price']) === $p) ? 'selected' : '' ?>><?= $p ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <textarea name="description" placeholder="DESCRIPTION …" required><?= htmlspecialchars($_POST['description'] ?? $place['description']) ?></textarea>
      <div class="side-by-side_inbut">
        <input type="text" name="tags" placeholder="TAGS (comma-separated)"
               class="input--red"
               value="<?= htmlspecialchars($_POST['tags'] ?? $place['tags']) ?>">
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
    <option value="" disabled <?= (empty($_POST['category_id']) && $place['category_id']==0) ? 'selected' : '' ?>>CATEGORY</option>
    <?php foreach ($cats as $cat): ?>
        <?php
            $raw = strtolower($cat['name']);
            $display = $category_names[$raw] ?? htmlspecialchars($cat['name']);
            $selected = (($_POST['category_id'] ?? $place['category_id']) == $cat['id']) ? 'selected' : '';
        ?>
        <option value="<?= $cat['id'] ?>" <?= $selected ?> >
            <?= $display ?>
        </option>
    <?php endforeach; ?>
</select>
      </div>
    </div>

    <!-- CONTACT INFO SECTION -->
    <div id="add-place-contact" class="add-place_main--item add-place_main--contact">
      <h2 class="add-place_title">CONTACT INFO</h2>
      <input type="email" name="email" placeholder="EMAIL"
             class="input--red"
             value="<?= htmlspecialchars($_POST['email'] ?? $place['email']) ?>">
      <input type="text" name="phone_1" placeholder="PHONE NUMBER 1"
             class="input--red"
             value="<?= htmlspecialchars($_POST['phone_1'] ?? $place['phone_1']) ?>">
      <input type="text" name="phone_2" placeholder="PHONE NUMBER 2 (OPTIONAL)"
             class="input--red"
             value="<?= htmlspecialchars($_POST['phone_2'] ?? $place['phone_2']) ?>">
      <input type="url" name="website" placeholder="WEBSITE (OPTIONAL)"
             class="input--red"
             value="<?= htmlspecialchars($_POST['website'] ?? $place['website']) ?>">
    </div>

    <!-- SOCIAL NETWORKS SECTION -->
    <div id="add-place-social" class="add-place_main--item add-place_main--social">
      <h2 class="add-place_title">SOCIAL NETWORKS</h2>
      <input type="url" name="facebook_url" placeholder="FACEBOOK URL"
             class="input--red"
             value="<?= htmlspecialchars($_POST['facebook_url'] ?? $place['facebook_url']) ?>">
      <input type="url" name="instagram_url" placeholder="INSTAGRAM URL"
             class="input--red"
             value="<?= htmlspecialchars($_POST['instagram_url'] ?? $place['instagram_url']) ?>">
      <input type="url" name="twitter_url" placeholder="TWITTER URL"
             class="input--red"
             value="<?= htmlspecialchars($_POST['twitter_url'] ?? $place['twitter_url']) ?>">
    </div>

    <!-- OPENING HOURS SECTION -->
    <div id="add-place-opening" class="add-place_main--item add-place_main--opening">
      <h2 class="add-place_title">OPENING HOURS</h2>
      <?php
        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        foreach ($days as $day):
          $o = $_POST['open_time'][$day]   ?? ($hours_map[$day]['open_time']   ?? '09:00');
          $c = $_POST['close_time'][$day]  ?? ($hours_map[$day]['close_time']  ?? '17:00');
      ?>
      <div class="side-by-side_inbut">
        <input type="text" class="input--red" value="<?= $day ?>" readonly>
        <div class="side-by-side_inbut">
          <input type="time" name="open_time[<?= $day ?>]" class="input--red" value="<?= $o ?>">
          <input type="time" name="close_time[<?= $day ?>]" class="input--red" value="<?= $c ?>">
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- MEDIA -->
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
        <div class="file-list"></div>
      </div>
    </div>

    <div class="media-contanier_gallery">
      <p class="media-contanier_title">GALLERY IMAGES</p>
      <div class="drop-area">
        <p><i class="fa-solid fa-arrow-up"></i> Drag & Drop files here
          <label for="fileInput2" class="browse-btn"></label>
        </p>
        <input type="file" id="fileInput2" name="gallery_images[]" class="file-input" accept="image/*" multiple hidden>
        <div class="file-list"></div>
      </div>
    </div>
  </div>

  <div class="media_added">
    <div class="media_added--fetured">
      <h3 class="media_added--title">ADDED FETURED IMAGE</h3>
      <div class="media_added--fetured_img">
        <?php if (!empty($place['featured_image'])): ?>
          <div class="media_added--fetured_img_item">
            <img src="<?= $place['featured_image'] ?>">
            <button type="button" class="remove-featured">X</button>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="media_added--gallery">
      <h3 class="media_added--title">ADDED IMAGES FOR GALLERY</h3>
      <div class="media_added--gallery_grid" id="existing-gallery">
        <?php while ($img = $gallery_images->fetch_assoc()): ?>
          <div class="media_added--gallery_grid_item" data-id="<?= $img['id'] ?>">
            <img src="<?= $img['image_url'] ?>">
            <button type="button" class="delete-gallery" data-id="<?= $img['id'] ?>">×</button>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</div>



    <!-- MENU -->
      <!-- MENU (Edit) -->
  <div class="add-place_main--item add-place_main--menu" id="edit-place-menu">
    <h2 class="add-place_title">EDIT MENU</h2>
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
    <button type="button" id="editMenuItemBtn" class="btn__red--s btn__red btn">EDIT ITEM</button>
    <div class="add-menu_added">
        <h3>EDITED MENU ITEMS</h3>
        <div class="add-menu_added-grid" id="menuItemsContainer">
            <!-- Dynamic edited items will be added here -->
        </div>
    </div>
    <input type="hidden" name="menu_items_data" id="menuItemsInput">
</div>



    <!-- FAQS -->
    <div id="add-place-faqs" class="add-place_main--item add-place_main--faqs">
      <h2 class="add-place_title">FAQs</h2>
      <div class="added-faqs-grid" id="existing-faqs">
        <?php while ($f = $faq_list->fetch_assoc()): ?>
          <div class="faq-item" data-id="<?= $f['id'] ?>">
            <p><strong>Q:</strong> <?= htmlspecialchars($f['question']) ?></p>
            <p><strong>A:</strong> <?= htmlspecialchars($f['answer']) ?></p>
            <button type="button" class="delete-faq" data-id="<?= $f['id'] ?>">×</button>
          </div>
        <?php endwhile; ?>
      </div>
      <button type="button" id="add-faq-btn" class="btn__red btn">ADD QUESTION</button>
      <div id="faqs-container"></div>
      <input type="hidden" name="faq_items_data" id="faqItemsInput">
    </div>

    <button type="submit" class="btn__red--l btn__red btn">UPDATE PLACE</button>
  </form>
</main>

<script>
(() => {
  // === FEATURED IMAGE ===
  const featInput = document.getElementById('fileInput1');
  const featContainer = document.querySelector('.media_added--fetured_img');

  function bindRemoveFeatured() {
    const btn = featContainer.querySelector('.remove-featured');
    if (btn) {
      btn.onclick = () => {
        featInput.value = '';
        featContainer.innerHTML = '';
      };
    }
  }

  featInput.addEventListener('change', () => {
    const file = featInput.files[0];
    if (!file) return;

    const existingImage = featContainer.querySelector('img');
    if (existingImage) {
      const confirmReplace = confirm("A featured image already exists. Do you want to replace it?");
      if (!confirmReplace) {
        featInput.value = '';
        return;
      }
    }

    const reader = new FileReader();
    reader.onload = e => {
      featContainer.innerHTML = `
        <div class="media_added--fetured_img_item">
          <img src="${e.target.result}">
          <button type="button" class="remove-featured">X</button>
        </div>
      `;
      bindRemoveFeatured();
    };
    reader.readAsDataURL(file);
  });

  // Initial binding if featured image comes from PHP
  bindRemoveFeatured();


  // === GALLERY IMAGES ===
  const galInput = document.getElementById('fileInput2');
  const galContainer = document.querySelector('.media_added--gallery_grid');
  let galleryFiles = [];

  // Remove existing PHP-loaded gallery image via DOM (simulate AJAX delete)
  function bindExistingGalleryRemoveButtons() {
    galContainer.querySelectorAll('.delete-gallery').forEach(btn => {
      btn.onclick = () => {
        const item = btn.closest('.media_added--gallery_grid_item');
        if (item) {
          item.remove();
        }
      };
    });
  }

  // Remove dynamically added gallery image
  function bindNewGalleryRemoveButtons() {
    galContainer.querySelectorAll('.remove-gallery').forEach(btn => {
      btn.onclick = () => {
        const index = parseInt(btn.dataset.index);
        galleryFiles.splice(index, 1);
        updateGalInputFiles();
        renderGalleryPreviews();
      };
    });
  }

galInput.addEventListener('change', () => {
  const newFiles = Array.from(galInput.files);
  const existingCount = galContainer.querySelectorAll('.media_added--gallery_grid_item').length;

  // Add the new files to the galleryFiles array first
  galleryFiles = galleryFiles.concat(newFiles);

  // Now, check if the total number of files (existing + newly added) exceeds the limit (6)
  if (galleryFiles.length + existingCount > 7) {
    alert(`You can upload a maximum of 6 gallery images.`);
    
    // Remove the newly added files from galleryFiles array as the limit is exceeded
    galleryFiles = galleryFiles.slice(0, galleryFiles.length - newFiles.length);
    galInput.value = ''; // Reset input so the user can try again with fewer files
    return;
  }

  // Proceed with updating the gallery
  updateGalInputFiles();
  renderGalleryPreviews();

  // Clear the input after the operation is done
  galInput.value = '';
});



  function renderGalleryPreviews() {
    // Remove previously JS-added images (with .remove-gallery)
    galContainer.querySelectorAll('.remove-gallery')
      .forEach(btn => btn.closest('.media_added--gallery_grid_item').remove());

    galleryFiles.forEach((file, idx) => {
      const reader = new FileReader();
      reader.onload = e => {
        const wrapper = document.createElement('div');
        wrapper.classList.add('media_added--gallery_grid_item');
        wrapper.innerHTML = `
          <img src="${e.target.result}">
          <button type="button" class="remove-gallery" data-index="${idx}">X</button>
        `;
        galContainer.appendChild(wrapper);
        bindNewGalleryRemoveButtons();
      };
      reader.readAsDataURL(file);
    });
  }

  function updateGalInputFiles() {
    const dt = new DataTransfer();
    galleryFiles.forEach(f => dt.items.add(f));
    galInput.files = dt.files;
  }

  // Initial binding for PHP gallery images
  bindExistingGalleryRemoveButtons();

})();
</script>







<script>
const addMenuItemBtn = document.getElementById('addMenuItemBtn');
const menuItemsContainer = document.getElementById('menuItemsContainer');
const menuItemsInput = document.getElementById('menuItemsInput');
let menuItems = [];

addMenuItemBtn.addEventListener('click', async () => {
    const name = document.getElementById('menuItemName').value.trim();
    const price = document.getElementById('menuItemPrice').value.trim();
    const description = document.getElementById('menuItemDescription').value.trim();
    const fileInput = document.getElementById('fileInput3');
    const file = fileInput.files[0];

    if (!name || !price || !description || !file) {
        alert('Please fill all fields and select an image.');
        return;
    }

    const base64 = await toBase64(file);

    const item = { name, price, description, image: base64 };
    menuItems.push(item);

    const itemDiv = document.createElement('div');
    itemDiv.className = 'add-menu_added-grid_item';
    itemDiv.innerHTML = `
        <img src="${base64}" alt="">
        <div class="add-menu_added-grid_item--info">
            <h4>${name}</h4>
            <p>${description}</p>
            <p>${price}</p>
        </div>
        <a href="#" class="delete-menu-item">X</a>
    `;
    menuItemsContainer.appendChild(itemDiv);

    updateHiddenInput();
    clearInputs();
});

menuItemsContainer.addEventListener('click', (e) => {
    if (e.target.classList.contains('delete-menu-item')) {
        e.preventDefault();
        const itemDiv = e.target.closest('.add-menu_added-grid_item');
        const index = Array.from(menuItemsContainer.children).indexOf(itemDiv);
        menuItems.splice(index, 1);
        itemDiv.remove();
        updateHiddenInput();
    }
});

function updateHiddenInput() {
    menuItemsInput.value = JSON.stringify(menuItems);
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
</script>




<script>
    const faqQuestionInput = document.querySelector('#add-place-faqs input[placeholder="QUESTION"]');
    const faqAnswerInput = document.querySelector('#add-place-faqs input[placeholder="ANSWER"]');
    const addFaqBtn = document.querySelector('#add-place-faqs .btn');
    const addedFaqsContainer = document.querySelector('.added-faqs-grid');
    const faqs = [];

    function renderFaqs() {
        addedFaqsContainer.innerHTML = '';
        faqs.forEach((faq, index) => {
            const div = document.createElement('div');
            div.className = 'added-faqs-grid_item';
            div.innerHTML = `
                <h4>${faq.question}</h4>
                <p>${faq.answer}</p>
                <button onclick="removeFaq(${index})">X</button>
                <input type="hidden" name="faq_questions[]" value="${faq.question}">
                <input type="hidden" name="faq_answers[]" value="${faq.answer}">
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

    window.removeFaq = removeFaq; // make it accessible from inline onclick
</script>
<?php include 'footer.php'; ?>
