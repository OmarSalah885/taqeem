<?php
include 'config.php';
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $review_id = (int)$_POST['review_id'];
    $user_id = (int)$_SESSION['user_id'];
    $comment = trim($_POST['comment']);

    if (!empty($comment)) {
        $stmt = $conn->prepare("INSERT INTO review_comments (review_id, user_id, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $review_id, $user_id, $comment);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
