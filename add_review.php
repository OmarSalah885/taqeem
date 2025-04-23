<?php
include 'config.php';
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    if (isset($_POST['place_id']) && is_numeric($_POST['place_id'])) {
        $place_id = (int)$_POST['place_id'];
    } else {
        header("Location: ss.php?error=invalid_place_id");
        exit;
    }

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $rating = (int)$_POST['rating'];
        $review_text = trim($_POST['review_text']);
        $review_id = isset($_POST['review_id']) && is_numeric($_POST['review_id']) ? (int)$_POST['review_id'] : null;

        // Validate input
        if ($rating < 1 || $rating > 5) {
            header("Location: ss.php?error=invalid_rating");
            exit;
        } elseif (empty($review_text)) {
            header("Location: ss.php?error=empty_review");
            exit;
        }

        if ($review_id) {
            // Update the existing review
            $update_query = $conn->prepare("
                UPDATE reviews
                SET rating = ?, review_text = ?, updated_at = NOW()
                WHERE id = ? AND user_id = ?
            ");
            $update_query->bind_param("isii", $rating, $review_text, $review_id, $user_id);

            if ($update_query->execute()) {
                handleImageUploads($review_id, $conn);
                header("Location: single-place.php?place_id=$place_id#reviews");
                exit;
            } else {
                header("Location: single-place.php?error=update_failed");
                exit;
            }
        } else {
            // Insert a new review
            $insert_query = $conn->prepare("
                INSERT INTO reviews (place_id, user_id, rating, review_text, created_at)
                VALUES (?, ?, ?, ?, NOW())
            ");
            $insert_query->bind_param("iiis", $place_id, $user_id, $rating, $review_text);

            if ($insert_query->execute()) {
                $new_review_id = $conn->insert_id;
                handleImageUploads($new_review_id, $conn);
                header("Location: single-place.php?place_id=$place_id#reviews");
                exit;
            } else {
                header("Location: single-place.php?error=insert_failed");
                exit;
            }
        }
    } else {
        header("Location: single-place.php?error=not_logged_in");
        exit;
    }
}

function handleImageUploads($review_id, $conn) {
    if (!empty($_FILES['images']['name'][0])) {
        $upload_dir = 'assets/images/review_images/'; // Update to the correct directory
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_count = count($_FILES['images']['name']);
        if ($file_count > 4) {
            header("Location: single-place.php?error=too_many_images");
            exit;
        }

        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['images']['name'][$key]);
            $target_file = $upload_dir . uniqid() . '_' . $file_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                // Insert the image URL into the database
                $image_query = $conn->prepare("
                    INSERT INTO review_images (review_id, image_url, uploaded_at)
                    VALUES (?, ?, NOW())
                ");
                $image_query->bind_param("is", $review_id, $target_file);
                $image_query->execute();
                $image_query->close();
            }
        }
    }
}
?>