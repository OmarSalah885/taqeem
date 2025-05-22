<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

function format_count($number) {
    if ($number >= 1000000) {
        return round($number / 1000000, 1) . 'M';
    } elseif ($number >= 1000) {
        return round($number / 1000, 1) . 'k';
    }
    return (string)$number;
}

// Get the profile user ID from the query string
$profile_user_id   = isset($_GET['user_id'])   ? (int)$_GET['user_id']   : 0;

// Get the logged-in user ID and role
$logged_in_user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$user_role         = isset($_SESSION['role'])    ? $_SESSION['role']        : '';

// Determine roles
$is_owner = ($profile_user_id === $logged_in_user_id);
$is_admin = !empty($user_role) && strtolower($user_role) === 'admin';

// Fetch profile user data
$user_query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$user_query->bind_param("i", $profile_user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    echo "<p>User not found.</p>";
    exit;
}
$is_private = ($user['visibility'] === 'private' && !$is_owner && !$is_admin);

// Check if the logged-in user is the sole admin
$show_delete_button = true;
if ($is_admin) {
    $admin_count_query = $conn->prepare("SELECT COUNT(*) FROM users WHERE LOWER(role) = 'admin'");
    $admin_count_query->execute();
    $admin_count_query->bind_result($admin_count);
    $admin_count_query->fetch();
    $admin_count_query->close();
    $show_delete_button = $admin_count > 1;
}

// Handle image upload if it's the owner's profile or the admin is editing
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_FILES['profile_image'])
    && ($is_owner || $is_admin)
) {
    $image        = $_FILES['profile_image'];
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    $maxSize      = 2 * 1024 * 1024; // 2MB

    if ($image['error'] === UPLOAD_ERR_OK) {
        $fileType = mime_content_type($image['tmp_name']);
        $fileSize = $image['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            $ext        = pathinfo($image['name'], PATHINFO_EXTENSION);
            $imageName  = uniqid() . '.' . $ext;
            $targetDir  = 'assets/images/profiles/';
            $targetFile = $targetDir . $imageName;

            if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                // Delete old image if it's not the default placeholder
                $oldImage = $user['profile_image'] ?? '';
                if ($oldImage
                    && $oldImage !== 'assets/images/profiles/pro_null.png'
                    && file_exists($oldImage)
                ) {
                    unlink($oldImage);
                }

                // Update DB and session (only update session if it's the owner's profile)
                $stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
                $stmt->bind_param("si", $targetFile, $user['id']);
                $stmt->execute();
                $stmt->close();

                if ($is_owner) {
                    $_SESSION['profile_image'] = $targetFile;
                }

                header("Location: " . $_SERVER['REQUEST_URI']);
                exit;
            } else {
                $error = 'Failed to upload image.';
            }
        } else {
            $error = 'Invalid file type or size too big. Only JPG, JPEG, PNG under 2MB allowed.';
        }
    } else {
        $error = 'Image upload error.';
    }
}

// Helper function to format numbers (e.g., 1500 -> "1.5K", 1500000 -> "1.5M")
function formatNumber($number) {
    if ($number >= 1000000) {
        return number_format($number / 1000000, 1) . 'M';
    } elseif ($number >= 1000) {
        return number_format($number / 1000, 1) . 'K';
    }
    return (string)$number;
}

// Fetch counts for Admin Dashboard
function fetchCount($conn, $table) {
    $count = 0;
    if ($stmt = $conn->prepare("SELECT COUNT(*) FROM $table")) {
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
    }
    return $count;
}
$userCount   = fetchCount($conn, 'users');
$placeCount  = fetchCount($conn, 'places');
$reviewCount = fetchCount($conn, 'reviews');
$blogCount   = fetchCount($conn, 'blogs');

// Fetch saved places for the logged-in user
$saved_places = [];
if (isset($_SESSION['user_id'])) {
    $saved_query = $conn->prepare("SELECT place_id FROM saved_places WHERE user_id = ?");
    $saved_query->bind_param("i", $_SESSION['user_id']);
    $saved_query->execute();
    $saved_result = $saved_query->get_result();
    while ($saved = $saved_result->fetch_assoc()) {
        $saved_places[] = $saved['place_id'];
    }
    $saved_query->close();
}

include 'header.php';
?>

<main class="profile">
    <?php if ($error): ?>
    <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="profile_sidebar">
        <!-- User Image -->
        <div class="profile_sidebar--img" style="cursor: pointer;"
            onclick="document.getElementById('profileInput').click();">
            <img src="<?php echo htmlspecialchars($user['profile_image'] ?? 'assets/images/profiles/pro_null.png'); ?>?v=<?php echo time(); ?>"
                alt="User Profile">
        </div>

        <!-- Hidden Upload Form -->
        <?php if ($is_owner || $is_admin): ?>
        <form id="uploadForm" method="POST" enctype="multipart/form-data" style="display: none;">
            <input type="file" name="profile_image" id="profileInput" accept="image/jpeg,image/jpg,image/png">
        </form>
        <?php endif; ?>

        <!-- User Info -->
        <div class="profile_sidebar--info">
            <h3 class="name"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h3>

            <?php if (!$is_private): ?>
            <!-- Show email only if the profile is not private -->
            <a
                href="mailto:<?php echo htmlspecialchars($user['email']); ?>"><?php echo htmlspecialchars($user['email']); ?></a>
            <?php endif; ?>

            <?php if (!$is_private): ?>
            <!-- Show location only if the profile is not private -->
            <h2 class="location"><?php echo htmlspecialchars($user['location'] ?? 'Unknown Location'); ?></h2>
            <?php endif; ?>
        </div>

        <!-- Edit Buttons (Only for Profile Owner or Admin) -->
        <?php if ($is_owner || $is_admin): ?>
        <div class="profile_sidebar--edit">
            <a class="profile_sidebar--edit-btn"
                href="edit-profile.php<?= $is_admin && !$is_owner ? '?user_id=' . $user['id'] : '' ?>">
                <i class="fa-solid fa-pen"></i>Edit profile
            </a>
            <label for="profileInput" class="profile_sidebar--edit-btn" style="cursor:pointer;">
                <i class="fa-solid fa-user"></i>Add photo
            </label>
        </div>
        <?php if ($show_delete_button): ?>
        <a href="delete_account.php" class="btn__transparent--l btn__transparent btn"
            onclick="return confirm('Are you SURE you want to delete your account? This cannot be undone.');">DELETE
            ACCOUNT</a>
        <?php endif; ?>
        <a href="logout.php" class="btn__transparent--l btn__transparent btn">LOGOUT</a>
        <?php endif; ?>
    </div>

    <!-- Show Profile Sections -->
    <div class="profile_main">
        <?php if (
            isset($_SESSION['role'], $_SESSION['user_id']) &&
            strtolower(trim($_SESSION['role'])) === 'admin' &&
            $profile_user_id === $logged_in_user_id
        ): ?>
        <!-- Admin Dashboard Section -->
        <div class="profile_main_collection">
            <h2 class="profile_title">Admin Dashboard</h2>
            <div class="admin_container">
                <div class="admin_card admin_users">
                    <h1><span><?php echo formatNumber($userCount); ?></span> USERS</h1>
                    <a href="admin_users.php">View all users</a>
                </div>
                <div class="admin_card admin_places">
                    <h1><span><?php echo formatNumber($placeCount); ?></span> PLACES</h1>
                    <a href="admin_places.php">View all places</a>
                </div>
                <div class="admin_card admin_reviews">
                    <h1><span><?php echo formatNumber($reviewCount); ?></span> REVIEWS</h1>
                    <a href="admin_reviews.php">View all reviews</a>
                </div>
                <div class="admin_card admin_blogs">
                    <h1><span><?php echo formatNumber($blogCount); ?></span> BLOGS</h1>
                    <a href="admin_blogs.php">View all blogs</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($is_private): ?>
        <!-- Show "Profile is Private" Message -->
        <div class="profile_private_message">
            <h2>This profile is private.</h2>
        </div>
        <?php else: ?>
        <?php
        // Fetch counts for sections
        $total_places_query = $conn->prepare("SELECT COUNT(*) AS total_places FROM places WHERE user_id = ?");
        $total_places_query->bind_param("i", $profile_user_id);
        $total_places_query->execute();
        $total_places_result = $total_places_query->get_result();
        $total_places = $total_places_result->fetch_assoc()['total_places'] ?? 0;
        $total_places_query->close();

        $total_reviews_query = $conn->prepare("SELECT COUNT(*) AS total_reviews FROM reviews WHERE user_id = ?");
        $total_reviews_query->bind_param("i", $profile_user_id);
        $total_reviews_query->execute();
        $total_reviews_result = $total_reviews_query->get_result();
        $total_reviews = $total_reviews_result->fetch_assoc()['total_reviews'] ?? 0;
        $total_reviews_query->close();

        $total_liked_reviews_query = $conn->prepare("SELECT COUNT(*) AS total_liked_reviews FROM review_likes WHERE user_id = ?");
        $total_liked_reviews_query->bind_param("i", $profile_user_id);
        $total_liked_reviews_query->execute();
        $total_liked_reviews_result = $total_liked_reviews_query->get_result();
        $total_liked_reviews = $total_liked_reviews_result->fetch_assoc()['total_liked_reviews'] ?? 0;
        $total_liked_reviews_query->close();

        $total_saved_places_query = $conn->prepare("SELECT COUNT(*) AS total_saved_places FROM saved_places WHERE user_id = ?");
        $total_saved_places_query->bind_param("i", $profile_user_id);
        $total_saved_places_query->execute();
        $total_saved_places_result = $total_saved_places_query->get_result();
        $total_saved_places = $total_saved_places_result->fetch_assoc()['total_saved_places'] ?? 0;
        $total_saved_places_query->close();
        ?>
        <!-- MY PLACES Section -->
        <?php if ($total_places > 0): ?>
        <div class="profile_main_collection">
            <h2 class="profile_title">MY PLACES</h2>
            <div class="profile_container">
                <?php
                // Fetch the newest 2 places
                    $places_query = $conn->prepare("
                        SELECT
                            p.id,
                            p.name,
                            p.price,
                            p.tags,
                            p.city,
                            p.address,
                            p.featured_image,
                            p.google_map_location,
                            c.id AS category_id,
                            c.icon AS category_icon,
                            COALESCE(AVG(r.rating), 0) AS avg_rating,
                            COUNT(r.id) AS total_reviews
                        FROM places p
                        LEFT JOIN reviews r ON p.id = r.place_id
                        LEFT JOIN categories c ON p.category_id = c.id
                        WHERE p.user_id = ?
                        GROUP BY p.id
                        ORDER BY p.created_at DESC
                        LIMIT 2
                ");
                $places_query->bind_param("i", $profile_user_id);
                $places_query->execute();
                $places_result = $places_query->get_result();

                while ($place = $places_result->fetch_assoc()): ?>
                <div class="listing_grid--item">
                    <div class="listing_grid--item-img">
                        <a href="single-place.php?place_id=<?php echo $place['id']; ?>"
                            class="listing_grid--item-img_img">
                            <img src="<?php echo htmlspecialchars($place['featured_image'] ?? 'assets/images/listing.jpg'); ?>"
                                alt="Place Image">
                        </a>
                        <a href="listing.php?category_id=<?php echo urlencode($place['category_id']); ?>"
                            class="listing_grid--item-img_category">
                            <i
                                class="<?php echo htmlspecialchars($place['category_icon'] ?? 'fa-solid fa-question'); ?>"></i>
                        </a>
                        <!-- Save Icon -->
                        <a href="#" class="listing_grid--item-img_save"
                            onclick="toggleSave(event, <?php echo $place['id']; ?>)">
                            <i
                                class="<?php echo in_array($place['id'], $saved_places) ? 'fa-solid fa-bookmark' : 'fa-regular fa-bookmark'; ?>"></i>
                        </a>
                        <?php if ($is_owner || $is_admin): ?>
                        <a href="edit_place.php?place_id=<?php echo $place['id']; ?>" class="edit_place--btn">EDIT
                            PLACE</a>
                        <?php endif; ?>
                    </div>
                    <div class="listing_grid--item-content">
                        <div class="listing_grid--item-content_tages">
                            <?php
                            $tags = explode(',', $place['tags']);
                            foreach ($tags as $tag):
                            ?>
                            <a
                                href="listing.php?search=<?php echo urlencode(trim($tag)); ?>"><?php echo htmlspecialchars($tag); ?></a>
                            <?php endforeach; ?>
                        </div>
                        <a class="listing_grid--item-content_name"
                            href="single-place.php?place_id=<?php echo $place['id']; ?>">
                            <?php echo htmlspecialchars($place['name']); ?>
                        </a>
                        <a href="<?php echo htmlspecialchars($place['google_map_location']); ?>"
                            class="listing_grid--item-content_location" target="_blank">
                            <i class="fa-solid fa-location-dot"></i>
                            <?php echo htmlspecialchars($place['address'] ?: $place['city']); ?>
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <?php
                            $rating = $place['avg_rating'];
                            $percentage = ($rating / 5) * 100;
                            ?>
                            <div>
                                <div class="listing_grid--item-content_stars-stars"
                                    style="background: linear-gradient(90deg, #A21111 var(--rating, <?php echo $percentage; ?>%), #D0D0D0 var(--rating,<?php echo $percentage-100; ?>%)); display: inline-block; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                                </div>
                                <span class="rating-number">
                                    <?php 
                                        echo number_format($place['avg_rating'], 1); 
                                        $review_count = (int)$place['total_reviews'];
                                        echo ' (' . format_count($review_count) . ' ' . ($review_count === 1 ? 'review' : 'reviews') . ')';
                                    ?>
                                </span>
                            </div>
                            <h4 class="listing_grid--item-content_stars-price">
                                <?php echo htmlspecialchars($place['price']); ?></h4>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php if ($total_places > 2): ?>
            <a href="my_places.php?user_id=<?php echo $profile_user_id; ?>&page=1" class="btn__red--l btn__red btn">see
                all</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- MY REVIEWS Section -->
        <?php if ($total_reviews > 0): ?>
        <div class="profile_main_myReviews">
            <h2 class="profile_title">MY REVIEWS</h2>
            <div class="profile_container">
                <?php
                $reviews_query = $conn->prepare("
                    SELECT
                        r.id AS review_id,
                        r.review_text,
                        r.rating,
                        r.created_at,
                        p.id AS place_id,
                        p.name AS place_name,
                        p.featured_image AS place_image,
                        c.id AS category_id,
                        c.icon AS category_icon,
                        u.id AS user_id,
                        u.first_name,
                        u.last_name,
                        u.profile_image
                    FROM reviews r
                    INNER JOIN places p ON r.place_id = p.id
                    LEFT JOIN categories c ON p.category_id = c.id
                    INNER JOIN users u ON r.user_id = u.id
                    WHERE r.user_id = ?
                    ORDER BY r.created_at DESC
                    LIMIT 2
                ");
                $reviews_query->bind_param("i", $profile_user_id);
                $reviews_query->execute();
                $reviews_result = $reviews_query->get_result();

                while ($review = $reviews_result->fetch_assoc()):
                ?>
                <div class="activity_grid--item">
                    <div class="activity_grid--item_img">
                        <a class="activity_grid--item_img_user"
                            href="profile.php?user_id=<?php echo $review['user_id']; ?>">
                            <img src="<?php echo htmlspecialchars($review['profile_image'] ?? 'assets/images/profiles/pro_null.png'); ?>"
                                alt="User Image">
                            <p><?php echo htmlspecialchars($review['first_name'] . ' ' . $review['last_name']); ?></p>
                        </a>
                        <a
                            href="single-place.php?place_id=<?php echo $review['place_id']; ?>#review_<?php echo $review['review_id']; ?>">
                            <img class="activity_grid--item_img_user-img"
                                src="<?php echo htmlspecialchars($review['place_image'] ?? 'assets/images/listing.jpg'); ?>"
                                alt="Place Image">
                        </a>
                        <?php
                        $is_liked = false;
                        if (isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id'];
                            $check_like_query = $conn->prepare("SELECT id FROM review_likes WHERE user_id = ? AND review_id = ?");
                            $check_like_query->bind_param("ii", $user_id, $review['review_id']);
                            $check_like_query->execute();
                            $check_like_result = $check_like_query->get_result();
                            $is_liked = $check_like_result->num_rows > 0;
                        }
                        ?>
                        <a class="activity_grid--item_img_like" href="#"
                            onclick="toggleLike(event, <?php echo $review['review_id']; ?>)">
                            <i class="<?php echo $is_liked ? 'fa-solid fa-heart' : 'fa-regular fa-heart'; ?>"></i>
                        </a>
                    </div>
                    <div class="activity_grid--item_content">
                        <div class="activity_grid--item_content-info">
                            <div class="activity_grid--item_content-info_name">
                                <a href="place.php?id=<?php echo $review['place_id']; ?>">
                                    <h3><?php echo htmlspecialchars($review['place_name']); ?></h3>
                                </a>
                                <div class="activity_stars">
                                    <?php
                                    $rating = (int)$review['rating'];
                                    for ($i = 0; $i < $rating; $i++): ?>
                                    <i class="fa-solid fa-star"></i>
                                    <?php endfor; ?>
                                    <?php for ($i = $rating; $i < 5; $i++): ?>
                                    <i class="fa-regular fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <p>
                            <?php echo htmlspecialchars(substr($review['review_text'], 0, 150)); ?>
                            <?php if (strlen($review['review_text']) > 150): ?>
                            <a href="review_details.php?id=<?php echo $review['review_id']; ?>" class="read-more">Read
                                more</a>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php if ($total_reviews > 2): ?>
            <a href="my_reviews.php?user_id=<?php echo $profile_user_id; ?>&page=1" class="btn__red--l btn__red btn">see
                all</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- LIKED REVIEWS Section -->
        <?php if ($total_liked_reviews > 0): ?>
        <div class="profile_main_likeReviews">
            <h2 class="profile_title">LIKED REVIEWS</h2>
            <div class="profile_container">
                <?php
                $liked_reviews_query = $conn->prepare("
                    SELECT
                        rl.review_id,
                        r.rating,
                        r.review_text,
                        r.created_at,
                        p.id AS place_id,
                        p.name AS place_name,
                        p.featured_image AS place_image,
                        c.id AS category_id,
                        c.icon AS category_icon,
                        u.id AS user_id,
                        u.first_name,
                        u.last_name,
                        u.profile_image
                    FROM review_likes rl
                    INNER JOIN reviews r ON rl.review_id = r.id
                    INNER JOIN places p ON r.place_id = p.id
                    LEFT JOIN categories c ON p.category_id = c.id
                    INNER JOIN users u ON r.user_id = u.id
                    WHERE rl.user_id = ?
                    ORDER BY rl.created_at DESC
                    LIMIT 2
                ");
                $liked_reviews_query->bind_param("i", $profile_user_id);
                $liked_reviews_query->execute();
                $liked_reviews_result = $liked_reviews_query->get_result();

                while ($liked_review = $liked_reviews_result->fetch_assoc()):
                ?>
                <div class="activity_grid--item">
                    <div class="activity_grid--item_img">
                        <a class="activity_grid--item_img_user"
                            href="profile.php?user_id=<?php echo $liked_review['user_id']; ?>">
                            <img src="<?php echo htmlspecialchars($liked_review['profile_image'] ?? 'assets/images/profiles/pro_null.png'); ?>"
                                alt="User Image">
                            <p><?php echo htmlspecialchars($liked_review['first_name'] . ' ' . $liked_review['last_name']); ?>
                            </p>
                        </a>
                        <a
                            href="single-place.php?place_id=<?php echo $liked_review['place_id']; ?>#review_<?php echo $liked_review['review_id']; ?>">
                            <img class="activity_grid--item_img_user-img"
                                src="<?php echo htmlspecialchars($liked_review['place_image'] ?? 'assets/images/listing.jpg'); ?>"
                                alt="Place Image">
                        </a>
                        <?php
                        if ($is_owner) {
                            $is_liked = in_array($liked_review['review_id'], array_column($saved_places, 'review_id')) || in_array($liked_review['review_id'], array_column($saved_places, 'review_id'));
                        } else {
                            $is_liked = false;
                        }
                        ?>
                        <a class="activity_grid--item_img_like" href="#"
                            onclick="toggleLike(event, <?php echo $liked_review['review_id']; ?>)">
                            <i class="<?php echo $is_liked ? 'fa-solid fa-heart' : 'fa-regular fa-heart'; ?>"></i>
                        </a>
                    </div>
                    <div class="activity_grid--item_content">
                        <div class="activity_grid--item_content-info">
                            <div class="activity_grid--item_content-info_name">
                                <a href="place.php?place_id=<?php echo $liked_review['place_id']; ?>">
                                    <h3><?php echo htmlspecialchars($liked_review['place_name']); ?></h3>
                                </a>
                                <div class="activity_stars">
                                    <?php
                                    $rating = (int)$liked_review['rating'];
                                    for ($i = 0; $i < $rating; $i++): ?>
                                    <i class="fa-solid fa-star"></i>
                                    <?php endfor; ?>
                                    <?php for ($i = $rating; $i < 5; $i++): ?>
                                    <i class="fa-regular fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <p>
                            <?php echo htmlspecialchars(substr($liked_review['review_text'], 0, 150)); ?>
                            <?php if (strlen($liked_review['review_text']) > 150): ?>
                            <a href="single-place.php?place_id=<?php echo $liked_review['place_id']; ?>#review_<?php echo $liked_review['review_id']; ?>"
                                class="read-more">Read more</a>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php if ($total_liked_reviews > 2): ?>
                <a href="liked_rev.php?user_id=<?php echo $profile_user_id; ?>&page=1"
                    class="btn__red--l btn__red btn">see all</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- MY COLLECTIONS Section -->
        <?php if ($total_saved_places > 0): ?>
        <div class="profile_main_collection">
            <h2 class="profile_title">MY COLLECTIONS</h2>
            <div class="profile_container">
                <?php
                    $saved_places_query = $conn->prepare("
    SELECT
        sp.place_id,
        p.name,
        p.price,
        p.tags,
        p.city,
        p.address,
        p.featured_image,
        p.google_map_location,
        c.id AS category_id,
        c.icon AS category_icon,
        COALESCE(AVG(r.rating), 0) AS avg_rating,
        COUNT(r.id) AS total_reviews
    FROM saved_places sp
    INNER JOIN places p ON sp.place_id = p.id
    LEFT JOIN reviews r ON p.id = r.place_id
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE sp.user_id = ?
    GROUP BY sp.place_id
    ORDER BY sp.created_at DESC
    LIMIT 2
");
                $saved_places_query->bind_param("i", $profile_user_id);
                $saved_places_query->execute();
                $saved_places_result = $saved_places_query->get_result();

                while ($saved_place = $saved_places_result->fetch_assoc()):
                ?>
                <div class="listing_grid--item">
                    <div class="listing_grid--item-img">
                        <a href="single-place.php?place_id=<?php echo $saved_place['place_id']; ?>"
                            class="listing_grid--item-img_img">
                            <img src="<?php echo htmlspecialchars($saved_place['featured_image'] ?? 'assets/images/listing.jpg'); ?>"
                                alt="Place Image">
                        </a>
                        <a href="listing.php?category_id=<?php echo urlencode($saved_place['category_id']); ?>"
                            class="listing_grid--item-img_category">
                            <i
                                class="<?php echo htmlspecialchars($saved_place['category_icon'] ?? 'fa-solid fa-question'); ?>"></i>
                        </a>
                        <a href="#" class="listing_grid--item-img_save"
                            onclick="toggleSave(event, <?php echo $saved_place['place_id']; ?>)">
                            <i
                                class="<?php echo in_array($saved_place['place_id'], $saved_places) ? 'fa-solid fa-bookmark' : 'fa-regular fa-bookmark'; ?>"></i>
                        </a>
                    </div>
                    <div class="listing_grid--item-content">
                        <div class="listing_grid--item-content_tages">
                            <?php
                            $tags = explode(',', $saved_place['tags']);
                            foreach ($tags as $tag):
                            ?>
                            <a
                                href="listing.php?search=<?php echo urlencode(trim($tag)); ?>"><?php echo htmlspecialchars($tag); ?></a>
                            <?php endforeach; ?>
                        </div>
                        <a class="listing_grid--item-content_name"
                            href="single-place.php?place_id=<?php echo $saved_place['place_id']; ?>">
                            <?php echo htmlspecialchars($saved_place['name']); ?>
                        </a>
                        <a href="<?php echo htmlspecialchars($saved_place['google_map_location']); ?>"
                            class="listing_grid--item-content_location" target="_blank">
                            <i class="fa-solid fa-location-dot"></i>
                            <?php echo htmlspecialchars($saved_place['address'] ?: $saved_place['city']); ?>
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <?php
                            $rating = $saved_place['avg_rating'];
                            $percentage = ($rating / 5) * 100;
                            ?>
                            <div>
                                <div class="listing_grid--item-content_stars-stars"
                                    style="background: linear-gradient(90deg, #A21111 var(--rating, <?php echo $percentage; ?>%), #D0D0D0 var(--rating,<?php echo $percentage-100; ?>%)); display: inline-block; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                                </div>
                                <span class="rating-number">
                                    <?php 
                                        echo number_format($saved_place['avg_rating'], 1); 
                                        $review_count = (int)$saved_place['total_reviews'];
                                        echo ' (' . format_count($review_count) . ' ' . ($review_count === 1 ? 'review' : 'reviews') . ')';
                                    ?>
                                </span>
                            </div>
                            <h4 class="listing_grid--item-content_stars-price">
                                <?php echo htmlspecialchars($saved_place['price']); ?></h4>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php if ($total_saved_places > 2): ?>
            <a href="my_collections.php?user_id=<?php echo $profile_user_id; ?>&page=1"
                class="btn__red--l btn__red btn">see all</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Additional Sections -->
        <div class="profile_main_info">
            <div class="profile_main_info--top">
                <div class="info_top--item">
                    <h3>Name</h3>
                    <p><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
                </div>
                <div class="info_top--item">
                    <h3>Since</h3>
                    <p><?php echo htmlspecialchars(date("F Y", strtotime($user['created_at']))); ?></p>
                </div>
                <div class="info_top--item">
                    <h3>Email</h3>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
                <div class="info_top--item">
                    <h3>Gender</h3>
                    <p><?php echo htmlspecialchars($user['gender'] ?? 'Not Specified'); ?></p>
                </div>
            </div>
            <div class="profile_main_info--bottom">
                <h3>About me</h3>
                <p><?php echo htmlspecialchars($user['about_me'] ?? 'No information provided.'); ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<script>
document.getElementById('profileInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    const maxSize = 2 * 1024 * 1024; // 2MB

    if (!allowedTypes.includes(file.type)) {
        alert('Invalid file type. Only JPG, JPEG, PNG allowed.');
        e.target.value = '';
        return;
    }

    if (file.size > maxSize) {
        alert('File size too big. Maximum 2MB allowed.');
        e.target.value = '';
        return;
    }

    document.getElementById('uploadForm').submit();
});
</script>

<?php include 'footer.php'; ?>