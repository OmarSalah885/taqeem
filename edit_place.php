<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

$place_id = $_GET['place_id'] ?? null;
if (!$place_id || !is_numeric($place_id)) {
    die("Missing or invalid place ID.");
}

$errors = [];
$cats = [];

// Fetch categories
$cat_stmt = $conn->prepare("SELECT id, name FROM categories ORDER BY name ASC");
$cat_stmt->execute();
$cat_result = $cat_stmt->get_result();
while ($cat = $cat_result->fetch_assoc()) {
    $cats[] = $cat;
}
$cat_stmt->close();

// Fetch existing place data
$stmt = $conn->prepare("
    SELECT 
        p.name, p.price, p.tags, p.description, p.category_id, p.email, p.phone_1, p.phone_2, p.website,
        p.facebook_url, p.instagram_url, p.twitter_url, p.featured_image,
        p.country, p.city, p.address, p.latitude, p.longitude, p.google_map_location,
        oh.open_time, oh.close_time, oh.day
    FROM places p
    LEFT JOIN opening_hours oh ON oh.place_id = p.id
    WHERE p.id = ?
");
$stmt->bind_param("i", $place_id);
$stmt->execute();
$result = $stmt->get_result();

$place = null;
$opening_hours = [];
while ($row = $result->fetch_assoc()) {
    if ($place === null) {
        $place = [
            'name' => $row['name'],
            'price' => $row['price'],
            'tags' => $row['tags'],
            'description' => $row['description'],
            'category_id' => $row['category_id'],
            'email' => $row['email'],
            'phone_1' => $row['phone_1'],
            'phone_2' => $row['phone_2'],
            'website' => $row['website'],
            'facebook_url' => $row['facebook_url'],
            'instagram_url' => $row['instagram_url'],
            'twitter_url' => $row['twitter_url'],
            'featured_image' => $row['featured_image'],
            'country' => $row['country'],
            'city' => $row['city'],
            'address' => $row['address'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'google_map_location' => $row['google_map_location'],
        ];
    }
    if ($row['day']) {
        $opening_hours[$row['day']] = [
            'open' => $row['open_time'],
            'close' => $row['close_time'],
        ];
    }
}
$stmt->close();

if (!$place) {
    die("Place not found.");
}

// Fetch menu items
$menu_items = [];
$menu_stmt = $conn->prepare("SELECT id, name, price, description, image FROM menu_items WHERE place_id = ?");
$menu_stmt->bind_param("i", $place_id);
$menu_stmt->execute();
$menu_result = $menu_stmt->get_result();
while ($row = $menu_result->fetch_assoc()) {
    $menu_items[] = $row;
}
$menu_stmt->close();

// Fetch FAQs
$faqs = [];
$faq_stmt = $conn->prepare("SELECT id, question, answer FROM faqs WHERE place_id = ?");
$faq_stmt->bind_param("i", $place_id);
$faq_stmt->execute();
$faq_result = $faq_stmt->get_result();
while ($row = $faq_result->fetch_assoc()) {
    $faqs[] = $row;
}
$faq_stmt->close();

// Handle POST update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    // Sanitize inputs
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $tags = trim($_POST['tags']);
    $description = trim($_POST['description']);
    $category_id = intval($_POST['category_id']);
    $email = trim($_POST['email']);
    $phone_1 = trim($_POST['phone_1']);
    $phone_2 = trim($_POST['phone_2']);
    $website = trim($_POST['website']);
    $facebook_url = trim($_POST['facebook_url']);
    $instagram_url = trim($_POST['instagram_url']);
    $twitter_url = trim($_POST['twitter_url']);
    $country = trim($_POST['country']);
    $city = trim($_POST['city']);
    $address = trim($_POST['address']);
    $latitude = floatval($_POST['latitude']);
    $longitude = floatval($_POST['longitude']);
    $google_map_location = trim($_POST['google_map_location']);
    $open_time = $_POST['open_time'] ?? [];
    $close_time = $_POST['close_time'] ?? [];

    // Basic validation
    if ($name === '') {
        $errors[] = "Place name is required.";
    }
    if (!in_array($price, ['$', '$$', '$$$'])) {
        $errors[] = "Invalid price selected.";
    }
    if ($category_id <= 0) {
        $errors[] = "Category must be selected.";
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }
    if ($latitude < -90 || $latitude > 90 || $longitude < -180 || $longitude > 180) {
        $errors[] = "Invalid coordinates.";
    }
    if (strlen($address) > 100) {
        $errors[] = "Address is too long (max 100 characters).";
    }

    if (empty($errors)) {
        $conn->begin_transaction();
        try {
            // Update places table
            $update_stmt = $conn->prepare("
                UPDATE places SET
                    name = ?, price = ?, tags = ?, description = ?, category_id = ?,
                    email = ?, phone_1 = ?, phone_2 = ?, website = ?,
                    facebook_url = ?, instagram_url = ?, twitter_url = ?,
                    country = ?, city = ?, address = ?, latitude = ?, longitude = ?, google_map_location = ?
                WHERE id = ?
            ");
            $update_stmt->bind_param(
                "ssssissssssssssddsi",
                $name, $price, $tags, $description, $category_id,
                $email, $phone_1, $phone_2, $website,
                $facebook_url, $instagram_url, $twitter_url,
                $country, $city, $address, $latitude, $longitude, $google_map_location,
                $place_id
            );
            $update_stmt->execute();
            $update_stmt->close();

            // Update opening hours
            $oh_delete_stmt = $conn->prepare("DELETE FROM opening_hours WHERE place_id = ?");
            $oh_delete_stmt->bind_param("i", $place_id);
            $oh_delete_stmt->execute();
            $oh_delete_stmt->close();

            $oh_stmt = $conn->prepare("INSERT INTO opening_hours (place_id, day, open_time, close_time) VALUES (?, ?, ?, ?)");
            foreach ($open_time as $day => $open) {
                $close = $close_time[$day] ?? '';
                $oh_stmt->bind_param("isss", $place_id, $day, $open, $close);
                $oh_stmt->execute();
            }
            $oh_stmt->close();

            // Handle folder renaming for images
            $cat_stmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
            $cat_stmt->bind_param("i", $category_id);
            $cat_stmt->execute();
            $cat_result = $cat_stmt->get_result();
            $category_row = $cat_result->fetch_assoc();
            $cat_stmt->close();
            $category_name_safe = $category_row['name'];
            $place_name_safe = normalizeName($name);

            $old_category_id = $place['category_id'];
            $old_category_stmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
            $old_category_stmt->bind_param("i", $old_category_id);
            $old_category_stmt->execute();
            $old_category_row = $old_category_stmt->get_result()->fetch_assoc();
            $old_category_stmt->close();

            $old_category_name_safe = $old_category_row['name'];
            $old_place_name_safe = normalizeName($place['name']);

            $old_folder = __DIR__ . "/assets/images/places/{$old_category_name_safe}/{$old_place_name_safe}";
            $new_folder = __DIR__ . "/assets/images/places/{$category_name_safe}/{$place_name_safe}";

            if ($old_folder !== $new_folder && is_dir($old_folder)) {
                if (is_dir($new_folder)) {
                    throw new Exception("Cannot rename folder: Destination folder already exists.");
                }
                if (!is_dir(dirname($new_folder))) {
                    mkdir(dirname($new_folder), 0755, true);
                }
                if (!rename($old_folder, $new_folder)) {
                    throw new Exception("Failed to rename folder.");
                }
                $old_path = "assets/images/places/{$old_category_name_safe}/{$old_place_name_safe}/";
                $new_path = "assets/images/places/{$category_name_safe}/{$place_name_safe}/";
                $like_pattern = "%{$old_path}%";

                // Update featured image path
                $query = "UPDATE places SET featured_image = REPLACE(featured_image, ?, ?) WHERE id = ? AND featured_image LIKE ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssis", $old_path, $new_path, $place_id, $like_pattern);
                $stmt->execute();
                $stmt->close();

                // Update gallery image paths
                $query = "UPDATE place_gallery SET image_url = REPLACE(image_url, ?, ?) WHERE place_id = ? AND image_url LIKE ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssis", $old_path, $new_path, $place_id, $like_pattern);
                $stmt->execute();
                $stmt->close();

                // Update menu image paths
                $query = "UPDATE menu_items SET image = REPLACE(image, ?, ?) WHERE place_id = ? AND image LIKE ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssis", $old_path, $new_path, $place_id, $like_pattern);
                $stmt->execute();
                $stmt->close();
            }

            // Handle featured image
            if (!empty($_POST['remove_featured_image'])) {
                $stmt = $conn->prepare("SELECT featured_image FROM places WHERE id = ?");
                $stmt->bind_param("i", $place_id);
                $stmt->execute();
                $result = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                if (!empty($result['featured_image'])) {
                    $filePath = __DIR__ . '/' . $result['featured_image'];
                    if (file_exists($filePath) && !unlink($filePath)) {
                        throw new Exception("Failed to delete featured image.");
                    }
                }

                $updateStmt = $conn->prepare("UPDATE places SET featured_image = NULL WHERE id = ?");
                $updateStmt->bind_param("i", $place_id);
                $updateStmt->execute();
                $updateStmt->close();
            }

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
            $keepIds = isset($_POST['existing_gallery_ids']) ? array_map('intval', $_POST['existing_gallery_ids']) : [];
            $gallery_stmt = $conn->prepare("SELECT id, image_url FROM place_gallery WHERE place_id = ?");
            $gallery_stmt->bind_param("i", $place_id);
            $gallery_stmt->execute();
            $gallery_result = $gallery_stmt->get_result();
            while ($img = $gallery_result->fetch_assoc()) {
                if (!in_array($img['id'], $keepIds)) {
                    $filePath = __DIR__ . '/' . $img['image_url'];
                    if (file_exists($filePath) && !unlink($filePath)) {
                        throw new Exception("Failed to delete gallery image: {$img['image_url']}");
                    }
                    $del_stmt = $conn->prepare("DELETE FROM place_gallery WHERE id = ?");
                    $del_stmt->bind_param("i", $img['id']);
                    $del_stmt->execute();
                    $del_stmt->close();
                }
            }
            $gallery_stmt->close();

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
                            throw new Exception("Failed to upload gallery image: {$filename}");
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
            $menu_dir = __DIR__ . "/assets/images/places/{$category_name_safe}/{$place_name_safe}/menu/";
            if (!is_dir($menu_dir)) {
                mkdir($menu_dir, 0755, true);
            }
            $menu_items = json_decode($_POST['menu_items_data'] ?? '[]', true);
            $deleted_menu_items = json_decode($_POST['deleted_menu_items'] ?? '[]', true);

            if ($deleted_menu_items) {
                foreach ($deleted_menu_items as $del_id) {
                    $stmt = $conn->prepare("SELECT image FROM menu_items WHERE id = ?");
                    $stmt->bind_param("i", $del_id);
                    $stmt->execute();
                    $stmt->bind_result($img_url);
                    if ($stmt->fetch() && $img_url) {
                        $filePath = __DIR__ . '/' . $img_url;
                        if (file_exists($filePath) && !unlink($filePath)) {
                            throw new Exception("Failed to delete menu item image: {$img_url}");
                        }
                    }
                    $stmt->close();
                    $del_stmt = $conn->prepare("DELETE FROM menu_items WHERE id = ?");
                    $del_stmt->bind_param("i", $del_id);
                    $del_stmt->execute();
                    $del_stmt->close();
                }
            }

            foreach ($menu_items as $item) {
                $old_img_url = null;
                $new_img_path = null;

                if (!empty($item['id'])) {
                    $stmt = $conn->prepare("SELECT image FROM menu_items WHERE id = ?");
                    $stmt->bind_param("i", $item['id']);
                    $stmt->execute();
                    $stmt->bind_result($old_img_url);
                    $stmt->fetch();
                    $stmt->close();
                }

                if (isset($item['image']) && strpos($item['image'], 'data:image') === 0) {
                    $imgData = explode(',', $item['image'], 2)[1];
                    $imgDecoded = base64_decode($imgData);
                    $ext = preg_match('/^data:image\/(\w+);base64,/', $item['image'], $match) ? strtolower($match[1]) : 'png';
                    if ($ext === 'jpeg') $ext = 'jpg';
                    if (!in_array($ext, ['jpg', 'png', 'gif', 'webp'])) $ext = 'png';
                    $imgName = uniqid('menu_', true) . '.' . $ext;
                    $new_img_path = "assets/images/places/{$category_name_safe}/{$place_name_safe}/menu/" . $imgName;
                    if (!file_put_contents(__DIR__ . '/' . $new_img_path, $imgDecoded)) {
                        throw new Exception("Failed to save menu item image: {$imgName}");
                    }
                    if (!empty($item['id']) && $old_img_url && $old_img_url !== $new_img_path) {
                        $oldFilePath = __DIR__ . '/' . $old_img_url;
                        if (file_exists($oldFilePath) && !unlink($oldFilePath)) {
                            throw new Exception("Failed to delete old menu item image: {$old_img_url}");
                        }
                    }
                } else {
                    $new_img_path = !empty($item['id']) ? $old_img_url : null;
                    if ($new_img_path && strpos($new_img_path, "assets/images/places/{$category_name_safe}/{$place_name_safe}/") !== 0) {
                        $filename = basename($new_img_path);
                        if ($filename) {
                            $new_img_path = "assets/images/places/{$category_name_safe}/{$place_name_safe}/menu/" . $filename;
                        }
                    }
                }

                if (!empty($item['id'])) {
                    $stmt = $conn->prepare("UPDATE menu_items SET name = ?, price = ?, description = ?, image = ? WHERE id = ?");
                    $stmt->bind_param("sdssi", $item['name'], $item['price'], $item['description'], $new_img_path, $item['id']);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    if ($new_img_path) {
                        $stmt = $conn->prepare("INSERT INTO menu_items (place_id, name, price, description, image) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("isdss", $place_id, $item['name'], $item['price'], $item['description'], $new_img_path);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
            }

            // Handle FAQs
            $faqs_data = json_decode($_POST['faqs_data'] ?? '[]', true);
            $deleted_faq_ids = json_decode($_POST['deleted_faq_ids'] ?? '[]', true);

            if ($deleted_faq_ids) {
                $del_stmt = $conn->prepare("DELETE FROM faqs WHERE id = ?");
                foreach ($deleted_faq_ids as $del_id) {
                    $del_stmt->bind_param("i", $del_id);
                    $del_stmt->execute();
                }
                $del_stmt->close();
            }

            foreach ($faqs_data as $faq) {
                if (!empty($faq['id'])) {
                    $stmt = $conn->prepare("UPDATE faqs SET question = ?, answer = ? WHERE id = ?");
                    $stmt->bind_param("ssi", $faq['question'], $faq['answer'], $faq['id']);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    $stmt = $conn->prepare("INSERT INTO faqs (place_id, question, answer) VALUES (?, ?, ?)");
                    $stmt->bind_param("iss", $place_id, $faq['question'], $faq['answer']);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            $conn->commit();
            header("Location: edit_place.php?place_id=$place_id&updated=1");
            exit;
        } catch (Exception $e) {
            $conn->rollback();
            $errors[] = "Error: " . $e->getMessage();
        }
    }

    // Update $place with form values if errors
    $place = [
        'name' => $name,
        'price' => $price,
        'tags' => $tags,
        'description' => $description,
        'category_id' => $category_id,
        'email' => $email,
        'phone_1' => $phone_1,
        'phone_2' => $phone_2,
        'website' => $website,
        'facebook_url' => $facebook_url,
        'instagram_url' => $instagram_url,
        'twitter_url' => $twitter_url,
        'country' => $country,
        'city' => $city,
        'address' => $address,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'google_map_location' => $google_map_location,
    ];
    $opening_hours = [];
    foreach ($open_time as $day => $open) {
        $opening_hours[$day] = [
            'open' => $open,
            'close' => $close_time[$day] ?? '',
        ];
    }
}

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

include 'header.php';

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

$days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
function normalizeName($name) {
    return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $name)));
}
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

  <form class="add-place_main" method="POST" action="edit_place.php?place_id=<?= htmlspecialchars($place_id) ?>" enctype="multipart/form-data">
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
        <input type="text" name="country" id="country" placeholder="COUNTRY" class="input--red" value="<?= htmlspecialchars($place['country'] ?? '') ?>">
        <input type="text" name="city" id="city" placeholder="CITY" class="input--red" value="<?= htmlspecialchars($place['city'] ?? '') ?>">
      </div>
      <input type="text" name="google_map_location" id="google_map_location" placeholder="Use the map or add the Google Maps link of the place" class="input--red" value="<?= htmlspecialchars($place['google_map_location'] ?? '') ?>">
      <div class="location-map">
        <h3 class="location-map_title">SET LOCATION ON MAP</h3>
        <div id="map" style="height: 400px;"></div>
        <p>Selected Coordinates: <span id="coordinates"><?= htmlspecialchars($place['latitude'] ?? '31.9539') ?>, <?= htmlspecialchars($place['longitude'] ?? '35.9106') ?></span></p>
      </div>
      <input type="hidden" name="address" id="address" value="<?= htmlspecialchars($place['address'] ?? '') ?>">
      <input type="hidden" name="latitude" id="latitude" value="<?= htmlspecialchars($place['latitude'] ?? '31.9539') ?>">
      <input type="hidden" name="longitude" id="longitude" value="<?= htmlspecialchars($place['longitude'] ?? '35.9106') ?>">
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
      <?php foreach ($days as $day): 
          $open_val = $opening_hours[$day]['open'] ?? '09:00';
          $close_val = $opening_hours[$day]['close'] ?? '17:00';
      ?>
      <div class="side-by-side_inbut">
        <input type="text" class="input--red" value="<?= htmlspecialchars($day) ?>" readonly>
        <div class="side-by-side_inbut">
          <input type="time" name="open_time[<?= htmlspecialchars($day) ?>]" class="input--red" value="<?= htmlspecialchars($open_val) ?>">
          <input type="time" name="close_time[<?= htmlspecialchars($day) ?>]" class="input--red" value="<?= htmlspecialchars($close_val) ?>">
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
          <h3 class="media_added--title">ADDED FEATURED IMAGE</h3>
          <div class="media_added--fetured_img">
            <?php if (!empty($place['featured_image'])): ?>
              <div class="media_added--fetured_img_item">
                <img src="<?= htmlspecialchars($place['featured_image']) ?>" alt="Featured Image">
                <button type="button" class="remove-featured-db">X</button>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="media_added--gallery">
          <h3 class="media_added--title">ADDED IMAGES FOR GALLERY</h3>
          <div class="media_added--gallery_grid">
            <?php
            $gallery_stmt = $conn->prepare("SELECT id, image_url FROM place_gallery WHERE place_id = ?");
            $gallery_stmt->bind_param("i", $place_id);
            $gallery_stmt->execute();
            $gallery_result = $gallery_stmt->get_result();
            while ($img = $gallery_result->fetch_assoc()): ?>
              <div class="media_added--gallery_grid_item" data-id="<?= $img['id'] ?>">
                <img src="<?= htmlspecialchars($img['image_url']) ?>" alt="Gallery Image">
                <button type="button" class="remove-gallery-db" data-id="<?= $img['id'] ?>">X</button>
                <input type="hidden" name="existing_gallery_ids[]" value="<?= $img['id'] ?>">
              </div>
            <?php endwhile; $gallery_stmt->close(); ?>
          </div>
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
        <div class="add-menu_added-grid" id="menuItemsContainer">
          <?php foreach ($menu_items as $item): ?>
            <div class="add-menu_added-grid_item" data-id="<?= $item['id'] ?>">
              <img src="<?= htmlspecialchars($item['image']) ?>" alt="">
              <div class="add-menu_added-grid_item--info">
                <h4><?= htmlspecialchars($item['name']) ?></h4>
                <p><?= htmlspecialchars($item['description']) ?></p>
                <p><?= htmlspecialchars($item['price']) ?></p>
              </div>
              <a href="#" class="edit-menu-item"><i class="fa fa-edit"></i></a>
              <a href="#" class="delete-menu-item">X</a>
              <input type="hidden" name="existing_menu_ids[]" value="<?= $item['id'] ?>">
            </div>
          <?php endforeach; ?>
        </div>
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
        <div class="added-faqs-grid" id="faqs-container">
          <?php foreach ($faqs as $faq): ?>
            <div class="added-faqs-grid_item" data-id="<?= $faq['id'] ?>">
              <h4><?= htmlspecialchars($faq['question']) ?></h4>
              <p><?= htmlspecialchars($faq['answer']) ?></p>
              <a href="#" class="edit-faq"><i class="fa fa-edit"></i></a>
              <a href="#" class="delete-faq">X</a>
              <input type="hidden" name="existing_faq_ids[]" value="<?= $faq['id'] ?>">
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <input type="hidden" name="faqs_data" id="faqsInput">
      <input type="hidden" name="deleted_faq_ids" id="deletedFaqIdsInput">
    </div>

    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <button class="btn__red--l btn__red btn" type="submit">UPDATE PLACE</button>
  </form>
</main>


<script>
document.addEventListener('DOMContentLoaded', () => {
  let lat = parseFloat(<?= json_encode($place['latitude'] ?? '31.9539') ?>);
  let lng = parseFloat(<?= json_encode($place['longitude'] ?? '35.9106') ?>);
  if (isNaN(lat) || isNaN(lng)) {
    lat = 31.9539;
    lng = 35.9106;
  }
  initMap(lat, lng);
});
</script>

<script>
// FAQ Handling
(() => {
  const addFaqBtn = document.getElementById('add-faq-btn');
  const faqsContainer = document.getElementById('faqs-container');
  const faqsInput = document.getElementById('faqsInput');
  const deletedFaqIdsInput = document.getElementById('deletedFaqIdsInput');
  let faqs = [];
  let deletedFaqIds = [];
  let editingIndex = null;

  // Load existing FAQs from PHP
  <?php if (!empty($faqs)): ?>
    faqs = <?= json_encode($faqs) ?>;
    renderFaqs();
  <?php endif; ?>

  addFaqBtn.addEventListener('click', () => {
    const question = document.getElementById('faq-question').value.trim();
    const answer = document.getElementById('faq-answer').value.trim();

    if (!question || !answer) {
      alert('Please fill both question and answer fields.');
      return;
    }

    if (editingIndex !== null) {
      // Edit mode
      faqs[editingIndex] = {
        ...faqs[editingIndex],
        question,
        answer
      };
      editingIndex = null;
    } else {
      // Add mode
      faqs.push({ question, answer });
    }

    renderFaqs();
    updateHiddenInput();
    clearInputs();
  });

  faqsContainer.addEventListener('click', (e) => {
    // Delete
    if (e.target.classList.contains('delete-faq')) {
      e.preventDefault();
      const itemDiv = e.target.closest('.added-faqs-grid_item');
      const index = Array.from(faqsContainer.children).indexOf(itemDiv);
      if (faqs[index].id) {
        deletedFaqIds.push(faqs[index].id);
      }
      faqs.splice(index, 1);
      renderFaqs();
      updateHiddenInput();
    }
    // Edit
    if (e.target.classList.contains('edit-faq') || e.target.closest('.edit-faq')) {
      e.preventDefault();
      const itemDiv = e.target.closest('.added-faqs-grid_item');
      const index = Array.from(faqsContainer.children).indexOf(itemDiv);
      const faq = faqs[index];
      document.getElementById('faq-question').value = faq.question;
      document.getElementById('faq-answer').value = faq.answer;
      editingIndex = index;
    }
  });

  function renderFaqs() {
    faqsContainer.innerHTML = '';
    faqs.forEach((faq, index) => {
      const div = document.createElement('div');
      div.className = 'added-faqs-grid_item';
      div.innerHTML = `
        <h4>${faq.question}</h4>
        <p>${faq.answer}</p>
        <a href="#" class="edit-faq"><i class="fa fa-edit"></i></a>
        <a href="#" class="delete-faq">X</a>
        ${faq.id ? `<input type="hidden" name="existing_faq_ids[]" value="${faq.id}">` : ''}
      `;
      faqsContainer.appendChild(div);
    });
    updateHiddenInput();
  }

  function updateHiddenInput() {
    faqsInput.value = JSON.stringify(faqs);
    deletedFaqIdsInput.value = JSON.stringify(deletedFaqIds);
  }

  function clearInputs() {
    document.getElementById('faq-question').value = '';
    document.getElementById('faq-answer').value = '';
  }
})();
</script>

<script>
// Featured Image Handling
(() => {
  const featuredInput = document.getElementById('fileInput1');
  const featuredPreview = document.querySelector('.media_added--fetured_img');
  let featuredRemoved = false;

  document.querySelectorAll('.remove-featured-db').forEach(btn => {
    btn.onclick = () => {
      btn.closest('.media_added--fetured_img_item').remove();
      featuredRemoved = true;
      let rm = document.querySelector('input[name="remove_featured_image"]');
      if (!rm) {
        rm = document.createElement('input');
        rm.type = 'hidden';
        rm.name = 'remove_featured_image';
        rm.value = '1';
        featuredInput.value = '';
        document.querySelector('form.add-place_main').appendChild(rm);
      }
    };
  });

  featuredInput.addEventListener('change', () => {
    featuredPreview.innerHTML = '';
    if (featuredInput.files.length === 1) {
      const reader = new FileReader();
      reader.onload = e => {
        const div = document.createElement('div');
        div.className = 'media_added--fetured_img_item';
        div.innerHTML = `<img src="${e.target.result}" alt="Featured Image">
          <button type="button" class="remove-featured-new">X</button>`;
        featuredPreview.appendChild(div);
        div.querySelector('.remove-featured-new').onclick = () => {
          featuredInput.value = '';
          div.remove();
        };
      };
      reader.readAsDataURL(featuredInput.files[0]);
    }
  });

  const featuredDropArea = document.querySelector('.media-contanier_featured .drop-area');
  featuredDropArea.addEventListener('dragover', e => {
    e.preventDefault();
    featuredDropArea.classList.add('dragover');
  });
  featuredDropArea.addEventListener('dragleave', e => {
    e.preventDefault();
    featuredDropArea.classList.remove('dragover');
  });
  featuredDropArea.addEventListener('drop', e => {
    e.preventDefault();
    featuredDropArea.classList.remove('dragover');
    const files = Array.from(e.dataTransfer.files);
    if (files.length > 0) {
      featuredInput.files = (new DataTransfer()).files;
      const dt = new DataTransfer();
      dt.items.add(files[0]);
      featuredInput.files = dt.files;
      featuredInput.dispatchEvent(new Event('change'));
    }
  });
})();
</script>

<script>
// Gallery Images Handling
(() => {
  const galInput = document.getElementById('fileInput2');
  const galContainer = document.querySelector('.media_added--gallery_grid');
  const MAX_GALLERY_IMAGES = 8;
  let galleryFiles = [];
  let existingGalleryIds = Array.from(document.querySelectorAll('.media_added--gallery_grid_item[data-id]'))
    .map(item => parseInt(item.dataset.id, 10));

  function bindRemoveGalleryDb() {
    galContainer.querySelectorAll('.remove-gallery-db').forEach(btn => {
      btn.onclick = () => {
        const id = parseInt(btn.dataset.id, 10);
        existingGalleryIds = existingGalleryIds.filter(x => x !== id);
        btn.closest('.media_added--gallery_grid_item').remove();
        galContainer.querySelectorAll(`input[name="existing_gallery_ids[]"][value="${id}"]`).forEach(inp => inp.remove());
      };
    });
  }
  bindRemoveGalleryDb();

  galInput.addEventListener('change', () => {
    const newFiles = Array.from(galInput.files);
    const total = galleryFiles.length + existingGalleryIds.length;
    if (total + newFiles.length > MAX_GALLERY_IMAGES) {
      alert(`You can only upload up to ${MAX_GALLERY_IMAGES} gallery images.`);
      return;
    }
    galleryFiles = galleryFiles.concat(newFiles);
    updateGalInputFiles();
    renderGalleryPreviews();
  });

  function renderGalleryPreviews() {
    galContainer.querySelectorAll('.media_added--gallery_grid_item.new').forEach(el => el.remove());
    galleryFiles.forEach((file, idx) => {
      const reader = new FileReader();
      reader.onload = e => {
        const div = document.createElement('div');
        div.className = 'media_added--gallery_grid_item new';
        div.innerHTML = `<img src="${e.target.result}" alt="Gallery Image">
          <button type="button" class="remove-gallery-new" data-idx="${idx}">X</button>`;
        galContainer.appendChild(div);
        div.querySelector('.remove-gallery-new').onclick = () => {
          galleryFiles.splice(idx, 1);
          updateGalInputFiles();
          renderGalleryPreviews();
        };
      };
      reader.readAsDataURL(file);
    });
  }

  function updateGalInputFiles() {
    const dt = new DataTransfer();
    galleryFiles.forEach(f => dt.items.add(f));
    galInput.files = dt.files;
  }

  const galDropArea = document.querySelector('.gallery-drop-area');
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
    const total = galleryFiles.length + existingGalleryIds.length;
    if (total + dropped.length > MAX_GALLERY_IMAGES) {
      alert(`You can only upload up to ${MAX_GALLERY_IMAGES} gallery images.`);
      return;
    }
    galleryFiles = galleryFiles.concat(dropped);
    updateGalInputFiles();
    renderGalleryPreviews();
  });
})();
</script>

<script>
// Menu Items Handling
const addMenuItemBtn = document.getElementById('addMenuItemBtn');
const menuItemsContainer = document.getElementById('menuItemsContainer');
const menuItemsInput = document.getElementById('menuItemsInput');
const deletedMenuItemsInput = document.getElementById('deletedMenuItemsInput');
let menuItems = [];
let deletedMenuItemIds = [];
let editingIndex = null;

<?php if (!empty($menu_items)): ?>
menuItems = <?= json_encode($menu_items) ?>.map(item => ({
    ...item,
    image: item.image
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
    if (e.target.classList.contains('delete-menu-item')) {
        e.preventDefault();
        const itemDiv = e.target.closest('.add-menu_added-grid_item');
        const index = Array.from(menuItemsContainer.children).indexOf(itemDiv);
        if (menuItems[index].id) {
            deletedMenuItemIds.push(menuItems[index].id);
        }
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
</script>

<?php include 'footer.php'; ?>