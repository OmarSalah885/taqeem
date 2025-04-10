<?php
// filepath: c:\xampp\htdocs\taqeem\login_handler.php

include 'config.php'; // Include session settings
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize inputs
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

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
        header('Location: index.php'); // Redirect back to the homepage (where the header is)
        exit;
    }

    include 'db_connect.php'; // Include database connection

    // Check if the email exists
    $stmt = $conn->prepare("SELECT id, first_name, last_name, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            unset($_SESSION['login_errors']); // Clear any previous login errors
            unset($_SESSION['login_data']); // Clear any previous login data
            header('Location: index.php'); // Redirect to the homepage
            exit;
        } else {
            // Password is incorrect
            $_SESSION['login_errors']['password'] = 'Invalid password.';
            $_SESSION['login_data'] = $_POST; // Save the entered data to repopulate the form
            header('Location: index.php'); // Redirect back to the homepage
            exit;
        }
    } else {
        // Email not found
        $_SESSION['login_errors']['email'] = 'No account found with that email.';
        $_SESSION['login_data'] = $_POST; // Save the entered data to repopulate the form
        header('Location: index.php'); // Redirect back to the homepage
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect to the homepage if accessed directly
    header('Location: index.php');
    exit;
}
?>