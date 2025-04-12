<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        die('You must be logged in to comment.');
    }

    // Retrieve and sanitize inputs
    $user_id = $_SESSION['user_id'];
    $blog_id = isset($_POST['blog_id']) ? (int)$_POST['blog_id'] : 0;
    $comment = trim($_POST['comment']);
    $parent_comment_id = isset($_POST['parent_comment_id']) ? (int)$_POST['parent_comment_id'] : null;

    if (empty($comment)) {
        die('Comment cannot be empty.');
    }

    // Insert the comment into the database
    $stmt = $conn->prepare("INSERT INTO blog_comments (blog_id, user_id, comment, parent_comment_id, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iisi", $blog_id, $user_id, $comment, $parent_comment_id);

    if ($stmt->execute()) {
        // Redirect back to the blog page
        header("Location: single-blog.php?id=$blog_id");
        exit;
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>