<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

header('Content-Type: application/json');

// Debug logging
function log_debug($message) {
    file_put_contents('debug.log', date('Y-m-d H:i:s') . " - $message\n", FILE_APPEND);
}

log_debug("submit_comment.php started, method: {$_SERVER['REQUEST_METHOD']}, action: " . ($_POST['action'] ?? 'none'));

function send_error($message, $status = 400) {
    http_response_code($status);
    echo json_encode(['error' => $message]);
    log_debug("Error: $message");
    exit;
}

if (!isset($_SESSION['user_id'])) {
    send_error('You must be logged in to comment.', 401);
}

$user_id = $_SESSION['user_id'];
$is_admin = isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'admin';
$action = $_POST['action'] ?? 'add';
$blog_id = isset($_POST['blog_id']) ? (int)$_POST['blog_id'] : 0;

if ($blog_id <= 0) {
    send_error('Invalid blog ID.');
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
    send_error('Invalid CSRF token.', 403);
}

$stmt = $conn->prepare("SELECT id FROM blogs WHERE id = ?");
$stmt->bind_param("i", $blog_id);
$stmt->execute();
if (!$stmt->get_result()->fetch_assoc()) {
    send_error('Blog not found.');
}
$stmt->close();

if ($action === 'delete') {
    $comment_id = isset($_POST['comment_id']) ? (int)$_POST['comment_id'] : 0;
    if ($comment_id <= 0) {
        send_error('Invalid comment ID.');
    }

    $stmt = $conn->prepare("SELECT user_id FROM blog_comments WHERE id = ?");
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $comment = $result->fetch_assoc();
    $stmt->close();

    if (!$comment) {
        send_error('Comment not found.');
    }

    if ($comment['user_id'] != $user_id && !$is_admin) {
        send_error('Unauthorized action.', 403);
    }

    log_debug("Deleting comment ID: $comment_id");
    $stmt = $conn->prepare("DELETE FROM blog_comments WHERE id = ? OR parent_comment_id = ?");
    $stmt->bind_param("ii", $comment_id, $comment_id);
    if ($stmt->execute()) {
        log_debug("Comment ID: $comment_id deleted successfully");
        echo json_encode(['success' => true]);
        exit;
    } else {
        send_error('Error deleting comment: ' . $stmt->error);
    }
} elseif ($action === 'edit') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        send_error('Invalid request method.');
    }

    $comment_id = isset($_POST['comment_id']) ? (int)$_POST['comment_id'] : 0;
    $comment_text = trim($_POST['comment'] ?? '');

    if ($comment_id <= 0) {
        send_error('Invalid comment ID.');
    }
    if (empty($comment_text)) {
        send_error('Comment cannot be empty.');
    }

    $stmt = $conn->prepare("SELECT user_id FROM blog_comments WHERE id = ?");
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $comment = $result->fetch_assoc();
    $stmt->close();

    if (!$comment) {
        send_error('Comment not found.');
    }

    if ($comment['user_id'] != $user_id && !$is_admin) {
        send_error('Unauthorized action.', 403);
    }

    log_debug("Editing comment ID: $comment_id");
    $stmt = $conn->prepare("UPDATE blog_comments SET comment = ?, created_at = NOW() WHERE id = ?");
    $stmt->bind_param("si", $comment_text, $comment_id);
    if ($stmt->execute()) {
        log_debug("Comment ID: $comment_id edited successfully");
        $stmt = $conn->prepare("
            SELECT blog_comments.id, blog_comments.comment, blog_comments.created_at, 
                blog_comments.parent_comment_id, blog_comments.user_id,
                users.first_name, users.last_name, users.profile_image 
            FROM blog_comments 
            JOIN users ON blog_comments.user_id = users.id 
            WHERE blog_comments.id = ?
        ");
        $stmt->bind_param("i", $comment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $updated_comment = $result->fetch_assoc();
        $stmt->close();
        echo json_encode(['success' => true, 'action' => 'edit', 'comment' => $updated_comment]);
        exit;
    } else {
        send_error('Error updating comment: ' . $stmt->error);
    }
} elseif ($action === 'add') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        send_error('Invalid request method.');
    }

    $comment_text = trim($_POST['comment'] ?? '');
    $parent_comment_id = !empty($_POST['parent_comment_id']) ? (int)$_POST['parent_comment_id'] : null;

    if (empty($comment_text)) {
        send_error('Comment cannot be empty.');
    }

    if ($parent_comment_id) {
        $stmt = $conn->prepare("SELECT id FROM blog_comments WHERE id = ? AND blog_id = ?");
        $stmt->bind_param("ii", $parent_comment_id, $blog_id);
        $stmt->execute();
        if (!$stmt->get_result()->fetch_assoc()) {
            send_error('Invalid parent comment.');
        }
        $stmt->close();
    }

    log_debug("Adding comment for blog ID: $blog_id, parent_comment_id: " . ($parent_comment_id ?? 'null'));
    $stmt = $conn->prepare("INSERT INTO blog_comments (blog_id, user_id, comment, parent_comment_id, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iisi", $blog_id, $user_id, $comment_text, $parent_comment_id);
    if ($stmt->execute()) {
        $comment_id = $conn->insert_id;
        log_debug("Comment added successfully for blog ID: $blog_id, comment ID: $comment_id");
        $stmt = $conn->prepare("
            SELECT blog_comments.id, blog_comments.comment, blog_comments.created_at, 
                blog_comments.parent_comment_id, blog_comments.user_id,
                users.first_name, users.last_name, users.profile_image 
            FROM blog_comments 
            JOIN users ON blog_comments.user_id = users.id 
            WHERE blog_comments.id = ?
        ");
        $stmt->bind_param("i", $comment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $new_comment = $result->fetch_assoc();
        $stmt->close();
        echo json_encode(['success' => true, 'action' => 'add', 'comment' => $new_comment]);
        exit;
    } else {
        send_error('Error adding comment: ' . $stmt->error);
    }
} else {
    send_error('Invalid action.');
}
?>