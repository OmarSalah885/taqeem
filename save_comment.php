<?php
session_start();
include 'config.php';
include 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

if (isset($_POST['comment_id']) && isset($_POST['comment_text'])) {
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
        $update = $conn->prepare("UPDATE review_comments SET comment = ? WHERE id = ?");
        $update->bind_param("si", $comment_text, $comment_id);
        if ($update->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update comment']);
        }
        $update->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
