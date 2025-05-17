<?php
// filepath: c:xampphtdocstaqeemlogin_handler.php

require_once 'config.php';
require_once 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize inputs
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $redirect_url = $_POST['redirect_url'] ?? 'index.php'; // Default to index.php if no redirect URL is provided

    // Initialize an array to store error messages
    $errors = [];

    // Validate inputs
    if (empty($email)) {
        $errors['email'] = 'Email is required.';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    }

    // If there are errors, store them in the session and redirect back
    if (!empty($errors)) {
        $_SESSION['login_errors'] = $errors;
        $_SESSION['login_data'] = $_POST; // Save the entered data to repopulate the form
        header("Location: $redirect_url");
        exit;
    }

    

    // Check if the email exists
    $stmt = $conn->prepare("SELECT id, first_name, last_name, email, password, role, profile_image FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Check the password using password_verify for hashed passwords
        if (password_verify($password, $user['password'])) {
            // Password is correct
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            $_SESSION['profile_image'] = !empty($user['profile_image']) ? $user['profile_image'] : 'assets/images/profiles/pro_null.png';

// Clear temporary login form data
unset($_SESSION['login_errors']);
unset($_SESSION['login_data']);

// ✅ Redirect based on role
if (isset($user['role']) && trim(strtolower($user['role'])) === 'admin') {

    header("Location: profile.php?user_id=".$_SESSION['user_id']); // Redirect to admin profile page
} else {
    header("Location: $redirect_url"); // or "index.php"
}
exit;


        } else {
            // Password is incorrect
            $_SESSION['login_errors']['password'] = 'Invalid password.';
            $_SESSION['login_data'] = $_POST;
            header("Location: $redirect_url");
            exit;
        }
    } else {
        // Email not found
        $_SESSION['login_errors']['email'] = 'No account found with that email.';
        $_SESSION['login_data'] = $_POST;
        $stmt->close();
        $conn->close();
        header("Location: $redirect_url");
        exit;
    }

} else {
    header('Location: index.php');
    exit;
}
