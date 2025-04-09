<?php
include 'config.php'; // Include session settings
session_start(); // Start the session

include 'db_connect.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = 'Email and password are required.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Check if the email exists
    $stmt = $conn->prepare("SELECT id, first_name, last_name, profile_image, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['profile_image'] = $user['profile_image'] ?? 'assets/images/user.jpg';
            $_SESSION['email'] = $email;

            unset($_SESSION['login_error']);
            header('Location: index.php'); // Redirect to a specific page
            exit;
        } else {
            $_SESSION['login_error'] = 'Invalid password.';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    } else {
        $_SESSION['login_error'] = 'Invalid email.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
?>