<?php
include 'config.php';
include 'db_connect.php';

// Number of reviews to load per request
$limit = 8;
$pool_limit = 1000; // The pool of recent reviews to choose from

// Step 1: Get the latest 500 review IDs
$id_stmt = $conn->prepare("SELECT id FROM reviews ORDER BY created_at DESC LIMIT ?");
$id_stmt->bind_param("i", $pool_limit);
$id_stmt->execute();
$id_result = $id_stmt->get_result();

$review_ids = [];
while ($row = $id_result->fetch_assoc()) {
    $review_ids[] = $row['id'];
}
$id_stmt->close();

// If not enough reviews, adjust limit
if (count($review_ids) < $limit) {
    $limit = count($review_ids);
}

// Step 2: Randomly pick $limit IDs
shuffle($review_ids); // Shuffle for randomness
$selected_ids = array_slice($review_ids, 0, $limit);

// Step 3: Fetch full review details
$placeholders = implode(',', array_fill(0, count($selected_ids), '?'));
$types = str_repeat('i', count($selected_ids));
$stmt = $conn->prepare("
    SELECT 
        r.id AS review_id, 
        r.review_text, 
        r.rating, 
        r.created_at, 
        p.id AS place_id, 
        p.name AS place_name, 
        p.featured_image AS review_image, 
        c.icon AS icon_class, 
        u.id AS user_id, 
        CONCAT(u.first_name, ' ', u.last_name) AS user_name, 
        u.profile_image AS user_profile_image
    FROM reviews r
    INNER JOIN places p ON r.place_id = p.id
    LEFT JOIN categories c ON p.category_id = c.id
    INNER JOIN users u ON r.user_id = u.id
    WHERE r.id IN ($placeholders)
");

$stmt->bind_param($types, ...$selected_ids);
$stmt->execute();
$result = $stmt->get_result();

// Include the review card template for each review
while ($row = $result->fetch_assoc()) {
    include 'review_card.php';
}
$stmt->close();
?>
