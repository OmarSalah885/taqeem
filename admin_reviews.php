<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

// 1) Only admins
if (empty($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header('Location: index.php');
    exit;
}

// 2) Search input
$search      = trim($_GET['search'] ?? '');
$searchParam = "%{$search}%";

// 3) Pagination setup
$perPage = 25;
$page    = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $perPage;

// 4) Count total reviews (with optional search on user name, place name, rating, or date)
$countSql     = "
    SELECT COUNT(*)
      FROM reviews r
      JOIN users u  ON r.user_id  = u.id
      JOIN places p ON r.place_id = p.id
";
$whereClauses = [];
$params       = [];
$types        = '';

if ($search !== '') {
    $whereClauses[] = "(
        CONCAT(u.first_name,' ',u.last_name) LIKE ? OR
        p.name LIKE ? OR
        r.rating = ? OR
        DATE(r.created_at) LIKE ?
    )";
    // bind 4 params in the same order:
    $params[] = $searchParam;               // user full name
    $params[] = $searchParam;               // place name
    $params[] = is_numeric($search) ? $search : 0; // rating exact (as integer)
    $params[] = $searchParam;               // date partial

    $types .= 'ssis'; // s, s, i, s
}

if (!empty($whereClauses)) {
    $countSql .= ' WHERE ' . implode(' AND ', $whereClauses);
}

$countStmt = $conn->prepare($countSql);
if (!empty($whereClauses)) {
    $countStmt->bind_param($types, ...$params);
}
$countStmt->execute();
$countStmt->bind_result($totalReviews);
$countStmt->fetch();
$countStmt->close();

$totalPages = (int)ceil($totalReviews / $perPage);

// 5) Fetch page of reviews
$baseSql = "
    SELECT r.id,
           r.place_id,                   -- add this
           u.profile_image,
           u.first_name, u.last_name,
           p.name AS place_name,
           r.rating,
           r.review_text,
           r.created_at
      FROM reviews r
      JOIN users  u ON r.user_id  = u.id
      JOIN places p ON r.place_id = p.id
";

if (!empty($whereClauses)) {
    $baseSql .= ' WHERE ' . implode(' AND ', $whereClauses);
}
$offsetInt  = (int)$offset;
$perPageInt = (int)$perPage;
$baseSql   .= " ORDER BY r.id ASC LIMIT {$offsetInt}, {$perPageInt}";

$stmt = $conn->prepare($baseSql);
if (!empty($whereClauses)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$reviews = $stmt->get_result();
$stmt->close();

include 'header.php';
?>

<main class="admin_main">
    <h1>Reviews Management</h1>

    <form method="GET" action="" class="search-container">
        <input
          type="text"
          id="reviewSearch"
          name="search"
          placeholder="Search by user, place name, rating, or date..."
          value="<?php echo htmlspecialchars($search); ?>"
        >
        <button type="submit">Search</button>
    </form>

    <div class="table-container">
        <table id="reviewTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Image</th>
                    <th>User Name</th>
                    <th>Place Name</th>
                    <th>Rating</th>
                    <th>Review Text</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
<?php
$rowNum = $offset + 1;
while ($rev = $reviews->fetch_assoc()):
    $userImg  = $rev['profile_image'] ?: 'assets/images/profiles/pro_null.png';
    $userName = htmlspecialchars($rev['first_name'] . ' ' . $rev['last_name']);
    $placeName= htmlspecialchars($rev['place_name']);
    $text     = htmlspecialchars(mb_strimwidth($rev['review_text'],0,50,'…'));
    $created  = substr($rev['created_at'],0,10);
?>
                <tr>
                    <td><?php echo $rowNum++; ?></td>
                    <td><img src="<?php echo htmlspecialchars($userImg); ?>" alt="User" width="50" height="50"></td>
                    <td><?php echo $userName; ?></td>
                    <td><?php echo $placeName; ?></td>
                    <td><?php echo (int)$rev['rating']; ?></td>
                    <td><?php echo $text; ?></td>
                    <td><?php echo $created; ?></td>
                    <td class="actions">
                        <a
  href="single-place.php?place_id=<?php echo $rev['place_id']; ?>&review_id=<?php echo $rev['id']; ?>#review_<?php echo $rev['id']; ?>"
  class="btn-edit"
>
  Edit
</a>

                        <a href="delete_review.php?id=<?php echo $rev['id']; ?>" class="btn-delete" onclick="return confirm('Delete this review?');"> Delete</a>
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
