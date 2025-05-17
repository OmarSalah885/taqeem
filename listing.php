<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();
include 'header.php';

$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$price       = isset($_GET['price']) ? $_GET['price'] : '';
$stars       = isset($_GET['stars']) ? (int)$_GET['stars'] : 0;
$sort        = isset($_GET['sort']) ? $_GET['sort'] : '';
$page        = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search      = !empty($_GET['search_term']) ? trim($_GET['search_term']) : (!empty($_GET['search']) ? trim($_GET['search']) : '');

$items_per_page = 12;
$offset = ($page - 1) * $items_per_page;

$conditions = [];
$params = [];
$param_types = '';

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

    $conditions[] = "(places.name LIKE ? OR places.tags LIKE ?" . ($search_cat_id ? " OR places.category_id = ?" : "") . ")";
    $params[] = "%$search%";
    $param_types .= 's';
    $params[] = "%$search%";
    $param_types .= 's';
    if ($search_cat_id) {
        $params[] = $search_cat_id;
        $param_types .= 'i';
    }
}

if ($category_id > 0) {
    $conditions[] = "places.category_id = ?";
    $params[] = $category_id;
    $param_types .= 'i';
}

if ($price !== '') {
    $conditions[] = "places.price = ?";
    $params[] = $price;
    $param_types .= 's';
}

if ($stars > 0) {
    $conditions[] = "places.id IN (
        SELECT place_id FROM reviews GROUP BY place_id HAVING AVG(rating) >= ?
    )";
    $params[] = $stars;
    $param_types .= 'i';
}

// === COUNT Query for Pagination ===
$count_sql = "SELECT COUNT(*) AS total FROM places";
if ($conditions) {
    $count_sql .= " WHERE " . implode(" AND ", $conditions);
}
$count_stmt = $conn->prepare($count_sql);
if (!empty($params)) {
    $count_stmt->bind_param($param_types, ...$params);
}
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_items = $count_result->fetch_assoc()['total'] ?? 0;
$count_stmt->close();

$total_pages = ceil($total_items / $items_per_page);
$current_page = max(1, min($total_pages, $page));

// === Fetch Paginated Data with JOIN ===
$sql = "SELECT places.*, categories.icon AS category_icon 
        FROM places 
        LEFT JOIN categories ON places.category_id = categories.id";
if ($conditions) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

switch ($sort) {
    case '1':
        $sql .= " ORDER BY (SELECT AVG(rating) FROM reviews WHERE place_id = places.id) DESC";
        break;
    case '2':
        $sql .= " ORDER BY places.created_at DESC";
        break;
    case '3':
        $sql .= " ORDER BY places.price";
        break;
    default:
        $sql .= " ORDER BY RAND()";
}

$sql .= " LIMIT ?, ?";
$params[] = $offset;
$params[] = $items_per_page;
$param_types .= 'ii';

$stmt = $conn->prepare($sql);
$stmt->bind_param($param_types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$places = [];
while ($row = $result->fetch_assoc()) {
    $places[] = $row;
}
$stmt->close();

// === Get Saved Places if Logged In ===
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

// === Category Name Mapping ===
$category_names = [
    'restaurants'     => 'RESTAURANTS',
    'shopping'        => 'SHOPPING',
    'active-life'     => 'ACTIVE LIFE',
    'home services'   => 'HOME SERVICES',
    'coffee'          => 'COFFEE',
    'pets'            => 'PETS',
    'plants'          => 'PLANTS SHOP',
    'art'             => 'ART',
    'hotel'           => 'HOTELS',
    'edu'             => 'EDUCATION',
    'health'          => 'HEALTH',
    'workspace'       => 'WORKSPACE'
];
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
    <option value="">All</option>
    <option value="$" <?php echo $price == '$' ? 'selected' : ''; ?>>$</option>
    <option value="$$" <?php echo $price == '$$' ? 'selected' : ''; ?>>$$</option>
    <option value="$$$" <?php echo $price == '$$$' ? 'selected' : ''; ?>>$$$</option>
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
            <?php
$range        = 2; // pages either side of current
$jump         = 3; // pages to jump when clicking “…”
$totalPages   = (int)ceil($total_items / $items_per_page);
$currentPage  = $current_page;

// helper to build the query string with all filters
function buildQs($page, $category_id, $search, $price, $stars) {
    $qs = '?page=' . $page;
    if ($category_id) { $qs .= '&category_id=' . $category_id; }
    if ($search    ) { $qs .= '&search='      . urlencode($search); }
    if ($price     ) { $qs .= '&price='       . urlencode($price); }
    if ($stars     ) { $qs .= '&stars='       . urlencode($stars); }
    return $qs;
}

// helper to render ellipsis
function renderEllipsis($targetPage, $category_id, $search, $price, $stars) {
    echo '<li class="indicator_item ellipsis">';
    echo    '<a href="' . buildQs($targetPage, $category_id, $search, $price, $stars) . '">…</a>';
    echo '</li>';
}
?>
<ul class="listing_indicator">
  <!-- Prev -->
  <?php if ($currentPage > 1): ?>
    <li class="indicator_item">
      <a href="<?= buildQs($currentPage - 1, $category_id, $search, $price, $stars) ?>">
        <i class="fa-solid fa-chevron-left"></i>
      </a>
    </li>
  <?php endif; ?>

  <!-- First + leading ellipsis -->
  <?php if ($currentPage > $range + 1): ?>
    <li class="indicator_item">
      <a href="<?= buildQs(1, $category_id, $search, $price, $stars) ?>">1</a>
    </li>
    <?php renderEllipsis(max(1, $currentPage - $jump), $category_id, $search, $price, $stars); ?>
  <?php endif; ?>

  <!-- Pages around current -->
  <?php
    $start = max(1, $currentPage - $range);
    $end   = min($totalPages, $currentPage + $range);
    for ($i = $start; $i <= $end; $i++): 
  ?>
    <li class="indicator_item <?= $i === $currentPage ? 'active' : '' ?>">
      <?php if ($i === $currentPage): ?>
        <a href="javascript:void(0)"><?= $i ?></a>
      <?php else: ?>
        <a href="<?= buildQs($i, $category_id, $search, $price, $stars) ?>"><?= $i ?></a>
      <?php endif; ?>
    </li>
  <?php endfor; ?>

  <!-- Trailing ellipsis + last -->
  <?php if ($currentPage < $totalPages - $range): ?>
    <?php renderEllipsis(min($totalPages, $currentPage + $jump), $category_id, $search, $price, $stars); ?>
    <li class="indicator_item">
      <a href="<?= buildQs($totalPages, $category_id, $search, $price, $stars) ?>">
        <?= $totalPages ?>
      </a>
    </li>
  <?php endif; ?>

  <!-- Next -->
  <?php if ($currentPage < $totalPages): ?>
    <li class="indicator_item">
      <a href="<?= buildQs($currentPage + 1, $category_id, $search, $price, $stars) ?>">
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
    const price = document.querySelector('select[name="price"]').value || '';
    const category_id = document.querySelector('select[name="category_id"]').value || '';
    const stars = document.querySelector('select[name="stars"]').value || '';
    const sort = document.querySelector('select[name="sort"]').value || '';

    const params = new URLSearchParams();
    if (price) params.append('price', price);
    if (category_id) params.append('category_id', category_id);
    if (stars) params.append('stars', stars);
    if (sort) params.append('sort', sort);

    window.location.href = 'listing.php?' + params.toString();
}
</script>



<?php
include 'footer.php';
?>
