<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Retrieve and sanitize inputs
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$redirect_url = $_POST['redirect_url'] ?? 'index.php';
$csrf_token = $_POST['csrf_token'] ?? '';

// Validate CSRF token
if (!verify_csrf_token($csrf_token)) {
    $_SESSION['signup_errors'] = ['general' => 'Invalid CSRF token.'];
    header("Location: $redirect_url");
    exit;
}

// Validate inputs
$errors = [];
if (empty($first_name)) {
    $errors['first_name'] = 'First name is required.';
} elseif (strlen($first_name) > 50) {
    $errors['first_name'] = 'First name cannot exceed 50 characters.';
}
if (empty($last_name)) {
    $errors['last_name'] = 'Last name is required.';
} elseif (strlen($last_name) > 50) {
    $errors['last_name'] = 'Last name cannot exceed 50 characters.';
}
if (empty($email)) {
    $errors['email'] = 'Email is required.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Invalid email format.';
} elseif (strlen($email) > 100) {
    $errors['email'] = 'Email cannot exceed 100 characters.';
}
if (empty($password)) {
    $errors['password'] = 'Password is required.';
} elseif (strlen($password) < 8) {
    $errors['password'] = 'Password must be at least 8 characters long.';
} elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || 
         !preg_match('/[0-9]/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
    $errors['password'] = 'Password must include uppercase, lowercase, number, and special character.';
}
if ($password !== $confirm_password) {
    $errors['confirm_password'] = 'Passwords do not match.';
}

// Check if email already exists
if (empty($errors)) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->fetch_assoc()) {
        $errors['email'] = 'This email is already registered.';
    }
    $stmt->close();
}

if (!empty($errors)) {
    $_SESSION['signup_errors'] = $errors;
    $_SESSION['signup_data'] = $_POST;
    header("Location: $redirect_url");
    exit;
}

// Hash password and insert user
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$default_profile_image = 'assets/images/profiles/pro_null.png';
$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, profile_image, role, created_at) VALUES (?, ?, ?, ?, ?, 'user', NOW())");
$stmt->bind_param("sssss", $first_name, $last_name, $email, $hashed_password, $default_profile_image);

if ($stmt->execute()) {
    $user_id = $stmt->insert_id;
    // Log in the new user
    $_SESSION['user_id'] = $user_id;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['email'] = $email;
    $_SESSION['role'] = 'user';
    $_SESSION['profile_image'] = $default_profile_image;

    unset($_SESSION['signup_errors']);
    unset($_SESSION['signup_data']);
    unset($_SESSION['login_errors']);
    unset($_SESSION['login_data']);

    header("Location: $redirect_url");
    exit;
} else {
    $errors['general'] = 'Error creating account: ' . $stmt->error;
    $_SESSION['signup_errors'] = $errors;
    $_SESSION['signup_data'] = $_POST;
    $stmt->close();
    header("Location: $redirect_url");
    exit;
}
?>