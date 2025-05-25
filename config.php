<?php
// Secure session settings
ini_set('session.cookie_httponly', 1); // Prevent JavaScript access to session cookies
ini_set('session.cookie_secure', 0);  // Use secure cookies (requires HTTPS)
ini_set('session.use_strict_mode', 1); // Prevent session fixation attacks
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CSRF Token Validation
function verify_csrf_token($token) {
    if (!isset($_SESSION['csrf_token']) || empty($token) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}

// Generate CSRF token if not exists
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Error logging for debugging
function log_error($message) {
    $log_dir = __DIR__ . '/logs/';
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, $log_dir . 'error.log');
}

// Upload directory
define('UPLOAD_DIR', 'assets/images/');
?>