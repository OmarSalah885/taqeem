<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

include 'header.php';

// Get filters & search
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

// Overlay search uses `search_term`, inline uses `search`
if (!empty($_GET['search_term'])) {
    $search = trim($_GET['search_term']);
} elseif (!empty($_GET['search'])) {
    $search = trim($_GET['search']);
} else {
    $search = '';
}

// If exact category name match, retrieve its ID
$search_cat_id = 0;
if ($search !== '') {
    $cat_stmt = $conn->prepare("SELECT id FROM categories WHERE name = ?");
    $cat_stmt->bind_param("s", $search);
    $cat_stmt->execute();
    $cat_res = $cat_stmt->get_result();
    if ($cat_row = $cat_res->fetch_assoc()) {
        $search_cat_id = (int)$cat_row['id'];
    }
    $cat_stmt->close();
}

$price = isset($_GET['price']) ? $_GET['price'] : '';
$stars = isset($_GET['stars']) ? $_GET['stars'] : '';
$sort  = isset($_GET['sort'])  ? $_GET['sort']  : '';
$page  = isset($_GET['page'])  ? (int)$_GET['page'] : 1;

// Pagination
$items_per_page = 12;
$offset = ($page - 1) * $items_per_page;

// Build base SQL and parameters
$sql        = "SELECT * FROM places";
$conditions = [];
$params     = [];
// Search by tags, name, or exact category match
if ($search !== '') {
    // Combine search conditions
    $cond = [];
    $cond[] = "tags LIKE ?";
    $params[] = "%{$search}%";
    $cond[] = "name LIKE ?";
    $params[] = "%{$search}%";
    if ($search_cat_id) {
        $cond[] = "category_id = ?";
        $params[] = $search_cat_id;
    }
    $conditions[] = '(' . implode(' OR ', $cond) . ')';
}

// Category filter dropdown
if ($category_id > 0) {
    $conditions[] = "category_id = ?";
    $params[]     = $category_id;
}

// Price filter
if ($price !== '') {
    $conditions[] = "price = ?";
    $params[]     = $price;
}

// Stars filter
if ($stars !== '') {
    $conditions[] = "id IN (
        SELECT place_id
        FROM reviews
        GROUP BY place_id
        HAVING AVG(rating) >= ?
    )";
    $params[] = $stars;
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Sorting
if (!empty($sort)) {
    switch ($sort) {
        case '1':
            $sql .= " ORDER BY (SELECT AVG(rating) FROM reviews WHERE place_id = places.id) DESC";
            break;
        case '2':
            $sql .= " ORDER BY created_at DESC";
            break;
        case '3':
            $sql .= " ORDER BY price";
            break;
    }
} else {
    $sql .= " ORDER BY RAND()";
}

// === Fetch total items for pagination ===
$stmt = $conn->prepare($sql);
if ($params) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$total_items = $result->num_rows;
$stmt->close();

// === Fetch current page items ===
$sql .= " LIMIT ?, ?";
$params[] = $offset;
$params[] = $items_per_page;

$stmt = $conn->prepare($sql);
// Now last two params are integers
$types = str_repeat('s', count($params) - 2) . 'ii';
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$places = [];
while ($row = $result->fetch_assoc()) {
    $places[] = $row;
}
$stmt->close();

// Calculate pagination
$total_pages  = (int)ceil($total_items / $items_per_page);
$current_page = max(1, min($total_pages, $page));

// Fetch saved places for logged-in user
$saved_places = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $q = $conn->prepare("SELECT place_id FROM saved_places WHERE user_id = ?");
    $q->bind_param("i", $user_id);
    $q->execute();
    $rs = $q->get_result();
    while ($r = $rs->fetch_assoc()) {
        $saved_places[] = $r['place_id'];
    }
    $q->close();
}
?>


<main>
    <div class="listing">
        <div class="pageinfo">
            <div class="pageinfo_content">
    <h2>
        <?php
        // Place this mapping array here
        $category_names = [
            'restaurants' => 'RESTAURANTS',
            'shopping' => 'SHOPPING',
            'active-life' => 'ACTIVE LIFE',
            'home s' => 'HOME SERVICES',
            'coffee' => 'COFFEE',
            'pets' => 'PETS',
            'plants' => 'PLANTS SHOP',
            'art' => 'ART',
            'hotal' => 'HOTELS',
            'edu' => 'EDUCATION',
            'health' => 'HEALTH',
            'workspace' => 'WORKSPACE'
        ];

        if (!empty($search)) {
            echo "Search Results for: " . htmlspecialchars($search);
        } elseif ($category_id > 0) {
            $sql = "SELECT name FROM categories WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $category_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $category = $result->fetch_assoc();

            if ($category) {
                $key = strtolower($category['name']); // normalize DB value
                echo isset($category_names[$key]) ? $category_names[$key] : 'Unknown Category';
            } else {
                echo "Unknown Category";
            }
        } else {
            echo "All Listings";
        }
        ?>
    </h2>
</div>

        </div>
<!-- Filters (Price, Categories, Stars) -->
<div class="listing_filter">
    <div class="listing_filter-L">
        <select name="price" class="custom-select" onchange="filterChange()">
            <option value="" disabled <?php echo empty($price) ? 'selected' : ''; ?>>Price</option>
            <option value="$" <?php echo $price == '1' ? 'selected' : ''; ?>>$</option>
            <option value="$$" <?php echo $price == '2' ? 'selected' : ''; ?>>$$</option>
            <option value="$$$" <?php echo $price == '3' ? 'selected' : ''; ?>>$$$</option>
        </select>
        <select name="category_id" class="custom-select" onchange="filterChange()">
            <option value="" disabled <?php echo empty($category_id) ? 'selected' : ''; ?>>Categories</option>
            <option value="1" <?php echo $category_id == '1' ? 'selected' : ''; ?>>RESTAURANTS</option>
            <option value="2" <?php echo $category_id == '2' ? 'selected' : ''; ?>>SHOPPING</option>
            <option value="3" <?php echo $category_id == '3' ? 'selected' : ''; ?>>ACTIVE LIFE</option>
            <option value="4" <?php echo $category_id == '4' ? 'selected' : ''; ?>>HOME SERVICES</option>
            <option value="5" <?php echo $category_id == '5' ? 'selected' : ''; ?>>COFFEE</option>
            <option value="6" <?php echo $category_id == '6' ? 'selected' : ''; ?>>PETS</option>
            <option value="7" <?php echo $category_id == '7' ? 'selected' : ''; ?>>PLANTS SHOP</option>
            <option value="8" <?php echo $category_id == '8' ? 'selected' : ''; ?>>ART</option>
            <option value="9" <?php echo $category_id == '9' ? 'selected' : ''; ?>>HOTELS</option>
            <option value="10" <?php echo $category_id == '10' ? 'selected' : ''; ?>>EDUCATION</option>
            <option value="11" <?php echo $category_id == '11' ? 'selected' : ''; ?>>HEALTH</option>
            <option value="12" <?php echo $category_id == '12' ? 'selected' : ''; ?>>WORKSPACE</option>
        </select>
        <select name="stars" class="custom-select" onchange="filterChange()">
            <option value="" disabled <?php echo empty($stars) ? 'selected' : ''; ?>>Stars</option>
            <option value="1" <?php echo $stars == '1' ? 'selected' : ''; ?>>1 and more</option>
            <option value="2" <?php echo $stars == '2' ? 'selected' : ''; ?>>2 and more</option>
            <option value="3" <?php echo $stars == '3' ? 'selected' : ''; ?>>3 and more</option>
            <option value="4" <?php echo $stars == '4' ? 'selected' : ''; ?>>4 and more</option>
            <option value="5" <?php echo $stars == '5' ? 'selected' : ''; ?>>5</option>
        </select>
    </div>
    <select name="sort" class="custom-select" onchange="filterChange()">
    <option value="" disabled selected>Sort by</option>
    <option value="1" <?php echo $sort == '1' ? 'selected' : ''; ?>>Stars</option>
    <option value="2" <?php echo $sort == '2' ? 'selected' : ''; ?>>Newest</option>
    <option value="3" <?php echo $sort == '3' ? 'selected' : ''; ?>>Price</option>
</select>
</div>
        <!-- Display Places -->
        <div class="listing_grid">
            <?php if (!empty($places)): ?>
                <?php foreach ($places as $place): ?>
                    <?php
                    // Fetch category icon dynamically for each place based on category_id
                    $category_sql = "SELECT icon FROM categories WHERE id = ?";
                    $category_stmt = $conn->prepare($category_sql);
                    $category_stmt->bind_param("i", $place['category_id']);
                    $category_stmt->execute();
                    $category_result = $category_stmt->get_result();
                    $category_data = $category_result->fetch_assoc();
                    $category_icon = $category_data['icon'] ?? '';  // Default to empty if no icon
                    ?>

                    <div class="listing_grid--item">
                        <div class="listing_grid--item-img">
                            <a href="single-place.php?place_id=<?php echo $place['id']; ?>" class="listing_grid--item-img_img">
                                <img src="<?php echo $place['featured_image']; ?>" alt="<?php echo $place['name']; ?>">
                            </a>
                            <a href="listing.php?category_id=<?php echo $place['category_id']; ?>" class="listing_grid--item-img_category">
                                <i class="<?php echo htmlspecialchars($category_icon); ?>"></i>
                            </a>
                            <!-- Save Icon -->
                            <a href="#" class="listing_grid--item-img_save" onclick="toggleSave(event, <?php echo $place['id']; ?>)">
                                <i class="<?php echo in_array($place['id'], $saved_places) ? 'fa-solid fa-bookmark' : 'fa-regular fa-bookmark'; ?>"></i>
                            </a>
                        </div>
                        <div class="listing_grid--item-content">
                            <div class="listing_grid--item-content_tages">
                                <?php 
                                $tags = explode(',', $place['tags']);
                                foreach ($tags as $tag): ?>
                                <a href="listing.php?search=<?php echo urlencode(trim($tag)); ?>">
                                    <?php echo htmlspecialchars(trim($tag)); ?>
                                </a>
                                <?php endforeach; ?>
                            </div>
                            <a class="listing_grid--item-content_name" href="single-place.php?place_id=<?php echo $place['id']; ?>">
                                <?php echo $place['name']; ?>
                            </a>
                            <a href="#" class="listing_grid--item-content_location">
                                <i class="fa-solid fa-location-dot"></i> <?php echo $place['google_map_location']; ?>
                            </a>
                            <div class="listing_grid--item-content_stars">
                                <!-- Rating logic -->
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
                                <h4 class="listing_grid--item-content_stars-price"><?php echo $place['price']; ?></h4>
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
                <?php if ($current_page > 1): ?>
                    <li class="indicator_item">
                        <a href="?page=<?php echo $current_page - 1; ?>&category_id=<?php echo $category_id; ?>&search=<?php echo urlencode($search); ?>&price=<?php echo $price; ?>&stars=<?php echo $stars; ?>">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="indicator_item <?php echo ($i === $current_page) ? 'active' : ''; ?>">
                        <a href="?page=<?php echo $i; ?>&category_id=<?php echo $category_id; ?>&search=<?php echo urlencode($search); ?>&price=<?php echo $price; ?>&stars=<?php echo $stars; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <li class="indicator_item">
                        <a href="?page=<?php echo $current_page + 1; ?>&category_id=<?php echo $category_id; ?>&search=<?php echo urlencode($search); ?>&price=<?php echo $price; ?>&stars=<?php echo $stars; ?>">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

    </div>
</main>

<script>
    function filterChange() {
    // Get the selected values from the filter dropdowns
    const price = document.querySelector('select[name="price"]').value;
    const category_id = document.querySelector('select[name="category_id"]').value;
    const stars = document.querySelector('select[name="stars"]').value;
    const sort = document.querySelector('select[name="sort"]').value; // Capture sort value

    // Build the new URL with updated query parameters
    const url = new URL(window.location.href);
    
    // Set the updated query parameters
    if (price) {
        url.searchParams.set('price', price);
    }
    if (category_id) {
        url.searchParams.set('category_id', category_id);
    }
    if (stars) {
        url.searchParams.set('stars', stars);
    }
    if (sort) {  // Add sort parameter if it's selected
        url.searchParams.set('sort', sort);
    }

    // Reload the page with the new query parameters
    window.location.href = url.toString();
}

</script>


<?php
include 'footer.php';
?>
