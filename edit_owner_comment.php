<?php
require_once 'config.php';
require_once 'db_connect.php';


header('Content-Type: application/json');

if (!isset($_POST['update_comment']) || !isset($_POST['comment_id']) || !isset($_POST['comment_text']) || !isset($_POST['csrf_token'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit;
}

if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['success' => false, 'error' => 'Invalid CSRF token']);
    exit;
}

$comment_id = intval($_POST['comment_id']);
$comment_text = $_POST['comment_text'];
$user_id = $_SESSION['user_id'];

// Remove potential date prefix if present (format "Date: Comment")
if (strpos($comment_text, ': ') !== false) {
    $parts = explode(': ', $comment_text, 2);
    $comment_text = $parts[1];
}

// Check if the logged-in user is the author of the comment
$query = $conn->prepare("SELECT user_id FROM review_comments WHERE id = ?");
$query->bind_param("i", $comment_id);
$query->execute();
$query->bind_result($owner_id);
$query->fetch();
$query->close();

if ($owner_id == $user_id) {
    // Update the comment
    $update_query = $conn->prepare("UPDATE review_comments SET comment = ? WHERE id = ? AND user_id = ?");
    $update_query->bind_param("sii", $comment_text, $comment_id, $user_id);
    if ($update_query->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error updating comment']);
    }
    $update_query->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
}

exit;
?>