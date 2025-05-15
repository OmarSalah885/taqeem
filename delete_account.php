<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

// 1. Make sure user is logged in
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$currentUserId = $_SESSION['user_id'];
$currentUserRole = strtolower($_SESSION['role'] ?? 'guest');

// 2. Determine which user to delete
if ($currentUserRole === 'admin' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userIdToDelete = (int)$_GET['id'];

    // Optional: prevent admin from deleting themselves
    if ($userIdToDelete === $currentUserId) {
        die('You cannot delete your own account here.');
    }
} else {
    // Normal user can only delete their own account
    $userIdToDelete = $currentUserId;
}

// 3. Gather all file-paths to delete (profile + places + galleries + reviews + menu items)
$filesToRemove = [];
$placeFolders = [];

// 3a. User’s profile image
$stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
$stmt->bind_param('i', $userIdToDelete);
$stmt->execute();
$stmt->bind_result($path);
$stmt->fetch();
$stmt->close();
if (!empty($path)) {
    $filesToRemove[] = $path;
}

// 3b. Featured images and place IDs
$placeIds = [];
$stmt = $conn->prepare("SELECT id, featured_image FROM places WHERE user_id = ?");
$stmt->bind_param('i', $userIdToDelete);
$stmt->execute();
$stmt->bind_result($placeId, $featuredImage);
while ($stmt->fetch()) {
    $placeIds[] = $placeId;
    if (!empty($featuredImage)) {
        $filesToRemove[] = $featuredImage;
    }
}
$stmt->close();

// 3b.5. Collect place folder paths (category and place names)
$stmt = $conn->prepare("
    SELECT places.name, categories.name
    FROM places
    JOIN categories ON places.category_id = categories.id
    WHERE places.user_id = ?
");
$stmt->bind_param('i', $userIdToDelete);
$stmt->execute();
$stmt->bind_result($placeName, $categoryName);
while ($stmt->fetch()) {
    if (!empty($placeName) && !empty($categoryName)) {
        $folderPath = __DIR__ . '/assets/images/places/' . $categoryName . '/' . $placeName;
        $placeFolders[] = $folderPath;
    }
}
$stmt->close();

// 3c. Gallery images
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

// 3d. Review IDs
$reviewIds = [];
$stmt = $conn->prepare("SELECT id FROM reviews WHERE user_id = ?");
$stmt->bind_param('i', $userIdToDelete);
$stmt->execute();
$stmt->bind_result($rid);
while ($stmt->fetch()) {
    $reviewIds[] = $rid;
}
$stmt->close();

// 3d. Review images
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

// 3e. Menu item images
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

// 4. Delete the user (will cascade deletes to related tables if foreign keys set)
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param('i', $userIdToDelete);
$stmt->execute();
$stmt->close();

// 5. Delete files from disk
foreach ($filesToRemove as $file) {
    $fullPath = __DIR__ . '/' . ltrim($file, '/');
    if (file_exists($fullPath)) {
        @unlink($fullPath);
    }
}

// 6. Recursively delete place folders
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
            @rmdir($target);
        }
    }
    @rmdir($folderPath);
}

foreach ($placeFolders as $folder) {
    deleteFolderRecursively($folder);
}

// 7. If user deleted their own account, log them out
if ($userIdToDelete === $currentUserId) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
} else {
    // If admin deleted another user, redirect back to user management
    header('Location: admin_users.php');
    exit;
}
