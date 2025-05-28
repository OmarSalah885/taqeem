<?php
require_once 'config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_connect.php';

// 1) Get place ID and confirm ownership
$place_id = $_POST['place_id'] ?? null;
if (!$place_id) {
    header("Location: " . ($_POST['redirect_to'] ?? 'index.php'));
    exit();
}

$stmt = $conn->prepare("SELECT user_id, name, category_id FROM places WHERE id = ?");
$stmt->bind_param("i", $place_id);
$stmt->execute();
$place = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$place || $place['user_id'] != $_SESSION['user_id']) {
    header("Location: profile.php?user_id=" . $_SESSION['user_id']);
    exit();
}

// 2) Fetch category name
$catStmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
$catStmt->bind_param("i", $place['category_id']);
$catStmt->execute();
$category_name = $catStmt->get_result()->fetch_assoc()['name'] ?? '';
$catStmt->close();

// 3) Build the same folder path you used in add-place.php
function normalizeName($n) {
    return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $n)));
}
$category_folder   = $category_name;                          // raw, e.g. "Home Services"
$place_folder_safe = normalizeName($place['name']);           // e.g. "my_place"
$place_folder      = __DIR__ . "/assets/images/places/{$category_folder}/{$place_folder_safe}";

// 4) Recursively delete that folder if it exists
if (is_dir($place_folder)) {
    delete_directory($place_folder);
}

// 5) Remove place_gallery rows
$g = $conn->prepare("DELETE FROM place_gallery WHERE place_id = ?");
$g->bind_param("i", $place_id);
$g->execute();
$g->close();

// 6) Remove review images from disk & DB
//    First fetch all image URLs for reviews of this place
$ri = $conn->prepare("
  SELECT ri.image_url
    FROM review_images ri
    JOIN reviews r ON ri.review_id = r.id
   WHERE r.place_id = ?");
$ri->bind_param("i", $place_id);
$ri->execute();
$res = $ri->get_result();
while ($row = $res->fetch_assoc()) {
    // delete file on disk
    $file = __DIR__ . '/' . $row['image_url'];
    if (file_exists($file)) {
        unlink($file);
    }
}
$ri->close();

//    Then delete those rows from review_images
$dri = $conn->prepare("
  DELETE ri
    FROM review_images ri
    JOIN reviews r ON ri.review_id = r.id
   WHERE r.place_id = ?");
$dri->bind_param("i", $place_id);
$dri->execute();
$dri->close();

// 7) (Optional) delete the reviews themselves
$rdel = $conn->prepare("DELETE FROM reviews WHERE place_id = ?");
$rdel->bind_param("i", $place_id);
$rdel->execute();
$rdel->close();

// 8) Finally delete the place record
$pdel = $conn->prepare("DELETE FROM places WHERE id = ?");
$pdel->bind_param("i", $place_id);
$pdel->execute();
$pdel->close();

// 9) Redirect back
header("Location: profile.php?user_id=" . $_SESSION['user_id']);
exit();


// --- Helper to recursively delete a directory
function delete_directory($dir) {
    foreach (array_diff(scandir($dir), ['.', '..']) as $item) {
        $path = "$dir/$item";
        is_dir($path)
          ? delete_directory($path)
          : unlink($path);
    }
    rmdir($dir);
}
?>
