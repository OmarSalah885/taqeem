<?php
require_once 'config.php';
require_once 'db_connect.php';


header('Content-Type: application/json'); // Set the response type to JSON

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to save a place.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$place_id = isset($_POST['place_id']) ? (int)$_POST['place_id'] : 0;

if ($place_id === 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid place ID.']);
    exit;
}

// Check if the place is already saved
$check_save_query = $conn->prepare("SELECT id FROM saved_places WHERE user_id = ? AND place_id = ?");
$check_save_query->bind_param("ii", $user_id, $place_id);
$check_save_query->execute();
$check_save_result = $check_save_query->get_result();

if ($check_save_result->num_rows > 0) {
    // Unsave the place
    $delete_save_query = $conn->prepare("DELETE FROM saved_places WHERE user_id = ? AND place_id = ?");
    $delete_save_query->bind_param("ii", $user_id, $place_id);
    $delete_save_query->execute();
    echo json_encode(['success' => true, 'is_saved' => false]);
} else {
    // Save the place
    $insert_save_query = $conn->prepare("INSERT INTO saved_places (user_id, place_id, created_at) VALUES (?, ?, NOW())");
    $insert_save_query->bind_param("ii", $user_id, $place_id);
    $insert_save_query->execute();
    echo json_encode(['success' => true, 'is_saved' => true]);
}
?>