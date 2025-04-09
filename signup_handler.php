<?php
include 'config.php'; // Include session settings
session_start(); // Start the session

include 'db_connect.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate inputs
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['signup_error'] = 'All fields are required.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signup_error'] = 'Invalid email format.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['signup_error'] = 'Passwords do not match.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['signup_error'] = 'This email is already registered.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    $stmt->close();

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, 'Guest')");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

    if ($stmt->execute()) {
        // Automatically log the user in by setting session variables
        $_SESSION['user_id'] = $stmt->insert_id; // Get the ID of the newly inserted user
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['profile_image'] = 'assets/images/user.jpg'; // Default profile image
        $_SESSION['email'] = $email;

        unset($_SESSION['signup_error']);
        header('Location: index.php'); // Redirect to the homepage
        exit;
    } else {
        $_SESSION['signup_error'] = 'Error: Could not create account. Please try again.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>