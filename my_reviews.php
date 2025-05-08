<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

include 'header.php';

// Get the user ID from the URL or default to the logged-in user
$user_id = isset($_GET['user_id']) && is_numeric($_GET['user_id']) ? (int)$_GET['user_id'] : $_SESSION['user_id'];

// Check if the logged-in user is viewing their own reviews
$is_owner = ($user_id === $_SESSION['user_id']);

// Fetch the user's name
$user_query = $conn->prepare("SELECT CONCAT(first_name, ' ', last_name) AS full_name, profile_image FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user_data = $user_result->fetch_assoc();
$user_name = $user_data['full_name'] ?? 'Unknown User';
$profile_image = $user_data['profile_image'] ?? 'assets/images/profiles/pro_null.png';

// Pagination setup
$reviews_per_page = 6; // Number of reviews per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $reviews_per_page;

// Fetch total number of reviews for the user
$total_reviews_query = $conn->prepare("SELECT COUNT(*) AS total_reviews FROM reviews WHERE user_id = ?");
$total_reviews_query->bind_param("i", $user_id);
$total_reviews_query->execute();
$total_reviews_result = $total_reviews_query->get_result();
$total_reviews = $total_reviews_result->fetch_assoc()['total_reviews'];

// Calculate total pages
$total_pages = ceil($total_reviews / $reviews_per_page);

// Fetch reviews for the current page
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
    LIMIT ? OFFSET ?
");
$reviews_query->bind_param("iii", $user_id, $reviews_per_page, $offset);
$reviews_query->execute();
$reviews_result = $reviews_query->get_result();

$is_liked_reviews = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $liked_reviews_query = $conn->prepare("SELECT review_id FROM review_likes WHERE user_id = ?");
    $liked_reviews_query->bind_param("i", $user_id);
    $liked_reviews_query->execute();
    $liked_reviews_result = $liked_reviews_query->get_result();
    while ($liked_review = $liked_reviews_result->fetch_assoc()) {
        $is_liked_reviews[] = $liked_review['review_id'];
    }
}
?>

<main class="my_rev">
    <div class="pageinfo">
        <div class="pageinfo_content">
            <h2><?php echo $is_owner ? 'MY REVIEWS' : htmlspecialchars($user_name) . "'s REVIEWS"; ?></h2>
        </div>
    </div>

    <div class="places_likes_content">
        <div class="listing_grid">
            <?php while ($review = $reviews_result->fetch_assoc()): ?>
            <div class="activity_grid--item">
                <div class="activity_grid--item_img">
                    <a class="activity_grid--item_img_user"
                        href="profile.php?user_id=<?php echo $review['user_id']; ?>">
                        <img src="<?php echo htmlspecialchars($review['profile_image'] ?? 'assets/images/profiles/pro_null.png'); ?>"
                            alt="User Image">
                        <p><?php echo htmlspecialchars($review['first_name'] . ' ' . $review['last_name']); ?></p>
                    </a>
                    <a href="single-place.php?place_id=<?php echo $review['place_id']; ?>#review_<?php echo $review['review_id']; ?>">
                        <img class="activity_grid--item_img_user-img"
                            src="<?php echo htmlspecialchars($review['place_image'] ?? 'assets/images/listing.jpg'); ?>"
                            alt="Place Image">
                    </a>
                    <!-- Like Icon -->
                    <?php
                    // Check if the logged-in user has already liked this review
                    if ($is_owner) {
                        $is_liked = in_array($review['review_id'], $is_liked_reviews);
                    } else {
                        $is_liked = false; // Always unliked for other users' reviews
                    }
                    ?>
                    <a class="activity_grid--item_img_like" href="#" onclick="toggleLike(event, <?php echo $review['review_id']; ?>)">
                        <i class="<?php echo $is_liked ? 'fa-solid fa-heart' : 'fa-regular fa-heart'; ?>"></i>
                    </a>
                </div>
                <div class="activity_grid--item_content">
                    <div class="activity_grid--item_content-info">
                        <div class="activity_grid--item_content-info_name">
                            <a href="single-place.php?place_id=<?php echo $review['place_id']; ?>">
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
                        <a class="activity_grid--item_content-info_link"
                            href="listing.php?category_id=<?php echo urlencode($review['category_id']); ?>">
                            <i
                                class="<?php echo htmlspecialchars($review['category_icon'] ?? 'fa-solid fa-question'); ?>"></i>
                        </a>
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

        <!-- Pagination -->
        <div class="listing_indicator">
            <ul class="listing_indicator">
                <?php if ($page > 1): ?>
                <li class="indicator_item">
                    <a href="my_reviews.php?user_id=<?php echo $user_id; ?>&page=<?php echo $page - 1; ?>">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="indicator_item <?php echo ($i === $page) ? 'active' : ''; ?>">
                    <a href="my_reviews.php?user_id=<?php echo $user_id; ?>&page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                <li class="indicator_item">
                    <a href="my_reviews.php?user_id=<?php echo $user_id; ?>&page=<?php echo $page + 1; ?>">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>