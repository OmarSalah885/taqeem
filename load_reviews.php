<?php
include 'config.php'; // Include database connection
include 'db_connect.php';
// Get the offset from the AJAX request
$offset = isset($_POST['offset']) && is_numeric($_POST['offset']) ? (int)$_POST['offset'] : 0;

// Number of reviews to load per request
$limit = 8;

// Fetch reviews with all necessary fields
$query = $conn->prepare("
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
    ORDER BY r.created_at DESC
    LIMIT ? OFFSET ?
");
$query->bind_param("ii", $limit, $offset);
$query->execute();
$result = $query->get_result();

// Include the review card template for each review
while ($row = $result->fetch_assoc()) {
    include 'review_card.php';
}
?>
