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

    // Validate inputs
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['signup_error'] = 'All fields are required.';
        header('Location: signup.php'); // Redirect back to the signup page
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signup_error'] = 'Invalid email format.';
        header('Location: signup.php'); // Redirect back to the signup page
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['signup_error'] = 'Passwords do not match.';
        header('Location: signup.php'); // Redirect back to the signup page
        exit;
    }

    include 'db_connect.php'; // Include database connection

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['signup_error'] = 'This email is already registered.';
        header('Location: signup.php'); // Redirect back to the signup page
        exit;
    }
    $stmt->close();

    // Hash the password
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
        unset($_SESSION['signup_error']);
        header('Location: index.php'); // Redirect to the homepage
        exit;
    } else {
        $_SESSION['signup_error'] = 'Failed to register. Please try again.';
        header('Location: signup.php'); // Redirect back to the signup page
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect to the signup page if accessed directly
    header('Location: signup.php');
    exit;
}
?>