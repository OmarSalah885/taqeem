<?php
session_start();
require_once 'config.php';
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['review_id']) || !is_numeric($_POST['review_id']) || !isset($_SESSION['user_id'])) {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Invalid request or not logged in']);
        exit;
    }
    header("Location: single-place.php?error=invalid_request");
    exit;
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Invalid CSRF token']);
        exit;
    }
    header("Location: single-place.php?error=invalid_csrf");
    exit;
}

$review_id = (int)$_POST['review_id'];
$user_id = $_SESSION['user_id'];
$is_admin = $_SESSION['is_admin'] ?? false;

$review_query = $conn->prepare("SELECT user_id, place_id FROM reviews WHERE id = ?");
$review_query->bind_param("i", $review_id);
$review_query->execute();
$review_result = $review_query->get_result();

if ($review_result->num_rows === 0) {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Review not found']);
        exit;
    }
    header("Location: single-place.php?error=review_not_found");
    exit;
}

$review = $review_result->fetch_assoc();
$place_id = $review['place_id'];

if (!$is_admin && $review['user_id'] !== $user_id) {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Unauthorized']);
        exit;
    }
    header("Location: single-place.php?place_id=$place_id&error=unauthorized");
    exit;
}

$rating = isset($_POST['rating']) ? max(1, min(5, (int)$_POST['rating'])) : 0;
$review_text = trim($_POST['review_text'] ?? '');

if ($rating < 1 || empty($review_text)) {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Invalid rating or empty review text']);
        exit;
    }
    header("Location: single-place.php?place_id=$place_id&error=invalid_input");
    exit;
}

$update_query = $conn->prepare("UPDATE reviews SET rating = ?, review_text = ?, updated_at = NOW() WHERE id = ?");
$update_query->bind_param("isi", $rating, $review_text, $review_id);

if ($update_query->execute()) {
    // Handle image deletions
    if (isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
        $delete_query = $conn->prepare("SELECT image_url FROM review_images WHERE id = ? AND review_id = ?");
        $delete_image_query = $conn->prepare("DELETE FROM review_images WHERE id = ? AND review_id = ?");
        foreach ($_POST['delete_images'] as $image_id) {
            $image_id = (int)$image_id;
            $delete_query->bind_param("ii", $image_id, $review_id);
            $delete_query->execute();
            $image_result = $delete_query->get_result();
            if ($image = $image_result->fetch_assoc()) {
                if (file_exists($image['image_url'])) {
                    unlink($image['image_url']);
                }
                $delete_image_query->bind_param("ii", $image_id, $review_id);
                $delete_image_query->execute();
            }
        }
    }

    // Handle new image uploads
    if (isset($_FILES['review_images']) && !empty($_FILES['review_images']['name'][0])) {
        $upload_dir = 'assets/images/review_images/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $files = $_FILES['review_images'];
        $file_count = count($files['name']);
        $existing_images = $conn->prepare("SELECT COUNT(*) as count FROM review_images WHERE review_id = ?");
        $existing_images->bind_param("i", $review_id);
        $existing_images->execute();
        $existing_count = $existing_images->get_result()->fetch_assoc()['count'];
        $allowed_new = 4 - $existing_count;
        $file_count = min($file_count, $allowed_new);

        for ($i = 0; $i < $file_count; $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $file_name = uniqid() . '_' . basename($files['name'][$i]);
                $file_path = $upload_dir . $file_name;
                if (in_array(strtolower(pathinfo($file_name, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']) && getimagesize($files['tmp_name'][$i])) {
                    if (move_uploaded_file($files['tmp_name'][$i], $file_path)) {
                        $image_query = $conn->prepare("INSERT INTO review_images (review_id, image_url) VALUES (?, ?)");
                        $image_query->bind_param("is", $review_id, $file_path);
                        $image_query->execute();
                    }
                }
            }
        }
    }

    // Fetch updated review data
    $review_query = $conn->prepare("
        SELECT r.id, r.user_id, r.rating, r.review_text, r.created_at, 
               CONCAT(u.first_name, ' ', u.last_name) AS user_name, u.profile_image
        FROM reviews r JOIN users u ON r.user_id = u.id 
        WHERE r.id = ?
    ");
    $review_query->bind_param("i", $review_id);
    $review_query->execute();
    $review_result = $review_query->get_result();
    $review = $review_result->fetch_assoc();

    // Fetch images
    $images_query = $conn->prepare("SELECT id, image_url FROM review_images WHERE review_id = ?");
    $images_query->bind_param("i", $review_id);
    $images_query->execute();
    $images_result = $images_query->get_result();
    $images = $images_result->fetch_all(MYSQLI_ASSOC);

    // Fetch updated rating data
    $rating_query = $conn->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM reviews WHERE place_id = ?");
    $rating_query->bind_param("i", $place_id);
    $rating_query->execute();
    $rating_result = $rating_query->get_result();
    $rating_data = $rating_result->fetch_assoc();
    $avg_rating = (float)($rating_data['avg_rating'] ?? 0); // Ensure number
    $total_reviews = (int)($rating_data['total_reviews'] ?? 0);
    $rating_query->close();
    error_log("edit_review.php: place_id=$place_id, avg_rating=$avg_rating, total_reviews=$total_reviews"); // Debug

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

    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        ob_clean();
        header('Content-Type: application/json');
        ob_start();
        include 'review_template.php';
        $review_html = ob_get_clean();

        ob_start();
        ?>
        <form id="editForm-<?= $review_id ?>" method="POST" action="edit_review.php" enctype="multipart/form-data" style="display: none;" class="edit-review-form">
            <input type="hidden" name="review_id" value="<?= $review_id ?>">
            <input type="hidden" name="place_id" value="<?= $place_id ?>">
            <input type="hidden" name="rating" id="rating-<?= $review_id ?>" value="<?= $review['rating'] ?>">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="addReview_stars" data-review-id="<?= $review_id ?>">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                <i class="fa-solid fa-star <?= $i <= $review['rating'] ? 'selected' : '' ?>" data-value="<?= $i ?>"></i>
                <?php endfor; ?>
            </div>
            <a class="btn__transparent--s btn__transparent btn" href="#" onclick="document.getElementById('imageInput-<?= $review_id ?>').click(); return false;">add photos</a>
            <input type="file" name="review_images[]" id="imageInput-<?= $review_id ?>" multiple accept="image/*" style="display: none;">
            <div class="image-preview" id="imagePreview-<?= $review_id ?>">
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
        echo json_encode([
            'success' => true,
            'html' => $combined_html,
            'review_id' => $review_id,
            'avg_rating' => $avg_rating,
            'total_reviews' => $total_reviews,
            'ratings_counts' => $ratings_counts
        ]);
        exit;
    } else {
        header("Location: single-place.php?place_id=$place_id#review_$review_id");
        exit;
    }
} else {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Failed to update review']);
        exit;
    }
    header("Location: single-place.php?place_id=$place_id&error=update_failed");
    exit;
}
?>