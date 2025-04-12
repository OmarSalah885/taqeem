<?php
include 'config.php'; // Include session settings
session_start();      // Start the session

include 'header.php';

// Get the user ID from the URL or default to the logged-in user
$user_id = isset($_GET['user_id']) && is_numeric($_GET['user_id']) ? (int)$_GET['user_id'] : $_SESSION['user_id'];

// Pagination setup
$reviews_per_page = 6; // Number of reviews per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $reviews_per_page;

// Fetch total number of liked reviews for the user
$total_liked_reviews_query = $conn->prepare("SELECT COUNT(*) AS total_liked_reviews FROM review_likes WHERE user_id = ?");
$total_liked_reviews_query->bind_param("i", $user_id);
$total_liked_reviews_query->execute();
$total_liked_reviews_result = $total_liked_reviews_query->get_result();
$total_liked_reviews = $total_liked_reviews_result->fetch_assoc()['total_liked_reviews'];

// Calculate total pages
$total_pages = ceil($total_liked_reviews / $reviews_per_page);

// Fetch liked reviews for the current page
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
    LIMIT ? OFFSET ?
");
$liked_reviews_query->bind_param("iii", $user_id, $reviews_per_page, $offset);
$liked_reviews_query->execute();
$liked_reviews_result = $liked_reviews_query->get_result();
?>

<main class="my_rev">
    <div class="pageinfo">
        <div class="pageinfo_content">
            <h2>LIKED REVIEWS</h2>
        </div>
    </div>
    <div class="listing_grid">
        <?php while ($liked_review = $liked_reviews_result->fetch_assoc()): ?>
        <div class="activity_grid--item">
            <div class="activity_grid--item_img">
                <a class="activity_grid--item_img_user" href="profile.php?user_id=<?php echo $liked_review['user_id']; ?>">
                    <img src="<?php echo htmlspecialchars($liked_review['profile_image'] ?? 'assets/images/profiles/pro_null.png'); ?>" alt="User Image">
                    <p><?php echo htmlspecialchars($liked_review['first_name'] . ' ' . $liked_review['last_name']); ?></p>
                </a>
                <a href="place.php?id=<?php echo $liked_review['place_id']; ?>">
                    <img class="activity_grid--item_img_user-img" src="<?php echo htmlspecialchars($liked_review['place_image'] ?? 'assets/images/listing.jpg'); ?>" alt="Place Image">
                </a>
                <a class="activity_grid--item_img_like" href="#"><i class="fa-solid fa-heart"></i></a>
            </div>
            <div class="activity_grid--item_content">
                <div class="activity_grid--item_content-info">
                    <div class="activity_grid--item_content-info_name">
                        <a href="place.php?id=<?php echo $liked_review['place_id']; ?>">
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
                    <a class="activity_grid--item_content-info_link" href="listing.php?category_id=<?php echo urlencode($liked_review['category_id']); ?>">
                        <i class="<?php echo htmlspecialchars($liked_review['category_icon'] ?? 'fa-solid fa-question'); ?>"></i>
                    </a>
                </div>
                <p>
                    <?php echo htmlspecialchars(substr($liked_review['review_text'], 0, 150)); ?>
                    <?php if (strlen($liked_review['review_text']) > 150): ?>
                        <a href="review_details.php?id=<?php echo $liked_review['review_id']; ?>" class="read-more">Read more</a>
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
                <a href="liked_rev.php?user_id=<?php echo $user_id; ?>&page=<?php echo $page - 1; ?>">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="indicator_item <?php echo ($i === $page) ? 'active' : ''; ?>">
                <a href="liked_rev.php?user_id=<?php echo $user_id; ?>&page=<?php echo $i; ?>">
                    <?php echo $i; ?>
                </a>
            </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
            <li class="indicator_item">
                <a href="liked_rev.php?user_id=<?php echo $user_id; ?>&page=<?php echo $page + 1; ?>">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</main>

<?php include 'footer.php'; ?>