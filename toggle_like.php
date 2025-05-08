<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

header('Content-Type: application/json'); // Set the response type to JSON

// Check if the database connection is established
if (!isset($conn)) {
    echo json_encode(['success' => false, 'message' => 'Database connection not established.']);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to like a review.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$review_id = isset($_POST['review_id']) ? (int)$_POST['review_id'] : 0;

if ($review_id === 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid review ID.']);
    exit;
}

// Check if the review is already liked
$check_like_query = $conn->prepare("SELECT id FROM review_likes WHERE user_id = ? AND review_id = ?");
$check_like_query->bind_param("ii", $user_id, $review_id);
$check_like_query->execute();
$check_like_result = $check_like_query->get_result();

if ($check_like_result->num_rows > 0) {
    // Unlike the review
    $delete_like_query = $conn->prepare("DELETE FROM review_likes WHERE user_id = ? AND review_id = ?");
    $delete_like_query->bind_param("ii", $user_id, $review_id);
    $delete_like_query->execute();
    echo json_encode(['success' => true, 'is_liked' => false]);
} else {
    // Like the review
    $insert_like_query = $conn->prepare("INSERT INTO review_likes (user_id, review_id, created_at) VALUES (?, ?, NOW())");
    $insert_like_query->bind_param("ii", $user_id, $review_id);
    $insert_like_query->execute();
    echo json_encode(['success' => true, 'is_liked' => true]);
}
?>