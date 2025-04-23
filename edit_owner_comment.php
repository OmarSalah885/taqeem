<?php
session_start();
require_once 'db_connection.php'; // Make sure this includes your database connection

if (isset($_POST['update_comment'])) {
    $comment_id = $_POST['comment_id'];
    $new_comment_text = $_POST['comment_text'];
    $user_id = $_SESSION['user_id'];

    // Update the comment in the database
    $update_query = $conn->prepare("UPDATE review_comments SET comment = ? WHERE id = ? AND user_id = ?");
    $update_query->bind_param("sii", $new_comment_text, $comment_id, $user_id);

    if ($update_query->execute()) {
        // Successfully updated, redirect back to the page with the reviews
        header("Location: place_page.php?place_id=" . $place_id); // Redirect to the place page
        exit;
    } else {
        // Error occurred
        echo "Error updating comment!";
    }

    $update_query->close();
}
?>
