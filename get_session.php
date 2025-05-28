<?php
session_start();
header('Content-Type: application/json');

$response = ['success' => false, 'data' => null, 'error' => ''];

try {
    if (isset($_SESSION['user_id'])) {
        $response['success'] = true;
        $response['data'] = [
            'user_id' => $_SESSION['user_id'],
            'first_name' => $_SESSION['first_name'],
            'last_name' => $_SESSION['last_name'],
            'profile_image' => $_SESSION['profile_image'] ?? 'assets/images/profiles/pro_null.png',
            'role' => $_SESSION['role'] ?? ''
        ];
    } else {
        $response['error'] = 'No active session';
    }
} catch (Exception $e) {
    $response['error'] = 'Server error occurred';
    error_log("Get session error: " . $e->getMessage(), 3, 'logs/error.log');
}

echo json_encode($response);
exit;
?>