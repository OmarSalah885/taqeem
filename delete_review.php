<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_id = $_POST['review_id'];

    // Ensure the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'Not logged in']);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Verify that the review belongs to the logged-in user
    $stmt_check_owner = $conn->prepare("SELECT user_id FROM reviews WHERE id = ?");
    $stmt_check_owner->bind_param("i", $review_id);
    $stmt_check_owner->execute();
    $stmt_check_owner->bind_result($owner_id);
    $stmt_check_owner->fetch();
    $stmt_check_owner->close();

    if ($owner_id !== $user_id) {
        echo json_encode(['success' => false, 'error' => 'Unauthorized deletion']);
        exit;
    }

    // Get image paths
    $stmt_images = $conn->prepare("SELECT image_url FROM review_images WHERE review_id = ?");
    $stmt_images->bind_param("i", $review_id);
    $stmt_images->execute();
    $images_result = $stmt_images->get_result();
    $image_paths = [];
    while ($row = $images_result->fetch_assoc()) {
        $image_paths[] = $row['image_url'];
    }
    $stmt_images->close();

    // Delete files from server
    foreach ($image_paths as $img_path) {
        if (file_exists($img_path)) {
            unlink($img_path);
        }
    }

    // Delete from related tables
    $conn->begin_transaction();

    try {
        $stmt_delete_images = $conn->prepare("DELETE FROM review_images WHERE review_id = ?");
        $stmt_delete_images->bind_param("i", $review_id);
        $stmt_delete_images->execute();
        $stmt_delete_images->close();

        $stmt_delete_comments = $conn->prepare("DELETE FROM review_comments WHERE review_id = ?");
        $stmt_delete_comments->bind_param("i", $review_id);
        $stmt_delete_comments->execute();
        $stmt_delete_comments->close();

        $stmt_delete_review = $conn->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt_delete_review->bind_param("i", $review_id);
        $stmt_delete_review->execute();
        $stmt_delete_review->close();

        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'error' => 'Deletion failed']);
    }
}
