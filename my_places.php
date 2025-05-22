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
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : (int)$_SESSION['user_id'];
$is_owner = ($user_id === (int)$_SESSION['user_id']);
$is_admin = isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'admin';

// Fetch user details
$user_query = $conn->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();
$user_query->close();

if (!$user) {
    echo "<p>User not found.</p>";
    exit;
}

// Pagination
$items_per_page = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Fetch total places
$total_query = $conn->prepare("SELECT COUNT(*) AS total FROM places WHERE user_id = ?");
$total_query->bind_param("i", $user_id);
$total_query->execute();
$total_result = $total_query->get_result();
$total_places = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_places / $items_per_page);
$total_query->close();

// Fetch places
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
    LIMIT ?, ?
");
$places_query->bind_param("iii", $user_id, $offset, $items_per_page);
$places_query->execute();
$places_result = $places_query->get_result();

$places = [];
while ($row = $places_result->fetch_assoc()) {
    $places[] = $row;
}
$places_query->close();

// Fetch saved places
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

<main>
    <div class="places_likes">
        <div class="pageinfo">
            <div class="pageinfo_content">
                <h2><?php echo $is_owner ? 'My Places' : htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) . '\'s Places'; ?>
                </h2>
            </div>
        </div>
        <div class="places_likes_content">
            <div class="listing_grid">
                <?php if (!empty($places)): ?>
                <?php foreach ($places as $place): ?>
                <div class="listing_grid--item">
                    <div class="listing_grid--item-img">
                        <a href="single-place.php?place_id=<?php echo $place['id']; ?>"
                            class="listing_grid--item-img_img">
                            <img src="<?php echo htmlspecialchars($place['featured_image'] ?? 'assets/images/listing.jpg'); ?>"
                                alt="<?php echo htmlspecialchars($place['name']); ?>">
                        </a>
                        <a href="listing.php?category_id=<?php echo urlencode($place['category_id']); ?>"
                            class="listing_grid--item-img_category">
                            <i
                                class="<?php echo htmlspecialchars($place['category_icon'] ?? 'fa-solid fa-question'); ?>"></i>
                        </a>
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
                                href="listing.php?search=<?php echo urlencode(trim($tag)); ?>"><?php echo htmlspecialchars(trim($tag)); ?></a>
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
                                    style="background: linear-gradient(90deg, #A21111 var(--rating, <?php echo $percentage; ?>%), #D0D0D0 var(--rating,<?php echo $percentage - 100; ?>%)); display: inline-block; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
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
                <?php endforeach; ?>
                <?php else: ?>
                <p>No places found.</p>
                <?php endif; ?>
            </div>
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
                    <?php
                $range = 2;
                $start = max(1, $page - $range);
                $end = min($total_pages, $page + $range);
                ?>
                    <?php if ($start > 1): ?>
                    <li class="indicator_item">
                        <a href="my_places.php?user_id=<?php echo $user_id; ?>&page=1">1</a>
                    </li>
                    <?php if ($start > 2): ?>
                    <li class="indicator_item ellipsis">
                        <a href="my_places.php?user_id=<?php echo $user_id; ?>&page=<?php echo $start - 1; ?>">…</a>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php for ($i = $start; $i <= $end; $i++): ?>
                    <li class="indicator_item <?php echo ($i === $page) ? 'active' : ''; ?>">
                        <a href="my_places.php?user_id=<?php echo $user_id; ?>&page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                    <?php if ($end < $total_pages): ?>
                    <?php if ($end < $total_pages - 1): ?>
                    <li class="indicator_item ellipsis">
                        <a href="my_places.php?user_id=<?php echo $user_id; ?>&page=<?php echo $end + 1; ?>">…</a>
                    </li>
                    <?php endif; ?>
                    <li class="indicator_item">
                        <a href="my_places.php?user_id=<?php echo $user_id; ?>&page=<?php echo $total_pages; ?>">
                            <?php echo $total_pages; ?>
                        </a>
                    </li>
                    <?php endif; ?>
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


    </div>
</main>

<?php include 'footer.php'; ?>