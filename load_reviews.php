<?php
require_once 'db_connect.php';

$limit = 8;
$pool_limit = 1000;

// Step 1: Get IDs of recent reviews **that have images**
$id_stmt = $conn->prepare("
    SELECT DISTINCT r.id 
    FROM reviews r
    JOIN review_images ri ON r.id = ri.review_id
    ORDER BY r.created_at DESC
    LIMIT ?
");
$id_stmt->bind_param("i", $pool_limit);
$id_stmt->execute();
$id_result = $id_stmt->get_result();

$review_ids = [];
while ($row = $id_result->fetch_assoc()) {
    $review_ids[] = $row['id'];
}
$id_stmt->close();

// Adjust limit if fewer available
if (count($review_ids) < $limit) {
    $limit = count($review_ids);
}
if ($limit === 0) {
    exit; // No more reviews to load
}

// Step 2: Shuffle and pick random review IDs
shuffle($review_ids);
$selected_ids = array_slice($review_ids, 0, $limit);

// Step 3: Fetch full details
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
        ri.image_url AS review_image,
        c.icon AS icon_class, 
        u.id AS user_id, 
        CONCAT(u.first_name, ' ', u.last_name) AS user_name, 
        u.profile_image AS user_profile_image
    FROM reviews r
    INNER JOIN review_images ri ON r.id = ri.review_id
    INNER JOIN places p ON r.place_id = p.id
    LEFT JOIN categories c ON p.category_id = c.id
    INNER JOIN users u ON r.user_id = u.id
    WHERE r.id IN ($placeholders)
    GROUP BY r.id
");
$stmt->bind_param($types, ...$selected_ids);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    include 'review_card.php';
}
$stmt->close();
?>
