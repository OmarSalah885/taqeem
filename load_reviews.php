<?php
include 'db_connect.php';


$offset = isset($_POST['offset']) ? (int)$_POST['offset'] : 0;
$limit = 8;

$query = "SELECT r.id AS review_id, r.review_text, r.rating, r.created_at, 
          p.name AS place_name, CONCAT(u.first_name, ' ', u.last_name) AS user_name, 
          u.profile_image AS user_profile_image, ri.image_url AS review_image, c.icon AS icon_class
          FROM reviews r
          JOIN places p ON r.place_id = p.id
          JOIN users u ON r.user_id = u.id
          JOIN review_images ri ON r.id = ri.review_id
          JOIN categories c ON p.category_id = c.id
          ORDER BY r.created_at DESC
          LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        include 'review_card.php'; // Load review card template
    }
} else {
    echo "";
}
?>
