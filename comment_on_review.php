<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $review_id = (int)$_POST['review_id'];
        $comment = trim($_POST['comment']);

        // Validate input
        if (empty($comment)) {
            echo "Comment cannot be empty.";
            exit;
        }

        // Check if the user owns the place
        $place_query = $conn->prepare("
            SELECT p.id
            FROM places p
            JOIN reviews r ON r.place_id = p.id
            WHERE r.id = ? AND p.user_id = ?
        ");
        $place_query->bind_param("ii", $review_id, $user_id);
        $place_query->execute();
        $place_result = $place_query->get_result();

        if ($place_result->num_rows > 0) {
            // Insert the comment into the database
            $comment_query = $conn->prepare("
                INSERT INTO review_comments (review_id, comment, created_at)
                VALUES (?, ?, NOW())
            ");
            $comment_query->bind_param("is", $review_id, $comment);

            if ($comment_query->execute()) {
                echo "success";
            } else {
                echo "Failed to add comment.";
            }
        } else {
            echo "You are not authorized to comment on this review.";
        }
    } else {
        echo "You must be logged in to comment.";
    }
}
?>