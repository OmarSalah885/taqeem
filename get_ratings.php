<?php
// Clear any prior output
ob_start();
ob_clean();


require_once 'config.php';
require_once 'db_connect.php';

try {
    // Check database connection
    if (!$conn || $conn->connect_error) {
        throw new Exception('Database connection failed: ' . ($conn ? $conn->connect_error : 'No connection object'));
    }

    if (!isset($_GET['place_id']) || !is_numeric($_GET['place_id'])) {
        throw new Exception('Invalid place ID');
    }

    $place_id = (int)$_GET['place_id'];

    $rating_query = $conn->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM reviews WHERE place_id = ?");
    if (!$rating_query) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    $rating_query->bind_param("i", $place_id);
    if (!$rating_query->execute()) {
        throw new Exception('Execute failed: ' . $rating_query->error);
    }
    $rating_result = $rating_query->get_result();
    $rating_data = $rating_result->fetch_assoc();
    $avg_rating = (float)($rating_data['avg_rating'] ?? 0);
    $total_reviews = (int)($rating_data['total_reviews'] ?? 0);
    $rating_query->close();

    $ratings_counts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
    $ratings_query = $conn->prepare("SELECT rating, COUNT(*) AS count FROM reviews WHERE place_id = ? GROUP BY rating");
    if (!$ratings_query) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    $ratings_query->bind_param("i", $place_id);
    if (!$ratings_query->execute()) {
        throw new Exception('Execute failed: ' . $ratings_query->error);
    }
    $ratings_result = $ratings_query->get_result();
    while ($row = $ratings_result->fetch_assoc()) {
        $ratings_counts[(int)$row['rating']] = (int)$row['count'];
    }
    $ratings_query->close();

    // Ensure no output has been sent before JSON
    if (ob_get_length()) {
        error_log("get_ratings.php: Unexpected output before JSON: " . ob_get_contents());
        ob_clean();
    }

    header('Content-Type: application/json');
    error_log("get_ratings.php: place_id=$place_id, avg_rating=$avg_rating, total_reviews=$total_reviews");
    echo json_encode([
        'success' => true,
        'avg_rating' => $avg_rating,
        'total_reviews' => $total_reviews,
        'ratings_counts' => $ratings_counts
    ]);
} catch (Exception $e) {
    if (ob_get_length()) {
        error_log("get_ratings.php: Output before error: " . ob_get_contents());
        ob_clean();
    }
    header('Content-Type: application/json');
    $error_msg = "get_ratings.php error: " . $e->getMessage();
    error_log($error_msg);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    exit;
}
?>