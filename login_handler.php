<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $redirect_url = $_POST['redirect_url'] ?? 'index.php';
    $csrf_token = $_POST['csrf_token'] ?? '';

    // Validate CSRF token
    if (!verify_csrf_token($csrf_token)) {
        error_log("CSRF validation failed for login: token=$csrf_token, session={$_SESSION['csrf_token']}", 3, 'logs/error.log');
        $_SESSION['login_errors'] = ['general' => 'Invalid CSRF token.'];
        $_SESSION['login_data'] = $_POST;
        header("Location: $redirect_url");
        exit;
    }

    // Validate inputs
    $errors = [];
    if (empty($email)) {
        $errors['email'] = 'Email is required.';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    }

    if (!empty($errors)) {
        $_SESSION['login_errors'] = $errors;
        $_SESSION['login_data'] = $_POST;
        header("Location: $redirect_url");
        exit;
    }

    // Check user
    try {
        $stmt = $conn->prepare("SELECT id, first_name, last_name, email, password, role, profile_image FROM users WHERE email = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['profile_image'] = !empty($user['profile_image']) ? $user['profile_image'] : 'assets/images/profiles/pro_null.png';

            unset($_SESSION['login_errors']);
            unset($_SESSION['login_data']);
            unset($_SESSION['signup_errors']);
            unset($_SESSION['signup_data']);

            $redirect_url = trim(strtolower($user['role'])) === 'admin' ? "profile.php?user_id={$user['id']}" : $redirect_url;
            header("Location: $redirect_url");
            exit;
        } else {
            $errors['email'] = 'Invalid email or password.';
            error_log("Login failed for email: $email", 3, 'logs/error.log');
            $_SESSION['login_errors'] = $errors;
            $_SESSION['login_data'] = $_POST;
            header("Location: $redirect_url");
            exit;
        }
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage(), 3, 'logs/error.log');
        $_SESSION['login_errors'] = ['general' => 'Database error occurred.'];
        header("Location: $redirect_url");
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
?>