<?php
include 'config.php'; // Include session settings
session_start(); // Start the session


include 'header.php';  // Ensure the database connection is established in header.php

// Get category_id, price, search term, and rating from the URL
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
$stars = isset($_GET['stars']) ? $_GET['stars'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

// Initialize pagination variables
$items_per_page = 12; // Items per page
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;

// Query building for search, category, price, and rating filters
$sql = "SELECT * FROM places";
$conditions = [];
$params = [];

if (!empty($search)) {
    $conditions[] = "tags LIKE ?";
    $params[] = "%$search%";
}

if ($category_id > 0) {
    $conditions[] = "category_id = ?";
    $params[] = $category_id;
}

if (!empty($price)) {
    $conditions[] = "price = ?";
    $params[] = $price;
}

if (!empty($stars)) {
    $conditions[] = "id IN (SELECT place_id FROM reviews GROUP BY place_id HAVING AVG(rating) >= ?)";
    $params[] = $stars;
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

// Apply sorting logic if 'sort' parameter is set
if (!empty($sort)) {
    switch ($sort) {
        case '1':  // Stars
            $sql .= " ORDER BY (SELECT AVG(rating) FROM reviews WHERE place_id = places.id) DESC";
            break;
        case '2':  // Newest
            $sql .= " ORDER BY created_at DESC";  // Assuming 'created_at' column exists
            break;
        case '3':  // Price
            $sql .= " ORDER BY price";
            break;
    }
} else {
    $sql .= " ORDER BY RAND()";  // Default sorting is random if no sort option is selected
}

// Fetch total items for pagination
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $types = str_repeat('s', count($params));  // Adjust types based on number of params
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$total_items = $result->num_rows;  // Get the total number of items for pagination
$stmt->close();

// Fetch items for the current page with pagination
$sql .= " LIMIT ?, ?";
$params[] = $offset;  // Offset for pagination
$params[] = $items_per_page;

$stmt = $conn->prepare($sql);
$types = str_repeat('s', count($params) - 2) . 'ii';  // Adjust types for pagination parameters
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$places = [];
while ($row = $result->fetch_assoc()) {
    $places[] = $row;
}

// Pagination calculation
$total_pages = ceil($total_items / $items_per_page);
$current_page = max(1, min($total_pages, $current_page));  // Ensure the page is within bounds
?>

<?php
// Fetch saved places for the logged-in user
$saved_places = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $saved_places_query = $conn->prepare("SELECT place_id FROM saved_places WHERE user_id = ?");
    $saved_places_query->bind_param("i", $user_id);
    $saved_places_query->execute();
    $saved_places_result = $saved_places_query->get_result();
    while ($saved_place = $saved_places_result->fetch_assoc()) {
        $saved_places[] = $saved_place['place_id'];
    }
}
?>

<main>
    <div class="listing">
        <div class="pageinfo">
            <div class="pageinfo_content">
                <h2>
                    <?php
                    if (!empty($search)) {
                        echo "Search Results for: " . htmlspecialchars($search);
                    } elseif ($category_id > 0) {
                        // Fetch category name and icon from database
                        $sql = "SELECT name, icon FROM categories WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $category_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $category = $result->fetch_assoc();

                        if ($category) {
                            echo htmlspecialchars($category['name']);
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
