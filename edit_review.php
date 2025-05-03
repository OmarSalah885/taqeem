<?php
// edit_review.php

session_start();
include 'config.php';
include 'db_connect.php';

// 1. Check required input and login
if (!isset($_SESSION['user_id']) || !isset($_POST['review_id'])) {
    // Not logged in or no review ID provided
    die("Invalid request");
}

$review_id = (int)$_POST['review_id'];
$user_id = $_SESSION['user_id'];

// 2. Verify ownership of the review
$stmt = $conn->prepare("SELECT user_id, place_id FROM reviews WHERE id = ?");
$stmt->bind_param("i", $review_id);
$stmt->execute();
$stmt->bind_result($owner_id, $place_id);
if (!$stmt->fetch()) {
    $stmt->close();
    die("Review not found");
}
$stmt->close();

if ($owner_id !== $user_id) {
    // Logged-in user does not own this review
    // Redirect back to the place page without making changes
    header("Location: single-place.php?place_id={$place_id}");
    exit;
}

// 3. Update review text and rating
$rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
// Clamp rating to valid range 1-5
if ($rating < 1) $rating = 1;
if ($rating > 5) $rating = 5;
$review_text = trim($_POST['review_text'] ?? '');

$update_stmt = $conn->prepare("UPDATE reviews SET review_text = ?, rating = ? WHERE id = ?");
$update_stmt->bind_param("sii", $review_text, $rating, $review_id);
$update_stmt->execute();
$update_stmt->close();

// 4. Delete selected existing images
if (!empty($_POST['delete_images']) && is_array($_POST['delete_images'])) {
    $delete_ids = $_POST['delete_images'];
    foreach ($delete_ids as $img_id) {
        $img_id = (int)$img_id;
        // Fetch the image URL for this image ID and review
        $img_stmt = $conn->prepare("SELECT image_url FROM review_images WHERE id = ? AND review_id = ?");
        $img_stmt->bind_param("ii", $img_id, $review_id);
        $img_stmt->execute();
        $img_stmt->bind_result($image_url);
        if ($img_stmt->fetch()) {
            $img_stmt->close();
            // Delete the image file from server
            $file_path = __DIR__ . '/' . $image_url;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            // Delete the record from database
            $del_stmt = $conn->prepare("DELETE FROM review_images WHERE id = ?");
            $del_stmt->bind_param("i", $img_id);
            $del_stmt->execute();
            $del_stmt->close();
        } else {
            $img_stmt->close();
        }
    }
}

// 5. Upload new images
if (isset($_FILES['review_images']) && !empty($_FILES['review_images']['name'][0])) {
    // Directory for uploads
    $uploadDir = __DIR__ . '/uploads/review_images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    // Allowed file extensions
    $allowed_ext = ['jpg','jpeg','png','gif'];
    // Loop through uploaded files
    foreach ($_FILES['review_images']['tmp_name'] as $index => $tmp_name) {
        $error = $_FILES['review_images']['error'][$index];
        if ($error !== UPLOAD_ERR_OK) {
            continue; // Skip on error
        }
        $orig_name = $_FILES['review_images']['name'][$index];
        $ext = strtolower(pathinfo($orig_name, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed_ext)) {
            continue; // Skip invalid file types
        }
        // Validate that file is an actual image
        $check = getimagesize($tmp_name);
        if ($check === false) {
            continue; // Not an image
        }
        // Generate a unique filename
        $new_filename = uniqid('rev_', true) . '.' . $ext;
        $destination = $uploadDir . $new_filename;
        if (move_uploaded_file($tmp_name, $destination)) {
            // Store relative URL/path in database
            $image_url = 'uploads/review_images/' . $new_filename;
            $ins_stmt = $conn->prepare("INSERT INTO review_images (review_id, image_url) VALUES (?, ?)");
            $ins_stmt->bind_param("is", $review_id, $image_url);
            $ins_stmt->execute();
            $ins_stmt->close();
        }
    }
}

// 6. Redirect back to the place page anchored to the review
header("Location: single-place.php?place_id={$place_id}#review_{$review_id}");
exit;
?>
