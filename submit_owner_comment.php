<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $review_id = (int)$_POST['review_id'];
    $user_id = (int)$_SESSION['user_id'];
    $comment = trim($_POST['comment']);

    if (!empty($comment)) {
        // ✅ Check if user already commented on this review
        $check = $conn->prepare("SELECT id FROM review_comments WHERE review_id = ? AND user_id = ?");
        $check->bind_param("ii", $review_id, $user_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            // Already commented — prevent duplicate
            echo "<script>alert('You can only comment once on this review. Please edit your existing comment or delete to add more.'); window.history.back();</script>";
            exit;
        }

        $check->close();

        // Insert comment
        $stmt = $conn->prepare("INSERT INTO review_comments (review_id, user_id, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $review_id, $user_id, $comment);
        $stmt->execute();
        $stmt->close();
    }
}

// Redirect back
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
