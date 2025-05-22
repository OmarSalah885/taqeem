<?php
// filepath: c:xampphtdocstaqeemchange_password.php

require_once 'config.php';
require_once 'db_connect.php';
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

    // Initialize an array to store error messages
    $errors = [];

    // Validate inputs
    if (empty($current_password)) {
        $errors['current_password'] = 'Current password is required.';
    }

    if (empty($new_password)) {
        $errors['new_password'] = 'New password is required.';
    } else {
        // Password strength validation (same as signup_handler.php)
        if (strlen($new_password) < 8) {
            $errors['new_password'] = 'New password must be at least 8 characters long.';
        } elseif (!preg_match('/[A-Z]/', $new_password)) {
            $errors['new_password'] = 'New password must contain at least one uppercase letter.';
        } elseif (!preg_match('/[a-z]/', $new_password)) {
            $errors['new_password'] = 'New password must contain at least one lowercase letter.';
        } elseif (!preg_match('/[0-9]/', $new_password)) {
            $errors['new_password'] = 'New password must contain at least one number.';
        } elseif (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $new_password)) {
            $errors['new_password'] = 'New password must contain at least one special character.';
        }
    }

    if (empty($confirm_password)) {
        $errors['confirm_password'] = 'Confirm password is required.';
    } elseif ($new_password !== $confirm_password) {
        $errors['confirm_password'] = 'New password and confirmation do not match.';
    }

    // If there are validation errors, store them and redirect
    if (!empty($errors)) {
        $_SESSION['change_password_errors'] = $errors;
        $_SESSION['change_password_data'] = $_POST;
        header('Location: edit-profile.php?user_id=' . $user_id);
        exit();
    }

    // Fetch user's current hashed password from DB
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($stored_hash);
    $stmt->fetch();
    $stmt->close();

    // Check if current password is correct
    if (!password_verify($current_password, $stored_hash)) {
        $_SESSION['change_password_errors']['current_password'] = 'Current password is incorrect.';
        $_SESSION['change_password_data'] = $_POST;
        header('Location: edit-profile.php?user_id=' . $user_id);
        exit();
    }

    // Update password
    $new_hashed = password_hash($new_password, PASSWORD_BCRYPT);
    $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $update->bind_param('si', $new_hashed, $user_id);

    if ($update->execute()) {
        $_SESSION['success'] = 'Password updated successfully.';
        unset($_SESSION['change_password_errors']);
        unset($_SESSION['change_password_data']);
    } else {
        $_SESSION['change_password_errors']['general'] = 'Something went wrong while updating password.';
        $_SESSION['change_password_data'] = $_POST;
    }

    $update->close();
    header('Location: edit-profile.php?user_id=' . $user_id);
    exit();
}
?>