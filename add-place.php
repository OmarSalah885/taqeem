<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

// Check if user is logged in
$logged_in = isset($_SESSION['user_id']);

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

include 'header.php';

// Initialize variables for the Add Place form
$errors = [];
$cats = [];
$place = [
    'name' => '',
    'price' => '',
    'tags' => '',
    'description' => '',
    'category_id' => '',
    'email' => '',
    'phone_1' => '',
    'phone_2' => '',
    'website' => '',
    'facebook_url' => '',
    'instagram_url' => '',
    'twitter_url' => '',
    'country' => '',
    'city' => '',
    'address' => '',
    'latitude' => '31.9539',
    'longitude' => '35.9106',
    'google_map_location' => '',
];
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
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

function normalizeName($name) {
    return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $name)));
}

// Fetch categories and handle form submission only if logged in
if ($logged_in) {
    // Fetch categories
    $cat_stmt = $conn->prepare("SELECT id, name FROM categories ORDER BY name ASC");
    $cat_stmt->execute();
    $cat_result = $cat_stmt->get_result();
    while ($cat = $cat_result->fetch_assoc()) {
        $cats[] = $cat;
    }
    $cat_stmt->close();

    // Handle POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("Invalid CSRF token");
        }

        // Sanitize inputs
        $place['name'] = trim($_POST['name'] ?? '');
        $place['price'] = $_POST['price'] ?? '';
        $place['tags'] = trim($_POST['tags'] ?? '');
        $place['description'] = trim($_POST['description'] ?? '');
        $place['category_id'] = intval($_POST['category_id'] ?? 0);
        $place['email'] = trim($_POST['email'] ?? '');
        $place['phone_1'] = trim($_POST['phone_1'] ?? '');
        $place['phone_2'] = trim($_POST['phone_2'] ?? '');
        $place['website'] = trim($_POST['website'] ?? '');
        $place['facebook_url'] = trim($_POST['facebook_url'] ?? '');
        $place['instagram_url'] = trim($_POST['instagram_url'] ?? '');
        $place['twitter_url'] = trim($_POST['twitter_url'] ?? '');
        $place['country'] = trim($_POST['country'] ?? '');
        $place['city'] = trim($_POST['city'] ?? '');
        $place['address'] = trim($_POST['address'] ?? '');
        $place['latitude'] = floatval($_POST['latitude'] ?? '31.9539');
        $place['longitude'] = floatval($_POST['longitude'] ?? '35.9106');
        $place['google_map_location'] = trim($_POST['google_map_location'] ?? '');
        $open_time = $_POST['open_time'] ?? [];
        $close_time = $_POST['close_time'] ?? [];

        // Validation
        if ($place['name'] === '') {
            $errors[] = "Place name is required.";
        }
        if (!in_array($place['price'], ['$', '$$', '$$$'])) {
            $errors[] = "Invalid price selected.";
        }
        if ($place['category_id'] <= 0) {
            $errors[] = "Category must be selected.";
        }
        if ($place['email'] !== '' && !filter_var($place['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        }
        if ($place['latitude'] < -90 || $place['latitude'] > 90 || $place['longitude'] < -180 || $place['longitude'] > 180) {
            $errors[] = "Invalid coordinates.";
        }
        if (strlen($place['address']) > 100) {
            $errors[] = "Address is too long (max 100 characters).";
        }

        if (empty($errors)) {
            $conn->begin_transaction();
            try {
                // Get category name
                $cat_stmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
                $cat_stmt->bind_param("i", $place['category_id']);
                $cat_stmt->execute();
                $cat_result = $cat_stmt->get_result();
                $category_row = $cat_result->fetch_assoc();
                $cat_stmt->close();
                $category_name_safe = $category_row['name'] ?? '';
                $place_name_safe = normalizeName($place['name']);

                // Insert place
                $insert_stmt = $conn->prepare("
                    INSERT INTO places (
                        name, price, tags, description, category_id, user_id, email, phone_1, phone_2, website, created_at,
                        facebook_url, instagram_url, twitter_url, country, city, address, latitude, longitude, google_map_location
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $insert_stmt->bind_param(
                    "sssssissssssssssdds",
                    $place['name'], $place['price'], $place['tags'], $place['description'], $place['category_id'], $_SESSION['user_id'],
                    $place['email'], $place['phone_1'], $place['phone_2'], $place['website'],
                    $place['facebook_url'], $place['instagram_url'], $place['twitter_url'],
                    $place['country'], $place['city'], $place['address'], $place['latitude'], $place['longitude'], $place['google_map_location']
                );
                $insert_stmt->execute();
                $place_id = $conn->insert_id;
                $insert_stmt->close();

                // Insert opening hours
                $oh_stmt = $conn->prepare("INSERT INTO opening_hours (place_id, day, open_time, close_time) VALUES (?, ?, ?, ?)");
                foreach ($open_time as $day => $open) {
                    $close = $close_time[$day] ?? '';
                    $oh_stmt->bind_param("isss", $place_id, $day, $open, $close);
                    $oh_stmt->execute();
                }
                $oh_stmt->close();

                // Handle featured image
                if (!empty($_FILES['featured_image']['tmp_name'])) {
                    $featured_dir = __DIR__ . "/assets/images/places/{$category_name_safe}/{$place_name_safe}/featured/";
                    if (!is_dir($featured_dir)) {
                        mkdir($featured_dir, 0755, true);
                    }
                    $filename = uniqid('feat_', true) . '_' . basename($_FILES['featured_image']['name']);
                    $targetFile = $featured_dir . $filename;
                    if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $targetFile)) {
                        throw new Exception("Failed to upload featured image.");
                    }
                    $path = "assets/images/places/{$category_name_safe}/{$place_name_safe}/featured/" . $filename;
                    $updateStmt = $conn->prepare("UPDATE places SET featured_image = ? WHERE id = ?");
                    $updateStmt->bind_param("si", $path, $place_id);
                    $updateStmt->execute();
                    $updateStmt->close();
                }

                // Handle gallery images
                if (!empty($_FILES['gallery_images']['tmp_name'][0])) {
                    $gallery_dir = __DIR__ . "/assets/images/places/{$category_name_safe}/{$place_name_safe}/gallery/";
                    if (!is_dir($gallery_dir)) {
                        mkdir($gallery_dir, 0755, true);
                    }
                    foreach ($_FILES['gallery_images']['tmp_name'] as $i => $tmpName) {
                        if ($_FILES['gallery_images']['error'][$i] === UPLOAD_ERR_OK) {
                            $filename = uniqid('gal_', true) . '_' . basename($_FILES['gallery_images']['name'][$i]);
                            $targetFile = $gallery_dir . $filename;
                            if (!move_uploaded_file($tmpName, $targetFile)) {
                                throw new Exception("Failed to upload gallery image: $filename");
                            }
                            $path = "assets/images/places/{$category_name_safe}/{$place_name_safe}/gallery/" . $filename;
                            $ins_stmt = $conn->prepare("INSERT INTO place_gallery (place_id, image_url) VALUES (?, ?)");
                            $ins_stmt->bind_param("is", $place_id, $path);
                            $ins_stmt->execute();
                            $ins_stmt->close();
                        }
                    }
                }

                // Handle menu items
                $menu_items = json_decode($_POST['menu_items_data'] ?? '[]', true);
                $menu_dir = __DIR__ . "/assets/images/places/{$category_name_safe}/{$place_name_safe}/menu/";
                if (!is_dir($menu_dir)) {
                    mkdir($menu_dir, 0755, true);
                }
                foreach ($menu_items as $item) {
                    $new_img_path = null;
                    if (isset($item['image']) && strpos($item['image'], 'data:image') === 0) {
                        $imgData = explode(',', $item['image'], 2)[1];
                        $imgDecoded = base64_decode($imgData);
                        $ext = preg_match('/^data:image\/(\w+);base64,/', $item['image'], $match) ? strtolower($match[1]) : 'png';
                        if ($ext === 'jpeg') $ext = 'jpg';
                        if (!in_array($ext, ['jpg', 'png', 'gif', 'webp'])) $ext = 'png';
                        $imgName = uniqid('menu_', true) . '.' . $ext;
                        $new_img_path = "assets/images/places/{$category_name_safe}/{$place_name_safe}/menu/" . $imgName;
                        if (!file_put_contents(__DIR__ . '/' . $new_img_path, $imgDecoded)) {
                            throw new Exception("Failed to save menu item image: $imgName");
                        }
                    }
                    if ($new_img_path) {
                        $stmt = $conn->prepare("INSERT INTO menu_items (place_id, name, price, description, image) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("isdss", $place_id, $item['name'], $item['price'], $item['description'], $new_img_path);
                        $stmt->execute();
                        $stmt->close();
                    }
                }

                // Handle FAQs
                $faqs = json_decode($_POST['faqs_data'] ?? '[]', true);
                foreach ($faqs as $faq) {
                    $stmt = $conn->prepare("INSERT INTO faqs (place_id, question, answer) VALUES (?, ?, ?)");
                    $stmt->bind_param("iss", $place_id, $faq['question'], $faq['answer']);
                    $stmt->execute();
                    $stmt->close();
                }

                $conn->commit();
                header("Location: add_place.php?success=1");
                exit;
            } catch (Exception $e) {
                $conn->rollback();
                $errors[] = "Error: " . $e->getMessage();
            }
        }
    }
}
?>

<?php if ($logged_in): ?>
    <!-- Add Place Form -->
    <style>
        .media_added--fetured, .media_added--gallery {
            display: none;
        }
        .media_added--fetured.has-items, .media_added--gallery.has-items {
            display: block;
        }
    </style>

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

        <form class="add-place_main" method="POST" action="add_place.php" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

            <!-- GENERAL SECTION -->
            <div id="add-place-general" class="add-place_main--item add-place_main--general">
                <h2 class="add-place_title">GENERAL</h2>
                <div class="side-by-side_inbut">
                    <input type="text" name="name" placeholder="PLACE NAME" class="input--red" value="<?= htmlspecialchars($place['name']) ?>" required>
                    <select name="price" class="input--red" required>
                        <option value="" disabled <?= empty($place['price']) ? 'selected' : '' ?>>PRICE</option>
                        <option value="$" <?= $place['price'] === '$' ? 'selected' : '' ?>>$</option>
                        <option value="$$" <?= $place['price'] === '$$' ? 'selected' : '' ?>>$$</option>
                        <option value="$$$" <?= $place['price'] === '$$$' ? 'selected' : '' ?>>$$$</option>
                    </select>
                </div>
                <textarea name="description" placeholder="DESCRIPTION …" required><?= htmlspecialchars($place['description']) ?></textarea>
                <div class="side-by-side_inbut">
                    <input type="text" name="tags" placeholder="TAGS (comma-separated)" class="input--red" value="<?= htmlspecialchars($place['tags']) ?>">
                    <select name="category_id" class="input--red" required>
                        <option value="" disabled <?= empty($place['category_id']) ? 'selected' : '' ?>>CATEGORY</option>
                        <?php foreach ($cats as $cat): 
                            $raw = strtolower($cat['name']);
                            $display = $category_names[$raw] ?? htmlspecialchars($cat['name']);
                        ?>
                            <option value="<?= $cat['id'] ?>" <?= ($place['category_id'] == $cat['id']) ? 'selected' : '' ?>>
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
                    <input type="text" name="country" id="country" placeholder="COUNTRY" class="input--red" value="<?= htmlspecialchars($place['country']) ?>">
                    <input type="text" name="city" id="city" placeholder="CITY" class="input--red" value="<?= htmlspecialchars($place['city']) ?>">
                </div>
                <input type="text" name="google_map_location" id="google_map_location" placeholder="Use the map or add the Google Maps link of the place" class="input--red" value="<?= htmlspecialchars($place['google_map_location']) ?>">
                <div class="location-map">
                    <h3 class="location-map_title">SET LOCATION ON MAP</h3>
                    <div id="map" style="height: 400px;"></div>
                    <p>Selected Coordinates: <span id="coordinates"><?= htmlspecialchars($place['latitude']) ?>, <?= htmlspecialchars($place['longitude']) ?></span></p>
                </div>
                <input type="hidden" name="address" id="address" value="<?= htmlspecialchars($place['address']) ?>">
                <input type="hidden" name="latitude" id="latitude" value="<?= htmlspecialchars($place['latitude']) ?>">
                <input type="hidden" name="longitude" id="longitude" value="<?= htmlspecialchars($place['longitude']) ?>">
            </div>

            <!-- CONTACT INFO SECTION -->
            <div id="add-place-contact" class="add-place_main--item add-place_main--contact">
                <h2 class="add-place_title">CONTACT INFO</h2>
                <input type="email" name="email" placeholder="EMAIL" class="input--red" value="<?= htmlspecialchars($place['email']) ?>">
                <input type="text" name="phone_1" placeholder="PHONE NUMBER 1" class="input--red" value="<?= htmlspecialchars($place['phone_1']) ?>">
                <input type="text" name="phone_2" placeholder="PHONE NUMBER 2 (OPTIONAL)" class="input--red" value="<?= htmlspecialchars($place['phone_2']) ?>">
                <input type="url" name="website" placeholder="WEBSITE (OPTIONAL)" class="input--red" value="<?= htmlspecialchars($place['website']) ?>">
            </div>

            <!-- SOCIAL NETWORKS SECTION -->
            <div id="add-place-social" class="add-place_main--item add-place_main--social">
                <h2 class="add-place_title">SOCIAL NETWORKS</h2>
                <input type="url" name="facebook_url" placeholder="FACEBOOK URL" class="input--red" value="<?= htmlspecialchars($place['facebook_url']) ?>">
                <input type="url" name="instagram_url" placeholder="INSTAGRAM URL" class="input--red" value="<?= htmlspecialchars($place['instagram_url']) ?>">
                <input type="url" name="twitter_url" placeholder="TWITTER URL" class="input--red" value="<?= htmlspecialchars($place['twitter_url']) ?>">
            </div>

            <!-- OPENING HOURS SECTION -->
            <div id="add-place-opening" class="add-place_main--item add-place_main--opening">
                <h2 class="add-place_title">OPENING HOURS</h2>
                <?php foreach ($days as $day): ?>
                    <div class="side-by-side_inbut">
                        <input type="text" class="input--red" value="<?= htmlspecialchars($day) ?>" readonly>
                        <div class="side-by-side_inbut">
                            <input type="time" name="open_time[<?= htmlspecialchars($day) ?>]" class="input--red" value="09:00">
                            <input type="time" name="close_time[<?= htmlspecialchars($day) ?>]" class="input--red" value="17:00">
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
                            <input type="file" id="fileInput2" name="gallery_images[]" accept="image/*" multiple hidden>
                        </div>
                    </div>
                </div>
                <div class="media_added">
                    <div class="media_added--fetured">
                        <div class="media_added--fetured_img"></div>
                    </div>
                    <div class="media_added--gallery">
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
                    <div class="add-menu_added-grid" id="menuItemsContainer"></div>
                </div>
                <input type="hidden" name="menu_items_data" id="menuItemsInput">
            </div>

            <!-- FAQS SECTION -->
            <div class="add-place_main--item add-place_main--faqs" id="add-place-faqs">
                <h2 class="add-place_title">FAQs</h2>
                <input type="text" id="faq-question" placeholder="QUESTION" class="input--red">
                <input type="text" id="faq-answer" placeholder="ANSWER" class="input--red">
                <button type="button" class="btn__red--s btn__red btn" id="add-faq-btn">ADD QUESTION</button>
                <div class="added-faqs">
                    <div class="added-faqs-grid" id="faqs-container"></div>
                </div>
                <input type="hidden" name="faqs_data" id="faqsInput">
            </div>

            <button type="submit" class="btn__red--l btn__red btn">ADD PLACE</button>
        </form>
    </main>

    <!-- JavaScript for handling media, menu, and FAQs -->
    <script>
    (() => {
        const dropArea = document.querySelector('.media-contanier_featured .drop-area');
        const fileInput1 = document.getElementById('fileInput1');
        const previewContainer = document.querySelector('.media_added--fetured_img');
        const featuredContainer = document.querySelector('.media_added--fetured');

        function updateFeaturedTitleAndVisibility() {
            let title = document.querySelector('.media_added--fetured h3.media_added--title');
            const hasItems = previewContainer.children.length > 0;
            if (hasItems && !title) {
                previewContainer.insertAdjacentHTML('beforebegin', '<h3 class="media_added--title">ADDED FEATURED IMAGE</h3>');
            } else if (!hasItems && title) {
                title.remove();
            }
            featuredContainer.classList.toggle('has-items', hasItems);
        }

        function clearPreview() {
            previewContainer.innerHTML = '';
            updateFeaturedTitleAndVisibility();
        }

        function showPreview(file) {
            clearPreview();
            const reader = new FileReader();
            reader.onload = e => {
                const wrapper = document.createElement('div');
                wrapper.className = 'media_added--fetured_img_item';
                wrapper.innerHTML = `
                    <img src="${e.target.result}" alt="Featured Image Preview">
                    <button type="button" class="remove-featured">X</button>
                `;
                previewContainer.appendChild(wrapper);
                updateFeaturedTitleAndVisibility();

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
            const galInput = document.getElementById('fileInput2');
            const galContainer = document.querySelector('.media_added--gallery_grid');
            const galDropArea = document.querySelector('.gallery-drop-area');
            const galleryContainer = document.querySelector('.media_added--gallery');
            let galleryFiles = [];

            function updateGalleryTitleAndVisibility() {
                let title = document.querySelector('.media_added--gallery h3.media_added--title');
                const hasItems = galContainer.children.length > 0;
                if (hasItems && !title) {
                    galContainer.insertAdjacentHTML('beforebegin', '<h3 class="media_added--title">ADDED IMAGES FOR GALLERY</h3>');
                } else if (!hasItems && title) {
                    title.remove();
                }
                galleryContainer.classList.toggle('has-items', hasItems);
            }

            galInput.addEventListener('change', () => {
                const newFiles = Array.from(galInput.files);
                if (galleryFiles.length + newFiles.length > MAX_GALLERY_IMAGES) {
                    alert(`You can only have up to ${MAX_GALLERY_IMAGES} gallery images.`);
                    galInput.value = '';
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
                        updateGalleryTitleAndVisibility();
                    };
                    reader.readAsDataURL(file);
                });
                updateGalleryTitleAndVisibility();
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
                    alert(`You can only have up to ${MAX_GALLERY_IMAGES} gallery images.`);
                    return;
                }
                galleryFiles = galleryFiles.concat(dropped);
                updateGalInputFiles();
                renderGalleryPreviews();
            });

            // Initialize gallery visibility
            updateGalleryTitleAndVisibility();
        });

        // Initialize featured visibility
        updateFeaturedTitleAndVisibility();
    })();

    // Menu Items Handling
    (() => {
        const addMenuItemBtn = document.getElementById('addMenuItemBtn');
        const menuItemsContainer = document.getElementById('menuItemsContainer');
        const menuItemsInput = document.getElementById('menuItemsInput');
        let menuItems = [];
        let editingIndex = null;

        function updateMenuTitle() {
            let title = document.querySelector('.add-menu_added h3.media_added--title');
            const hasItems = menuItemsContainer.children.length > 0;
            if (hasItems && !title) {
                menuItemsContainer.insertAdjacentHTML('beforebegin', '<h3 class="media_added--title">ADDED MENU ITEMS</h3>');
            } else if (!hasItems && title) {
                title.remove();
            }
        }

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
                if (fileInput.files[0]) {
                    base64 = await toBase64(fileInput.files[0]);
                } else {
                    base64 = menuItems[editingIndex].image;
                }
                menuItems[editingIndex] = { name, price, description, image: base64 };
                editingIndex = null;
            } else {
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
            if (e.target.classList.contains('delete-menu-item') || e.target.closest('.delete-menu-item')) {
                e.preventDefault();
                const itemDiv = e.target.closest('.add-menu_added-grid_item');
                const index = Array.from(menuItemsContainer.children).indexOf(itemDiv);
                menuItems.splice(index, 1);
                renderMenuItems();
                updateHiddenInput();
            }
            if (e.target.classList.contains('edit-menu-item') || e.target.closest('.edit-menu-item')) {
                e.preventDefault();
                const itemDiv = e.target.closest('.add-menu_added-grid_item');
                const index = Array.from(menuItemsContainer.children).indexOf(itemDiv);
                const item = menuItems[index];
                document.getElementById('menuItemName').value = item.name;
                document.getElementById('menuItemPrice').value = item.price;
                document.getElementById('menuItemDescription').value = item.description;
                if (item.image) {
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
                    <a href="#" class="delete-menu-item">Delete</a>
                    <a href="#" class="edit-menu-item"><i class="fa fa-edit"></i></a>
                `;
                menuItemsContainer.appendChild(div);
            });
            updateMenuTitle();
            updateHiddenInput();
        }

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

        const fileInput = document.getElementById('fileInput3');
        const fileListPreview = document.querySelector('.file-list');

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

        // Initialize menu title
        updateMenuTitle();
    })();

    // FAQs Handling
    (() => {
        const faqQuestionInput = document.querySelector('#faq-question');
        const faqAnswerInput = document.querySelector('#faq-answer');
        const addFaqBtn = document.querySelector('#add-faq-btn');
        const faqsContainer = document.getElementById('faqs-container');
        const faqsInput = document.getElementById('faqsInput');
        let faqs = [];
        let editingIndex = null;

        function updateFaqTitle() {
            let title = document.querySelector('.added-faqs h3');
            const hasItems = faqsContainer.children.length > 0;
            if (hasItems && !title) {
                faqsContainer.insertAdjacentHTML('beforebegin', '<h3 class="media_added--title">ADDED FAQS</h3>');
            } else if (!hasItems && title) {
                title.remove();
            }
        }

        function escapeHtml(str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        function renderFaqs() {
            faqsContainer.innerHTML = '';
            faqs.forEach((faq, index) => {
                const div = document.createElement('div');
                div.className = 'added-faqs--grid_item';
                div.innerHTML = `
                    <h4>${escapeHtml(faq.question)}</h4>
                    <p>${escapeHtml(faq.answer)}</p>
                    <a href="#" class="edit-faq"><i class="fa fa-edit"></i></a>
                    <a href="#" class="delete-faq">X</a>
                `;
                faqsContainer.appendChild(div);
            });
            updateFaqTitle();
        }

        function updateHiddenInput() {
            faqsInput.value = JSON.stringify(faqs);
        }

        addFaqBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const question = faqQuestionInput.value.trim();
            const answer = faqAnswerInput.value.trim();
            if (question && answer) {
                if (editingIndex !== null) {
                    faqs[editingIndex] = { question, answer };
                    editingIndex = null;
                } else {
                    faqs.push({ question, answer });
                }
                faqQuestionInput.value = '';
                faqAnswerInput.value = '';
                renderFaqs();
            }
        });

        faqsContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('delete-faq') || e.target.closest('.delete-faq')) {
                e.preventDefault();
                const itemDiv = e.target.closest('.added-faqs-grid_item');
                const index = Array.from(faqsContainer.children).indexOf(itemDiv);
                faqs.splice(index, 1);
                renderFaqs();
            }
            if (e.target.classList.contains('edit-faq') || e.target.closest('.edit-faq')) {
                e.preventDefault();
                const itemDiv = e.target.closest('.added-faqs-grid_item');
                const index = Array.from(faqsContainer.children).indexOf(itemDiv);
                const faq = faqs[index];
                faqQuestionInput.value = faq.question;
                faqAnswerInput.value = faq.answer;
                editingIndex = index;
            }
        });

        // Initialize FAQ title
        updateFaqTitle();
    })();
    </script>
<?php endif; ?>

<?php include 'footer.php'; ?>
<!-- JavaScript to show login overlay if not logged in -->
<script>
window.addEventListener('load', () => {
    console.log('add-place.php: window.onload fired'); // Debug log
    <?php if (!$logged_in): ?>
        if (typeof window.showLogin === 'function') {
            console.log('Calling showLogin from auth.js');
            window.showLogin();
        } else {
            console.error('showLogin is not defined. Falling back to local implementation.');
            // Fallback showLogin
            const logOverlay = document.querySelector('.LogOverlay');
            const loginForm = document.querySelector('.LogOverlay__content--login');
            const signupForm = document.querySelector('.LogOverlay__content--signup');
            const loginLinkOverlayDiv = document.getElementById('login-overlay__div');
            const signupLinkOverlayDiv = document.getElementById('signup-overlay__div');
            if (logOverlay && loginForm && signupForm && loginLinkOverlayDiv && signupLinkOverlayDiv) {
                logOverlay.classList.add('show');
                loginForm.classList.add('show');
                signupForm.classList.remove('show');
                loginLinkOverlayDiv.classList.add('active');
                signupLinkOverlayDiv.classList.remove('active');
                loginForm.reset();
                document.querySelectorAll('.error-container').forEach(container => container.remove());
            } else {
                console.error('Login overlay elements not found in DOM');
            }
        }
    <?php endif; ?>
});
</script>