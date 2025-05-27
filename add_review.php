<?php
ob_start(); // Start output buffering at the top
require_once 'config.php';
require_once 'db_connect.php';
session_start();
// Initialize response
$response = ['success' => false, 'error' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['error'] = 'Invalid request method';
    sendJsonResponse($response);
}

if (!isset($_POST['place_id']) || !is_numeric($_POST['place_id'])) {
    $response['error'] = 'Invalid place ID';
    sendJsonResponse($response);
}

$place_id = (int)$_POST['place_id'];

if (!isset($_SESSION['user_id'])) {
    $response['error'] = 'User not logged in';
    sendJsonResponse($response);
}

$user_id = $_SESSION['user_id'];
$rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
$review_text = trim($_POST['review_text'] ?? '');

if ($rating < 1 || $rating > 5) {
    $response['error'] = 'Invalid rating';
    sendJsonResponse($response);
}

if (empty($review_text)) {
    $response['error'] = 'Review text cannot be empty';
    sendJsonResponse($response);
}

$insert_query = $conn->prepare("INSERT INTO reviews (place_id, user_id, rating, review_text, created_at) VALUES (?, ?, ?, ?, NOW())");
$insert_query->bind_param("iiis", $place_id, $user_id, $rating, $review_text);

if ($insert_query->execute()) {
    $new_review_id = $conn->insert_id;
    
    // Handle image uploads
    handleImageUploads($new_review_id, $place_id, $conn, $response);
    if (!$response['success']) {
        // Roll back review if image upload fails critically
        $conn->query("DELETE FROM reviews WHERE id = $new_review_id");
        sendJsonResponse($response);
    }
    
    // Fetch review data
    $review_query = $conn->prepare("
        SELECT r.id, r.user_id, r.rating, r.review_text, r.created_at, 
               CONCAT(u.first_name, ' ', u.last_name) AS user_name, u.profile_image
        FROM reviews r JOIN users u ON r.user_id = u.id 
        WHERE r.id = ?
    ");
    $review_query->bind_param("i", $new_review_id);
    $review_query->execute();
    $review_result = $review_query->get_result();
    $review = $review_result->fetch_assoc();
    $review_query->close();
    
    // Fetch images
    $images_query = $conn->prepare("SELECT id, image_url FROM review_images WHERE review_id = ?");
    $images_query->bind_param("i", $new_review_id);
    $images_query->execute();
    $images_result = $images_query->get_result();
    $images = $images_result->fetch_all(MYSQLI_ASSOC);
    $images_query->close();
    
    // Fetch updated rating data
    $rating_query = $conn->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM reviews WHERE place_id = ?");
    $rating_query->bind_param("i", $place_id);
    $rating_query->execute();
    $rating_result = $rating_query->get_result();
    $rating_data = $rating_result->fetch_assoc();
    $avg_rating = (float)($rating_data['avg_rating'] ?? 0);
    $total_reviews = (int)($rating_data['total_reviews'] ?? 0);
    $rating_query->close();
    error_log("add_review.php: place_id=$place_id, avg_rating=$avg_rating, total_reviews=$total_reviews");

    $ratings_counts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
    $ratings_query = $conn->prepare("SELECT rating, COUNT(*) AS count FROM reviews WHERE place_id = ? GROUP BY rating");
    $ratings_query->bind_param("i", $place_id);
    $ratings_query->execute();
    $ratings_result = $ratings_query->get_result();
    while ($row = $ratings_result->fetch_assoc()) {
        $ratings_counts[(int)$row['rating']] = (int)$row['count'];
    }
    $ratings_query->close();
    
    // Determine permissions
    $can_edit = true;
    $is_liked = false;
    $is_admin = $_SESSION['is_admin'] ?? false;
    $owner_query = $conn->prepare("SELECT user_id AS owner_id FROM places WHERE id = ?");
    $owner_query->bind_param("i", $place_id);
    $owner_query->execute();
    $owner_result = $owner_query->get_result();
    $is_owner = $owner_result->num_rows > 0 && $owner_result->fetch_assoc()['owner_id'] == $user_id;
    $owner_query->close();
    
    ob_start();
    include 'review_template.php';
    $review_html = ob_get_clean();
    
    ob_start();
    ?>
    <form id="editForm-<?= $new_review_id ?>" method="POST" action="edit_review.php" enctype="multipart/form-data" style="display: none;" class="edit-review-form">
        <input type="hidden" name="review_id" value="<?= $new_review_id ?>">
        <input type="hidden" name="place_id" value="<?= $place_id ?>">
        <input type="hidden" name="rating" id="rating-<?= $new_review_id ?>" value="<?= $review['rating'] ?>">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="addReview_stars" data-review-id="<?= $new_review_id ?>">
            <?php for ($i = 1; $i <= 5; $i++): ?>
            <i class="fa-solid fa-star <?= $i <= $review['rating'] ? 'selected' : '' ?>" data-value="<?= $i ?>"></i>
            <?php endfor; ?>
        </div>
        <a class="btn__transparent--s btn__transparent btn" href="#" onclick="document.getElementById('imageInput-<?= $new_review_id ?>').click(); return false;">add photos</a>
        <input type="file" name="review_images[]" id="imageInput-<?= $new_review_id ?>" multiple accept="image/*" style="display: none;">
        <div class="image-preview" id="imagePreview-<?= $new_review_id ?>">
            <?php foreach ($images as $image): ?>
            <div class="image-thumb" data-img-id="<?= htmlspecialchars($image['id']) ?>">
                <img src="<?= htmlspecialchars($image['image_url']) ?>" alt="Review Image">
                <span class="remove-image existing">×</span>
            </div>
            <?php endforeach; ?>
        </div>
        <textarea name="review_text" required><?= htmlspecialchars($review['review_text']) ?></textarea>
        <button type="submit" class="btn__red--s btn__red btn">Save Changes</button>
    </form>
    <?php
    $edit_form_html = ob_get_clean();
    
    $combined_html = $review_html . $edit_form_html;
    
    $response = [
        'success' => true,
        'html' => $combined_html,
        'review_id' => $new_review_id,
        'avg_rating' => $avg_rating,
        'total_reviews' => $total_reviews,
        'ratings_counts' => $ratings_counts
    ];
    sendJsonResponse($response);
} else {
    $response['error'] = 'Failed to add review';
    sendJsonResponse($response);
}

function handleImageUploads($review_id, $place_id, $conn, &$response) {
    if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
        $response['success'] = true;
        return;
    }
    
    $upload_dir = 'assets/images/review_images/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $files = $_FILES['images'];
    $file_count = count($files['name']);
    
    if ($file_count > 4) {
        $response['error'] = 'Maximum 4 images allowed';
        return;
    }
    
    for ($i = 0; $i < $file_count; $i++) {
        if ($files['error'][$i] === UPLOAD_ERR_OK) {
            $file_name = uniqid() . '_' . basename($files['name'][$i]);
            $file_path = $upload_dir . $file_name;
            if (move_uploaded_file($files['tmp_name'][$i], $file_path)) {
                $image_query = $conn->prepare("INSERT INTO review_images (review_id, image_url) VALUES (?, ?)");
                $image_query->bind_param("is", $review_id, $file_path);
                $image_query->execute();
                $image_query->close();
            } else {
                $response['error'] = 'Failed to upload image';
                return;
            }
        }
    }
    $response['success'] = true;
}

function sendJsonResponse($response) {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>