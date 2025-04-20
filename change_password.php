<?php
include 'config.php';
include 'db_connect.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // 1. Fetch user's current hashed password from DB
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($stored_hash);
    $stmt->fetch();
    $stmt->close();

    // 2. Check if current password is correct
    if (!password_verify($current_password, $stored_hash)) {
        $_SESSION['error'] = 'Current password is incorrect.';
        header('Location: edit-profile.php');
        exit();
    }

    // 3. Check new password confirmation
    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = 'New password and confirmation do not match.';
        header('Location: edit-profile.php');
        exit();
    }

    // Optional: Enforce password rules
    if (strlen($new_password) < 6) {
        $_SESSION['error'] = 'New password must be at least 6 characters.';
        header('Location: edit-profile.php');
        exit();
    }

    // 4. Update password
    $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $update->bind_param('si', $new_hashed, $user_id);

    if ($update->execute()) {
        $_SESSION['success'] = 'Password updated successfully.';
    } else {
        $_SESSION['error'] = 'Something went wrong while updating password.';
    }

    $update->close();
    header('Location: edit-profile.php');
    exit();
}
?>
