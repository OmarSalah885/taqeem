<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();



function sanitizeInput($input, $type = 'string') {
    $input = trim($input);
    switch ($type) {
        case 'email':
            return filter_var($input, FILTER_VALIDATE_EMAIL);
        case 'url':
            return filter_var($input, FILTER_VALIDATE_URL);
        case 'int':
            return (int)$input;
        case 'string':
        default:
            return htmlspecialchars($input);
    }
}
function normalizeName($name) {
                return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $name)));
}
if (!isset($_GET['place_id']) || !is_numeric($_GET['place_id'])) {
    die("Invalid Place ID");
}
$place_id = (int)$_GET['place_id'];
$user_id  = $_SESSION['user_id'];
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

    // Sanitize inputs
    $data = [
        'name' => sanitizeInput($_POST['name']),
        'price' => sanitizeInput($_POST['price']),
        'description' => sanitizeInput($_POST['description']),
        'tags' => sanitizeInput($_POST['tags']),
        'category_id' => sanitizeInput($_POST['category_id'], 'int'),
        'email' => sanitizeInput($_POST['email'], 'email'),
        'phone_1' => sanitizeInput($_POST['phone_1']),
        'phone_2' => sanitizeInput($_POST['phone_2']),
        'website' => sanitizeInput($_POST['website'], 'url'),
        'facebook_url' => sanitizeInput($_POST['facebook_url'], 'url'),
        'instagram_url' => sanitizeInput($_POST['instagram_url'], 'url'),
        'twitter_url' => sanitizeInput($_POST['twitter_url'], 'url'),
    ];

    // Validate required fields
    if (!$data['name']) $errors[] = 'Name is required.';
    if (!$data['price']) $errors[] = 'Price is required.';
    if (!$data['description']) $errors[] = 'Description is required.';
    if (!$data['category_id']) $errors[] = 'Category is required.';
    if (!$data['email']) $errors[] = 'A valid email is required.';
    if (!$data['phone_1']) $errors[] = 'Phone number 1 is required.';

    // Validate opening hours
    $opening_hours = $_POST['open_time'] ?? [];
    $closing_hours = $_POST['close_time'] ?? [];
    foreach ($opening_hours as $day => $open_time) {
        $close_time = $closing_hours[$day] ?? '17:00';
        if (strtotime($close_time) <= strtotime($open_time)) {
            $errors[] = "Closing time for $day must be after opening time.";
        }
    }

    if (empty($errors)) {
        $conn->begin_transaction();

        try {
            // Fetch category name for folder structure
            $cat_stmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
            $cat_stmt->bind_param("i", $data['category_id']);
            $cat_stmt->execute();
            $cat_result = $cat_stmt->get_result();
            $category = $cat_result->fetch_assoc();
            $cat_stmt->close();

            $category_name_safe = $category['name'];
            $place_name_safe = normalizeName($data['name']);

            // Update place
            updatePlace($conn, $place_id, $_SESSION['user_id'], $data);

            // Update opening hours
            updateOpeningHours($conn, $place_id, $opening_hours, $closing_hours);

            // Update gallery
            $existingGalleryIds = $_POST['existing_gallery_ids'] ?? [];
            $newGalleryFiles = $_FILES['gallery_images'] ?? [];
            error_log("Existing gallery IDs: " . print_r($_POST['existing_gallery_ids'], true));
            error_log("Existing gallery IDs received in POST: " . print_r($_POST['existing_gallery_ids'], true));
            updateGallery($conn, $place_id, $existingGalleryIds, $newGalleryFiles, $category_name_safe, $place_name_safe);

            // Update featured image
            updateFeaturedImage($conn, $place_id, $_FILES['featured_image'], $category_name_safe, $place_name_safe);

            // Commit transaction
            $conn->commit();

            $success = 'Place updated successfully.';
        } catch (Exception $e) {
            $conn->rollback();
            $errors[] = 'Failed to update place. Please try again.';
        }
    }

    // Display success or error messages
    if (!empty($success)) {
        echo "<script>window.onload = function() { alert('" . addslashes($success) . "'); }</script>";
    }

    if (!empty($errors)) {
        $error_message = implode("\\n", array_map('addslashes', $errors));
        echo "<script>window.onload = function() { alert('" . $error_message . "'); }</script>";
    }
}

error_log("FILES array: " . print_r($_FILES, true));


// Fetch place
$place = fetchPlaceData($conn, $place_id, $_SESSION['user_id']);
$hours_map = fetchOpeningHours($conn, $place_id);

// Fetch other data...
$cats = $conn->query("SELECT id, name FROM categories ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);

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
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        foreach ($days as $day):
          $o = $_POST['open_time'][$day] ?? ($hours_map[$day]['open_time'] ?? '09:00');
          $c = $_POST['close_time'][$day] ?? ($hours_map[$day]['close_time'] ?? '17:00');
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
      <input type="checkbox" name="remove_featured_image" value="1"> Remove Featured Image
    </div>

    <div class="media-contanier_gallery">
      <p class="media-contanier_title">GALLERY IMAGES</p>
      <div class="drop-area">
        <p><i class="fa-solid fa-arrow-up"></i> Drag & Drop files here
          <label for="fileInput2" class="browse-btn"></label>
        </p>
        <input type="file" id="fileInput2" name="gallery_images[]" class="file-input" accept="image/*" multiple>
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
      <input type="hidden" name="existing_gallery_ids[]" value="1">
      <input type="hidden" name="existing_gallery_ids[]" value="2">
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
  const galInput = document.getElementById('fileInput2');
  const galContainer = document.querySelector('.media_added--gallery_grid');
  let galleryFiles = [];           // New JS-added files
  let existingGalleryIds = [];     // IDs of PHP-loaded images

  // 1) Initialize existingGalleryIds from any PHP-loaded items
  document.querySelectorAll('.media_added--gallery_grid_item[data-id]').forEach(item => {
    existingGalleryIds.push(parseInt(item.dataset.id, 10));
  });
  console.log("Existing gallery IDs on page load:", existingGalleryIds);

  // 2) Remove PHP-loaded images
  function bindExistingGalleryRemoveButtons() {
    galContainer.querySelectorAll('.delete-gallery').forEach(btn => {
      btn.onclick = () => {
        const item = btn.closest('.media_added--gallery_grid_item');
        const id = parseInt(btn.dataset.id, 10);
        existingGalleryIds = existingGalleryIds.filter(x => x !== id); // Remove the ID from the array
        item.remove();
        updateGalleryCount();
        updateHiddenInput(); // Update the hidden input fields
        console.log("Updated existingGalleryIds:", existingGalleryIds); // Log the updated array
      };
    });
  }

  // 3) Remove JS-added images
  function bindNewGalleryRemoveButtons() {
    galContainer.querySelectorAll('.remove-gallery').forEach(btn => {
      btn.onclick = () => {
        const idx = parseInt(btn.dataset.index, 10);
        galleryFiles.splice(idx, 1); // Remove the file from the array
        updateGalInputFiles();
        renderGalleryPreviews();
        updateGalleryCount();
      };
    });
  }

  // 4) Handle new file selection
  galInput.addEventListener('change', () => {
    const newFiles = Array.from(galInput.files);
    console.log("New files selected:", newFiles); // Log the selected files
    const totalNow = galleryFiles.length + existingGalleryIds.length;
    const remainingSlots = 8 - totalNow;

    if (newFiles.length > remainingSlots) {
      alert(`You can only add ${remainingSlots} more image(s).`);
      return;
    }

    galleryFiles = galleryFiles.concat(newFiles); // Add new files to the array
    console.log("Updated galleryFiles array:", galleryFiles); // Log the updated array
    updateGalInputFiles();
    renderGalleryPreviews();
    updateGalleryCount();
  });

  // 5) Render previews for new images
  function renderGalleryPreviews() {
    // Remove old JS-added previews
    galContainer.querySelectorAll('.remove-gallery')
      .forEach(btn => btn.closest('.media_added--gallery_grid_item').remove());

    galleryFiles.forEach((file, idx) => {
      const reader = new FileReader();
      reader.onload = e => {
        const div = document.createElement('div');
        div.classList.add('media_added--gallery_grid_item');
        div.innerHTML = `
          <img src="${e.target.result}">
          <button type="button" class="remove-gallery" data-index="${idx}">X</button>
        `;
        galContainer.appendChild(div);
        bindNewGalleryRemoveButtons();
      };
      reader.readAsDataURL(file);
    });
  }

  // 6) Update the file input with new files
  function updateGalInputFiles() {
    const dt = new DataTransfer();
    galleryFiles.forEach(f => dt.items.add(f));
    galInput.files = dt.files;
  }

  // 7) Update the gallery count
  function updateGalleryCount() {
    const total = galleryFiles.length + existingGalleryIds.length;
    console.log(`Total images now: ${total} / 8`);
  }

  // 8) Update hidden inputs for existing gallery IDs
  function updateHiddenInput() {
    const hiddenInputs = document.querySelectorAll('input[name="existing_gallery_ids[]"]');
    hiddenInputs.forEach(input => input.remove()); // Remove old inputs

    existingGalleryIds.forEach(id => {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'existing_gallery_ids[]';
      input.value = id;
      document.querySelector('form.add-place_main').appendChild(input);
    });
  }

  // Log the galInput field before form submission
  const form = document.querySelector('form.add-place_main');
  form.addEventListener('submit', (e) => {
    console.log("Files in galInput before submission:", galInput.files);
  });

  bindExistingGalleryRemoveButtons();
  updateGalleryCount();
})();
</script>

<script>
(() => {
  const featuredRemoveBtn = document.querySelector('.remove-featured');
  const featuredInput = document.querySelector('input[name="featured_image"]');

  if (featuredRemoveBtn) {
    featuredRemoveBtn.addEventListener('click', () => {
      if (confirm("Are you sure you want to remove the featured image?")) {
        featuredInput.value = ''; // Clear the input value
        featuredRemoveBtn.closest('.media_added--fetured_img_item').remove();
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'remove_featured_image';
        hiddenInput.value = '1';
        document.querySelector('form.add-place_main').appendChild(hiddenInput);
      }
    });
  }
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

<?php
function updatePlace($conn, $place_id, $user_id, $data) {
    $stmt = $conn->prepare("
        UPDATE places
        SET name = ?, price = ?, description = ?, tags = ?, category_id = ?, email = ?, phone_1 = ?, phone_2 = ?, website = ?, facebook_url = ?, instagram_url = ?, twitter_url = ?
        WHERE id = ? AND user_id = ?
    ");
    $stmt->bind_param(
        "ssssisssssssii",
        $data['name'], $data['price'], $data['description'], $data['tags'], $data['category_id'],
        $data['email'], $data['phone_1'], $data['phone_2'], $data['website'],
        $data['facebook_url'], $data['instagram_url'], $data['twitter_url'],
        $place_id, $user_id
    );
    $stmt->execute();
    $stmt->close();
}

function updateOpeningHours($conn, $place_id, $opening_hours, $closing_hours) {
    // Delete existing opening hours
    $deleteStmt = $conn->prepare("DELETE FROM opening_hours WHERE place_id = ?");
    $deleteStmt->bind_param("i", $place_id);
    $deleteStmt->execute();
    $deleteStmt->close();

    // Insert updated opening hours
    $insertStmt = $conn->prepare("
        INSERT INTO opening_hours (place_id, day, open_time, close_time)
        VALUES (?, ?, ?, ?)
    ");
    foreach ($opening_hours as $day => $open_time) {
        $close_time = $closing_hours[$day] ?? '17:00';
        $insertStmt->bind_param("isss", $place_id, $day, $open_time, $close_time);
        $insertStmt->execute();
    }
    $insertStmt->close();
}

function updateGallery($conn, $place_id, $existingGalleryIds, $newGalleryFiles, $category_name_safe, $place_name_safe) {
    // Define the gallery directory for this place
    $gallery_dir = __DIR__ . "/assets/images/places/{$category_name_safe}/{$place_name_safe}/gallery/";
    if (!is_dir($gallery_dir)) {
        mkdir($gallery_dir, 0755, true);
        error_log("Created gallery directory: $gallery_dir");
    }

    // Fetch current gallery images from the database
    $stmt = $conn->prepare("SELECT id, image_url FROM place_gallery WHERE place_id = ?");
    $stmt->bind_param("i", $place_id);
    $stmt->execute();
    $currentGallery = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Delete removed images from the file system and database
    foreach ($currentGallery as $image) {
        if (!in_array($image['id'], $existingGalleryIds)) {
            // Log the image being deleted
            error_log("Deleting image: ID={$image['id']}, Path={$image['image_url']}");

            // Delete from file system
            $filePath = __DIR__ . '/' . $image['image_url'];
            if (file_exists($filePath)) {
                unlink($filePath);
                error_log("Deleted file: $filePath");
            }

            // Delete from database
            $deleteStmt = $conn->prepare("DELETE FROM place_gallery WHERE id = ?");
            $deleteStmt->bind_param("i", $image['id']);
            $deleteStmt->execute();
            $deleteStmt->close();
            error_log("Deleted image from database: ID={$image['id']}");
        }
    }

    // Add new images only if files are uploaded
    if (!empty($newGalleryFiles['tmp_name'][0])) {
        foreach ($newGalleryFiles['tmp_name'] as $index => $tmpName) {
            if ($newGalleryFiles['error'][$index] === UPLOAD_ERR_OK) {
                $filename = uniqid('gal_', true) . '_' . basename($newGalleryFiles['name'][$index]);
                $targetFile = $gallery_dir . $filename;

                // Log the file being uploaded
                error_log("Uploading file: {$newGalleryFiles['name'][$index]} to $targetFile");

                if (move_uploaded_file($tmpName, $targetFile)) {
                    error_log("File uploaded successfully: $targetFile");

                    // Insert into database
                    $path = "assets/images/places/{$category_name_safe}/{$place_name_safe}/gallery/" . $filename;
                    $insertStmt = $conn->prepare("INSERT INTO place_gallery (place_id, image_url) VALUES (?, ?)");
                    $insertStmt->bind_param("is", $place_id, $path);
                    if ($insertStmt->execute()) {
                        error_log("Image inserted into database: $path");
                    } else {
                        error_log("Failed to insert image into database: " . $insertStmt->error);
                    }
                    $insertStmt->close();
                } else {
                    error_log("Failed to upload file: {$newGalleryFiles['name'][$index]}");
                }
            } else {
                error_log("File upload error: {$newGalleryFiles['error'][$index]} for file {$newGalleryFiles['name'][$index]}");
            }
        }
    } else {
        error_log("No new gallery files uploaded.");
    }
}

function updateFeaturedImage($conn, $place_id, $featuredImageFile, $category_name_safe, $place_name_safe) {
    // Define the featured directory for this place
    $featured_dir = __DIR__ . "/assets/images/places/{$category_name_safe}/{$place_name_safe}/featured/";
    if (!is_dir($featured_dir)) {
        mkdir($featured_dir, 0755, true);
    }

    // Check if the featured image should be removed
    if (!empty($_POST['remove_featured_image'])) {
        $stmt = $conn->prepare("SELECT featured_image FROM places WHERE id = ?");
        $stmt->bind_param("i", $place_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!empty($result['featured_image']) && file_exists(__DIR__ . '/' . $result['featured_image'])) {
            unlink(__DIR__ . '/' . $result['featured_image']);
        }

        // Remove the featured image from the database
        $updateStmt = $conn->prepare("UPDATE places SET featured_image = NULL WHERE id = ?");
        $updateStmt->bind_param("i", $place_id);
        $updateStmt->execute();
        $updateStmt->close();
        return;
    }

    // Upload the new featured image
    if (!empty($featuredImageFile['tmp_name'])) {
        $filename = uniqid('feat_', true) . '_' . basename($featuredImageFile['name']);
        $targetFile = $featured_dir . $filename;

        if (move_uploaded_file($featuredImageFile['tmp_name'], $targetFile)) {
            // Update the database
            $path = "assets/images/places/{$category_name_safe}/{$place_name_safe}/featured/" . $filename;
            $updateStmt = $conn->prepare("UPDATE places SET featured_image = ? WHERE id = ?");
            $updateStmt->bind_param("si", $path, $place_id);
            $updateStmt->execute();
            $updateStmt->close();
        }
    }
}

function fetchPlaceData($conn, $place_id, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM places WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $place_id, $user_id);
    $stmt->execute();
    $place = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $place;
}

function fetchOpeningHours($conn, $place_id) {
    $stmt = $conn->prepare("SELECT day, open_time, close_time FROM opening_hours WHERE place_id = ?");
    $stmt->bind_param("i", $place_id);
    $stmt->execute();
    $hours = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $hours_map = [];
    foreach ($hours as $h) {
        $hours_map[$h['day']] = $h;
    }
    return $hours_map;
}
?>
