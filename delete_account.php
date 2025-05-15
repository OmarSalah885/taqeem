<?php
require_once 'config.php';
require_once 'db_connect.php';  // should define $conn as mysqli instance
session_start();

// 1. Make sure user is logged in
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$userId = $_SESSION['user_id'];

// 2. Gather all file-paths to delete (profile + places + galleries + reviews + menu items)
$filesToRemove = [];
$placeFolders = [];

// 2a. User’s profile image
$stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($path);
$stmt->fetch();
$stmt->close();
if (!empty($path)) {
    $filesToRemove[] = $path;
}

// 2b. Featured images of all their places
$placeIds = [];
$stmt = $conn->prepare("SELECT id, featured_image FROM places WHERE user_id = ?");
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($placeId, $featuredImage);
while ($stmt->fetch()) {
    $placeIds[] = $placeId;
    if (!empty($featuredImage)) {
        $filesToRemove[] = $featuredImage;
    }
}
$stmt->close();

$stmt = $conn->prepare("
    SELECT places.name, categories.name
    FROM places
    JOIN categories ON places.category_id = categories.id
    WHERE places.user_id = ?
");
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($placeName, $categoryName);
while ($stmt->fetch()) {
    if (!empty($placeName) && !empty($categoryName)) {
        $folderPath = __DIR__ . '/assets/images/places/' . $categoryName . '/' . $placeName;
        $placeFolders[] = $folderPath;
    }
}
$stmt->close();


// 2c. Gallery images for those places
if (!empty($placeIds)) {
    $stmt = $conn->prepare("SELECT image_url FROM place_gallery WHERE place_id = ?");
    foreach ($placeIds as $pid) {
        $stmt->bind_param('i', $pid);
        $stmt->execute();
        $stmt->bind_result($imgUrl);
        while ($stmt->fetch()) {
            $filesToRemove[] = $imgUrl;
        }
    }
    $stmt->close();
}

// 2d. Any review images they uploaded
$reviewIds = [];
$stmt = $conn->prepare("SELECT id FROM reviews WHERE user_id = ?");
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($rid);
while ($stmt->fetch()) {
    $reviewIds[] = $rid;
}
$stmt->close();

if (!empty($reviewIds)) {
    $stmt = $conn->prepare("SELECT image_url FROM review_images WHERE review_id = ?");
    foreach ($reviewIds as $rid) {
        $stmt->bind_param('i', $rid);
        $stmt->execute();
        $stmt->bind_result($imgUrl);
        while ($stmt->fetch()) {
            $filesToRemove[] = $imgUrl;
        }
    }
    $stmt->close();
}

// 2e. Menu item images for their places
if (!empty($placeIds)) {
    $stmt = $conn->prepare("SELECT image FROM menu_items WHERE place_id = ?");
    foreach ($placeIds as $pid) {
        $stmt->bind_param('i', $pid);
        $stmt->execute();
        $stmt->bind_result($menuImg);
        while ($stmt->fetch()) {
            if (!empty($menuImg)) {
                $filesToRemove[] = $menuImg;
            }
        }
    }
    $stmt->close();
}

// 3. Delete the user — cascades to places, reviews, comments, likes, saved_places, etc.
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->close();

// 4. Now remove files from disk
foreach ($filesToRemove as $file) {
    $fullPath = __DIR__ . '/' . ltrim($file, '/');
    if (file_exists($fullPath)) {
        if (!@unlink($fullPath)) {
            error_log("Failed to delete file: $fullPath");
        }
    }
}

// 4b. Remove place folders (with subfolders inside)
function deleteFolderRecursively($folderPath) {
    if (!is_dir($folderPath)) return;

    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($folderPath, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($items as $item) {
        $target = $item->getPathname();
        if ($item->isFile() || $item->isLink()) {
            @unlink($target);
        } elseif ($item->isDir()) {
            // Try to delete subfolder
            @rmdir($target);
        }
    }
    // Try multiple times to remove the main folder, with small delay
    $maxAttempts = 3;
    for ($i = 0; $i < $maxAttempts; $i++) {
        if (@rmdir($folderPath)) {
            break; // success
        }
        usleep(100000); // wait 0.1 seconds
    }
}


foreach ($placeFolders as $folder) {
    error_log("Trying to delete: $folder");
    deleteFolderRecursively($folder);
}

// 5. Destroy session and redirect
session_unset();
session_destroy();
header('Location: index.php');
exit;
?>