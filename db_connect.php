<?php
$servername = "localhost";
$username = "root";
$db_password = "";
$database = "taqeem";

$conn = new mysqli($servername, $username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    $error = "Connection failed: " . $conn->connect_error;
    error_log($error);
    // Check if this is an AJAX request
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => $error]);
        exit;
    } else {
        die($error);
    }
}
?>