<?php
// filepath: c:\xampp\htdocs\taqeem\signup_handler.php

include 'config.php'; // Include session settings
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize inputs
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Initialize an array to store error messages
    $errors = [];

    // Validate inputs
    if (empty($first_name)) {
        $errors['first_name'] = 'First name is required.';
    }

    if (empty($last_name)) {
        $errors['last_name'] = 'Last name is required.';
    }

    if (empty($email)) {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    }

    if (empty($confirm_password)) {
        $errors['confirm_password'] = 'Confirm password is required.';
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match.';
    }

    // If there are errors, store them in the session and redirect back
    if (!empty($errors)) {
        $_SESSION['signup_errors'] = $errors;
        $_SESSION['signup_data'] = $_POST;
        header('Location: index.php');
        exit;
    }

    include 'db_connect.php'; // Include database connection

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['signup_errors']['email'] = 'This email is already registered.';
        $_SESSION['signup_data'] = $_POST;
        $stmt->close();
        header('Location: index.php');
        exit;
    }
    $stmt->close();

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the user into the database
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, 'Guest')");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = 'Guest';
        unset($_SESSION['signup_errors']);
        unset($_SESSION['signup_data']);
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['signup_errors']['general'] = 'Failed to register. Please try again.';
        $_SESSION['signup_errors']['mysql'] = $stmt->error;
        $_SESSION['signup_data'] = $_POST;
        header('Location: index.php');
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: index.php');
    exit;
}
