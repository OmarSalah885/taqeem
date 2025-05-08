<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

// Check if the user is logged in and the comment ID is provided
if (isset($_SESSION['user_id']) && isset($_POST['comment_id'])) {
    $user_id = $_SESSION['user_id'];
    $comment_id = $_POST['comment_id'];

    // Verify the comment belongs to the logged-in user
    $stmt = $conn->prepare("SELECT user_id FROM review_comments WHERE id = ?");
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($comment_owner_id);
        $stmt->fetch();

        // Ensure the user is the owner of the comment
        if ($comment_owner_id == $user_id) {
            // Delete the comment
            $delete_stmt = $conn->prepare("DELETE FROM review_comments WHERE id = ?");
            $delete_stmt->bind_param("i", $comment_id);
            if ($delete_stmt->execute()) {
                echo json_encode(['status' => 'success', 'comment_id' => $comment_id]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error deleting the comment.']);
            }
            $delete_stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'You do not have permission to delete this comment.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Comment not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
