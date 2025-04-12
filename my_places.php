<?php
include 'config.php'; // Include session settings
session_start();      // Start the session

include 'header.php';

// Get the user ID from the URL or default to the logged-in user
$user_id = isset($_GET['user_id']) && is_numeric($_GET['user_id']) ? (int)$_GET['user_id'] : $_SESSION['user_id'];

// Check if the logged-in user is viewing their own places
$is_owner = ($user_id === $_SESSION['user_id']);

// Fetch the user's name
$user_query = $conn->prepare("SELECT CONCAT(first_name, ' ', last_name) AS full_name FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user_name = $user_result->fetch_assoc()['full_name'] ?? 'Unknown User';

// Pagination setup
$places_per_page = 6; // Number of places per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $places_per_page;

// Fetch total number of places for the user
$total_places_query = $conn->prepare("SELECT COUNT(*) AS total_places FROM places WHERE user_id = ?");
$total_places_query->bind_param("i", $user_id);
$total_places_query->execute();
$total_places_result = $total_places_query->get_result();
$total_places = $total_places_result->fetch_assoc()['total_places'];

// Calculate total pages
$total_pages = ceil($total_places / $places_per_page);

// Fetch places for the current page
$places_query = $conn->prepare("
    SELECT 
        p.id, p.name, p.price, p.tags, p.city, p.featured_image, 
        c.id AS category_id, 
        c.icon AS category_icon, 
        COALESCE(AVG(r.rating), 0) AS avg_rating
    FROM places p
    LEFT JOIN reviews r ON p.id = r.place_id
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.user_id = ?
    GROUP BY p.id
    ORDER BY p.created_at DESC
    LIMIT ? OFFSET ?
");
$places_query->bind_param("iii", $user_id, $places_per_page, $offset);
$places_query->execute();
$places_result = $places_query->get_result();
?>

<main class="my_places">
    <div class="pageinfo">
        <div class="pageinfo_content">
            <h2><?php echo $is_owner ? 'MY PLACES' : htmlspecialchars($user_name) . "'s PLACES"; ?></h2>
        </div>
    </div>
    <div class="listing_grid">
        <?php while ($place = $places_result->fetch_assoc()): ?>
        <div class="listing_grid--item">
            <div class="listing_grid--item-img">
                <a href="place.php?id=<?php echo $place['id']; ?>" class="listing_grid--item-img_img">
                    <img src="<?php echo htmlspecialchars($place['featured_image'] ?? 'assets/images/listing.jpg'); ?>" alt="Place Image">
                </a>
                <a href="listing.php?category_id=<?php echo urlencode($place['category_id']); ?>" class="listing_grid--item-img_category">
                    <i class="<?php echo htmlspecialchars($place['category_icon'] ?? 'fa-solid fa-question'); ?>"></i>
                </a>
                <?php if ($is_owner): ?>
                <a href="edit_place.php?place_id=<?php echo $place['id']; ?>" class="edit_place--btn">EDIT PLACE</a>
                <?php endif; ?>
            </div>
            <div class="listing_grid--item-content">
                <div class="listing_grid--item-content_tages">
                    <?php
                    $tags = explode(',', $place['tags']);
                    foreach ($tags as $tag):
                    ?>
                    <a href="#"><?php echo htmlspecialchars($tag); ?></a>
                    <?php endforeach; ?>
                </div>
                <a class="listing_grid--item-content_name" href="place.php?id=<?php echo $place['id']; ?>">
                    <?php echo htmlspecialchars($place['name']); ?>
                </a>
                <a href="#" class="listing_grid--item-content_location">
                    <i class="fa-solid fa-location-dot"></i>
                    <?php echo htmlspecialchars($place['city']); ?>
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
                    <h4 class="listing_grid--item-content_stars-price"><?php echo htmlspecialchars($place['price']); ?></h4>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <!-- Pagination -->
    <div class="listing_indicator">
        <ul class="listing_indicator">
            <?php if ($page > 1): ?>
            <li class="indicator_item">
                <a href="my_places.php?user_id=<?php echo $user_id; ?>&page=<?php echo $page - 1; ?>">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="indicator_item <?php echo ($i === $page) ? 'active' : ''; ?>">
                <a href="my_places.php?user_id=<?php echo $user_id; ?>&page=<?php echo $i; ?>">
                    <?php echo $i; ?>
                </a>
            </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
            <li class="indicator_item">
                <a href="my_places.php?user_id=<?php echo $user_id; ?>&page=<?php echo $page + 1; ?>">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    </div>

    
</main>

<?php include 'footer.php'; ?>