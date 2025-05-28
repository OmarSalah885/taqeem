<?php
ob_start();
require_once 'config.php';
require_once 'db_connect.php';


header('Content-Type: application/json');

$response = ['status' => 'error', 'error' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id']) || !isset($_POST['csrf_token'])) {
    $response['error'] = 'Invalid request';
    sendJsonResponse($response);
}

if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $response['error'] = 'Invalid CSRF token';
    sendJsonResponse($response);
}

$comment_id = (int)$_POST['comment_id'];
$user_id = (int)$_SESSION['user_id'];

$stmt = $conn->prepare("SELECT user_id FROM review_comments WHERE id = ?");
$stmt->bind_param("i", $comment_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $response['error'] = 'Comment not found';
    sendJsonResponse($response);
}

$stmt->bind_result($comment_user_id);
$stmt->fetch();
$stmt->close();

$is_admin = isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'admin';
if (!$is_admin && $comment_user_id !== $user_id) {
    $response['error'] = 'You do not have permission to delete this comment';
    sendJsonResponse($response);
}

$delete_stmt = $conn->prepare("DELETE FROM review_comments WHERE id = ?");
$delete_stmt->bind_param("i", $comment_id);
if ($delete_stmt->execute()) {
    $response = ['status' => 'success', 'comment_id' => $comment_id];
} else {
    $response['error'] = 'Error deleting the comment';
}
$delete_stmt->close();
sendJsonResponse($response);

function sendJsonResponse($response) {
    ob_clean();
    error_log('delete_owner_comment.php response: ' . json_encode($response));
    echo json_encode($response);
    exit;
}
?>