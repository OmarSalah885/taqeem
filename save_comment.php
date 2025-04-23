<?php
include 'config.php';
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment_id']) && isset($_POST['comment_text'])) {
    $comment_id = $_POST['comment_id'];
    $comment_text = $_POST['comment_text'];

    // Update the comment in the database
    $update_query = $conn->prepare("UPDATE review_comments SET comment = ? WHERE id = ?");
    $update_query->bind_param("si", $comment_text, $comment_id);
    $update_query->execute();

    if ($update_query->affected_rows > 0) {
        echo 'Comment updated successfully';
    } else {
        echo 'Error updating comment';
    }

    $update_query->close();
}
?>
