<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

// Debug logging
function log_debug($message) {
    file_put_contents('debug.log', date('Y-m-d H:i:s') . " - $message\n", FILE_APPEND);
}

log_debug("submit_comment.php started, method: {$_SERVER['REQUEST_METHOD']}, action: " . ($_GET['action'] ?? $_POST['action'] ?? 'none'));

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'You must be logged in to comment.';
    $blog_id = isset($_GET['blog_id']) ? (int)$_GET['blog_id'] : (isset($_POST['blog_id']) ? (int)$_POST['blog_id'] : 0);
    header("Location: login.php?redirect=single-blog.php?id=$blog_id");
    exit;
}

$user_id = $_SESSION['user_id'];
$is_admin = isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'admin';
$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : 'add');
$blog_id = isset($_GET['blog_id']) ? (int)$_GET['blog_id'] : (isset($_POST['blog_id']) ? (int)$_POST['blog_id'] : 0);

if ($blog_id <= 0) {
    $_SESSION['error'] = 'Invalid blog ID.';
    header("Location: single-blog.php?id=$blog_id");
    exit;
}

$stmt = $conn->prepare("SELECT id FROM blogs WHERE id = ?");
$stmt->bind_param("i", $blog_id);
$stmt->execute();
if (!$stmt->get_result()->fetch_assoc()) {
    $_SESSION['error'] = 'Blog not found.';
    header("Location: single-blog.php?id=$blog_id");
    exit;
}
$stmt->close();

if ($action === 'delete') {
    $comment_id = isset($_GET['comment_id']) ? (int)$_GET['comment_id'] : 0;
    if ($comment_id <= 0) {
        $_SESSION['error'] = 'Invalid comment ID.';
        header("Location: single-blog.php?id=$blog_id");
        exit;
    }

    $stmt = $conn->prepare("SELECT user_id FROM blog_comments WHERE id = ?");
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $comment = $result->fetch_assoc();
    $stmt->close();

    if (!$comment) {
        $_SESSION['error'] = 'Comment not found.';
        header("Location: single-blog.php?id=$blog_id");
        exit;
    }

    if ($comment['user_id'] != $user_id && !$is_admin) {
        $_SESSION['error'] = 'Unauthorized action.';
        header("Location: single-blog.php?id=$blog_id");
        exit;
    }

    log_debug("Deleting comment ID: $comment_id");
    $stmt = $conn->prepare("DELETE FROM blog_comments WHERE id = ? OR parent_comment_id = ?");
    $stmt->bind_param("ii", $comment_id, $comment_id);
    if ($stmt->execute()) {
        log_debug("Comment ID: $comment_id deleted successfully");
        header("Location: single-blog.php?id=$blog_id");
        exit;
    } else {
        $_SESSION['error'] = 'Error deleting comment: ' . $stmt->error;
        log_debug("Error deleting comment ID: $comment_id, error: {$stmt->error}");
        header("Location: single-blog.php?id=$blog_id");
        $stmt->close();
        exit;
    }
} elseif ($action === 'edit') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = 'Invalid request method.';
        header("Location: single-blog.php?id=$blog_id");
        exit;
    }

    $comment_id = isset($_POST['comment_id']) ? (int)$_POST['comment_id'] : 0;
    $comment_text = trim($_POST['comment']);

    if ($comment_id <= 0) {
        $_SESSION['error'] = 'Invalid comment ID.';
        header("Location: single-blog.php?id=$blog_id");
        exit;
    }
    if (empty($comment_text)) {
        $_SESSION['error'] = 'Comment cannot be empty.';
        header("Location: single-blog.php?id=$blog_id");
        exit;
    }

    $stmt = $conn->prepare("SELECT user_id FROM blog_comments WHERE id = ?");
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $comment = $result->fetch_assoc();
    $stmt->close();

    if (!$comment) {
        $_SESSION['error'] = 'Comment not found.';
        header("Location: single-blog.php?id=$blog_id");
        exit;
    }

    if ($comment['user_id'] != $user_id && !$is_admin) {
        $_SESSION['error'] = 'Unauthorized action.';
        header("Location: single-blog.php?id=$blog_id");
        exit;
    }

    log_debug("Editing comment ID: $comment_id");
    $stmt = $conn->prepare("UPDATE blog_comments SET comment = ?, created_at = NOW() WHERE id = ?");
    $stmt->bind_param("si", $comment_text, $comment_id);
    if ($stmt->execute()) {
        log_debug("Comment ID: $comment_id edited successfully");
        header("Location: single-blog.php?id=$blog_id");
        exit;
    } else {
        $_SESSION['error'] = 'Error updating comment: ' . $stmt->error;
        log_debug("Error editing comment ID: $comment_id, error: {$stmt->error}");
        header("Location: single-blog.php?id=$blog_id");
        $stmt->close();
        exit;
    }
} elseif ($action === 'add') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error'] = 'Invalid request method.';
        header("Location: single-blog.php?id=$blog_id");
        exit;
    }

    $comment_text = trim($_POST['comment']);
    $parent_comment_id = !empty($_POST['parent_comment_id']) ? (int)$_POST['parent_comment_id'] : null;

    if (empty($comment_text)) {
        $_SESSION['error'] = 'Comment cannot be empty.';
        header("Location: single-blog.php?id=$blog_id");
        exit;
    }

    if ($parent_comment_id) {
        $stmt = $conn->prepare("SELECT id FROM blog_comments WHERE id = ? AND blog_id = ?");
        $stmt->bind_param("ii", $parent_comment_id, $blog_id);
        $stmt->execute();
        if (!$stmt->get_result()->fetch_assoc()) {
            $_SESSION['error'] = 'Invalid parent comment.';
            header("Location: single-blog.php?id=$blog_id");
            exit;
        }
        $stmt->close();
    }

    log_debug("Adding comment for blog ID: $blog_id, parent_comment_id: " . ($parent_comment_id ?? 'null'));
    $stmt = $conn->prepare("INSERT INTO blog_comments (blog_id, user_id, comment, parent_comment_id, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iisi", $blog_id, $user_id, $comment_text, $parent_comment_id);
    if ($stmt->execute()) {
        log_debug("Comment added successfully for blog ID: $blog_id");
        header("Location: single-blog.php?id=$blog_id");
        exit;
    } else {
        $_SESSION['error'] = 'Error adding comment: ' . $stmt->error;
        log_debug("Error adding comment for blog ID: $blog_id, error: {$stmt->error}");
        header("Location: single-blog.php?id=$blog_id");
        exit;
    }
} else {
    $_SESSION['error'] = 'Invalid action.';
    header("Location: single-blog.php?id=$blog_id");
    exit;
}

?>