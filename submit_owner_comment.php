<?php
ob_start();
require_once 'config.php';
require_once 'db_connect.php';


header('Content-Type: application/json');

$response = ['success' => false, 'error' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id']) || !isset($_POST['csrf_token'])) {
    $response['error'] = 'Invalid request';
    sendJsonResponse($response);
}

if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $response['error'] = 'Invalid CSRF token';
    sendJsonResponse($response);
}

$review_id = (int)$_POST['review_id'];
$user_id = (int)$_SESSION['user_id'];
$comment = trim($_POST['comment']);
$place_id = (int)$_POST['place_id'];

if (empty($comment)) {
    $response['error'] = 'Comment cannot be empty';
    sendJsonResponse($response);
}

// Check if user already commented
$check = $conn->prepare("SELECT id FROM review_comments WHERE review_id = ? AND user_id = ?");
$check->bind_param("ii", $review_id, $user_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    $response['error'] = 'You can only comment once on this review. Please edit your existing comment or delete to add more.';
    sendJsonResponse($response);
}
$check->close();

// Insert comment
$stmt = $conn->prepare("INSERT INTO review_comments (review_id, user_id, comment, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iis", $review_id, $user_id, $comment);
if ($stmt->execute()) {
    $response = ['success' => true, 'comment_id' => $conn->insert_id];
} else {
    $response['error'] = 'Database error';
}
$stmt->close();
sendJsonResponse($response);

function sendJsonResponse($response) {
    ob_clean();
    echo json_encode($response);
    exit;
}
?>