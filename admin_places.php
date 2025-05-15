<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

// 1. Only admins
if (empty($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header('Location: index.php');
    exit;
}

// 2. Search input
$search      = trim($_GET['search'] ?? '');
$searchParam = "%{$search}%";

// 3. Pagination setup
$perPage = 25;
$page    = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $perPage;

// 4. Count total places (with optional search)
$countSql     = "SELECT COUNT(*) FROM places";
$whereClauses = [];
$params       = [];
$types        = '';

if ($search !== '') {
    $whereClauses[] = "(
        name LIKE ? OR
        tags LIKE ? OR
        country LIKE ? OR
        city LIKE ? OR
        email LIKE ? OR
        DATE(created_at) LIKE ?
    )";

    // bind 6 params in same order
    array_push(
      $params,
      $searchParam, // name
      $searchParam, // tags
      $searchParam, // country
      $searchParam, // city
      $searchParam, // email
      $searchParam  // created_at (YYYY-MM-DD)
    );
    $types .= str_repeat('s', 6);
}

if (!empty($whereClauses)) {
    $countSql .= ' WHERE ' . implode(' AND ', $whereClauses);
}

$countStmt = $conn->prepare($countSql);
if (!empty($whereClauses)) {
    $countStmt->bind_param($types, ...$params);
}
$countStmt->execute();
$countStmt->bind_result($totalPlaces);
$countStmt->fetch();
$countStmt->close();

$totalPages = (int)ceil($totalPlaces / $perPage);

// 5. Fetch page of places
$baseSql = "
    SELECT id, featured_image, name, tags, description,
           country, city, email, created_at
    FROM places
";
if (!empty($whereClauses)) {
    $baseSql .= ' WHERE ' . implode(' AND ', $whereClauses);
}
// append order & limit
$offsetInt  = (int)$offset;
$perPageInt = (int)$perPage;
$baseSql   .= " ORDER BY id ASC LIMIT {$offsetInt}, {$perPageInt}";

$stmt = $conn->prepare($baseSql);
if (!empty($whereClauses)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$places = $stmt->get_result();
$stmt->close();

include 'header.php';
?>

<main class="admin_main">
    <h1>Places Management</h1>

    <form method="GET" action="" class="search-container">
        <input
          type="text"
          id="placeSearch"
          name="search"
          placeholder="Search by name, tags, country, city, email, or date..."
          value="<?php echo htmlspecialchars($search); ?>"
        >
        <button type="submit">Search</button>
    </form>

    <div class="table-container">
        <table id="placeTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Featured Image</th>
                    <th>Place Name</th>
                    <th>Tags</th>
                    <th>Description</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
<?php 
$rowNum = $offset + 1;
while ($place = $places->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $rowNum++; ?></td>
                    <td>
                        <img
                          src="<?php echo htmlspecialchars($place['featured_image'] ?: 'assets/images/places/placeholder.png'); ?>"
                          alt="Featured"
                          width="80"
                          height="50"
                        >
                    </td>
                    <td><?php echo htmlspecialchars($place['name']); ?></td>
                    <td><?php echo htmlspecialchars($place['tags']); ?></td>
                    <td><?php echo htmlspecialchars(mb_strimwidth($place['description'],0,50,'…')); ?></td>
                    <td><?php echo htmlspecialchars($place['country']); ?></td>
                    <td><?php echo htmlspecialchars($place['city']); ?></td>
                    <td><?php echo htmlspecialchars($place['email']); ?></td>
                    <td><?php echo htmlspecialchars(substr($place['created_at'],0,10)); ?></td>
                    <td class="actions">
                        <a href="edit_place.php?place_id=<?php echo $place['id']; ?>" class="btn-edit">Edit</a>
                        <form action="delete_place.php" method="POST" style="display:inline;" onsubmit="return confirm('Delete this place?');">
    <input type="hidden" name="place_id" value="<?php echo $place['id']; ?>">
    <input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
    <button type="submit" class="btn-delete">Delete</button>
</form>

                    </td>
                </tr>
<?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="listing_indicator">
        <ul class="listing_indicator">
            <?php if ($page > 1): ?>
                <li class="indicator_item">
                    <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="indicator_item <?php echo ($i === $page) ? 'active' : ''; ?>">
                    <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <li class="indicator_item">
                    <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</main>

<?php include 'footer.php'; ?>
