<?php
include 'config.php'; // Include session settings
session_start();      // Start the session

include 'header.php';

// Get the user ID from the URL or default to the logged-in user
$user_id = isset($_GET['user_id']) && is_numeric($_GET['user_id']) ? (int)$_GET['user_id'] : $_SESSION['user_id'];

// Check if the logged-in user is viewing their own collections
$is_owner = ($user_id === $_SESSION['user_id']);

// Fetch the user's name
$user_query = $conn->prepare("SELECT CONCAT(first_name, ' ', last_name) AS full_name FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user_name = $user_result->fetch_assoc()['full_name'] ?? 'Unknown User';

// Pagination setup
$collections_per_page = 6; // Number of collections per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $collections_per_page;

// Fetch total number of collections for the user
$total_collections_query = $conn->prepare("SELECT COUNT(*) AS total_collections FROM saved_places WHERE user_id = ?");
$total_collections_query->bind_param("i", $user_id);
$total_collections_query->execute();
$total_collections_result = $total_collections_query->get_result();
$total_collections = $total_collections_result->fetch_assoc()['total_collections'];

// Calculate total pages
$total_pages = ceil($total_collections / $collections_per_page);

// Fetch collections for the current page
$collections_query = $conn->prepare("
    SELECT 
        sp.place_id, 
        p.name, 
        p.price, 
        p.tags, 
        p.city, 
        p.featured_image, 
        c.id AS category_id, 
        c.icon AS category_icon, 
        COALESCE(AVG(r.rating), 0) AS avg_rating
    FROM saved_places sp
    INNER JOIN places p ON sp.place_id = p.id
    LEFT JOIN reviews r ON p.id = r.place_id
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE sp.user_id = ?
    GROUP BY sp.place_id
    ORDER BY sp.created_at DESC
    LIMIT ? OFFSET ?
");
$collections_query->bind_param("iii", $user_id, $collections_per_page, $offset);
$collections_query->execute();
$collections_result = $collections_query->get_result();
?>

<main class="my_places">
    <div class="pageinfo">
        <div class="pageinfo_content">
            <h2><?php echo $is_owner ? 'MY COLLECTIONS' : htmlspecialchars($user_name) . "'s COLLECTIONS"; ?></h2>
        </div>
    </div>
    <div class="listing_grid">
        <?php while ($collection = $collections_result->fetch_assoc()): ?>
        <div class="listing_grid--item">
            <div class="listing_grid--item-img">
                <a href="place.php?id=<?php echo $collection['place_id']; ?>" class="listing_grid--item-img_img">
                    <img src="<?php echo htmlspecialchars($collection['featured_image'] ?? 'assets/images/listing.jpg'); ?>" alt="Place Image">
                </a>
                <a href="listing.php?category_id=<?php echo urlencode($collection['category_id']); ?>" class="listing_grid--item-img_category">
                    <i class="<?php echo htmlspecialchars($collection['category_icon'] ?? 'fa-solid fa-question'); ?>"></i>
                </a>
                <a href="#" class="listing_grid--item-img_save"><i class="fa-solid fa-bookmark"></i></a>
            </div>
            <div class="listing_grid--item-content">
                <div class="listing_grid--item-content_tages">
                    <?php
                    $tags = explode(',', $collection['tags']);
                    foreach ($tags as $tag):
                    ?>
                    <a href="#"><?php echo htmlspecialchars($tag); ?></a>
                    <?php endforeach; ?>
                </div>
                <a class="listing_grid--item-content_name" href="place.php?id=<?php echo $collection['place_id']; ?>">
                    <?php echo htmlspecialchars($collection['name']); ?>
                </a>
                <a href="#" class="listing_grid--item-content_location">
                    <i class="fa-solid fa-location-dot"></i>
                    <?php echo htmlspecialchars($collection['city']); ?>
                </a>
                <div class="listing_grid--item-content_stars">
                <?php
                                // Fetch average rating from reviews for a specific place
                                $sql = "SELECT AVG(rating) AS avg_rating FROM reviews WHERE place_id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $place['id']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $rating = $result->fetch_assoc()['avg_rating'] ?? 0;
                                $stmt->close();
                                $percentage = ($rating / 5) * 100; // Convert rating to percentage
                                ?>

                                <div class="listing_grid--item-content_stars-stars" style="background: linear-gradient(90deg, #A21111 var(--rating, <?php echo $percentage; ?>%), #D0D0D0 var(--rating,<?php echo $percentage-100; ?>%)); display: inline-block; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                                    <i class="fa-solid fa-star star-rating"></i>
                                </div>
                    <h4 class="listing_grid--item-content_stars-price"><?php echo htmlspecialchars($collection['price']); ?></h4>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- Pagination -->
    <div class="listing_indicator">
        <ul class="listing_indicator">
            <?php if ($page > 1): ?>
            <li class="indicator_item">
                <a href="my_collections.php?user_id=<?php echo $user_id; ?>&page=<?php echo $page - 1; ?>">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="indicator_item <?php echo ($i === $page) ? 'active' : ''; ?>">
                <a href="my_collections.php?user_id=<?php echo $user_id; ?>&page=<?php echo $i; ?>">
                    <?php echo $i; ?>
                </a>
            </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
            <li class="indicator_item">
                <a href="my_collections.php?user_id=<?php echo $user_id; ?>&page=<?php echo $page + 1; ?>">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</main>

<?php include 'footer.php'; ?>