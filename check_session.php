<?php
session_start();
header('Content-Type: application/json');
$isLoggedIn = isset($_SESSION['user_id']);
error_log("check_session.php: user_id=" . ($_SESSION['user_id'] ?? 'none') . ", isLoggedIn=$isLoggedIn");
echo json_encode(['isLoggedIn' => $isLoggedIn]);
exit;
?>