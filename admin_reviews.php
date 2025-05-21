<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

// 1) Only admins
if (empty($_SESSION['role']) || strtolower(trim($_SESSION['role'])) !== 'admin') {
    header('Location: index.php');
    exit;
}

// 2) Search input
$search = trim($_GET['search'] ?? '');

function isValidDate($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

function isPartialDate($date) {
    // Matches YYYY or YYYY-MM only (partial date)
    return preg_match('/^\d{4}(-\d{2})?$/', $date);
}

// Prepare parameters
$whereClauses = [];
$params = [];
$types = '';

if ($search !== '') {
    // Prepare the date search param for exact or partial date
    if (isValidDate($search)) {
        // Full exact date, no wildcard
        $dateSearch = $search;
    } elseif (isPartialDate($search)) {
        // Partial date, add wildcard to match any day in that month or year
        $dateSearch = $search . '%';
    } else {
        // Not a valid date or partial date, no match for date search
        $dateSearch = null;
    }

    $whereClauses[] = "(" .
        "CONCAT(u.first_name,' ',u.last_name) LIKE ? OR " .
        "p.name LIKE ? OR " .
        "r.rating = ? " .
        ($dateSearch !== null ? "OR DATE_FORMAT(r.created_at, '%Y-%m-%d') LIKE ?" : "") .
    ")";

    // Bind name and place name
    $params[] = "%$search%";
    $params[] = "%$search%";
    // Bind rating or -1 for no match if not numeric
    $params[] = is_numeric($search) ? (int)$search : -1;

    if ($dateSearch !== null) {
        $params[] = $dateSearch;
        $types = 'sssi';  // 3 strings + 1 int OR 2 strings + 1 int + 1 string for date
    } else {
        $types = 'ssi';  // no date param
    }
}

// 3) Pagination setup
$perPage = 25;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $perPage;

// 4) Count total reviews (with optional search)
$countSql = "
    SELECT COUNT(*)
      FROM reviews r
      JOIN users u  ON r.user_id  = u.id
      JOIN places p ON r.place_id = p.id
";

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
           r.place_id,
           r.user_id,
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
$baseSql .= " ORDER BY r.id ASC LIMIT ?, ?";

$stmt = $conn->prepare($baseSql);

if (!empty($whereClauses)) {
    // Merge search params with offset & perPage
    $allParams = array_merge($params, [$offset, $perPage]);
    $allTypes  = $types . 'ii';  // e.g. 'sssi' + 'ii' or 'ssi' + 'ii'

    $stmt->bind_param($allTypes, ...$allParams);
} else {
    $stmt->bind_param('ii', $offset, $perPage);
}

$stmt->execute();
$reviews = $stmt->get_result();
$stmt->close();

function renderEllipsis($target, $search) {
    echo '<li class="indicator_item ellipsis">';
    echo    '<a href="?page=' . $target . '&search=' . urlencode($search) . '">…</a>';
    echo '</li>';
}

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
          value="<?= htmlspecialchars($search) ?>"
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
    $userImg   = $rev['profile_image'] ?: 'assets/images/profiles/pro_null.png';
    $userName  = htmlspecialchars($rev['first_name'] . ' ' . $rev['last_name']);
    $placeName = htmlspecialchars($rev['place_name']);
    $text      = htmlspecialchars(mb_strimwidth($rev['review_text'], 0, 50, '…'));
    $created   = substr($rev['created_at'], 0, 10);
    $userId    = $rev['user_id'];
?>
                <tr>
                    <td><?= $rowNum++ ?></td>
                    <td>
                        <a href="profile.php?user_id=<?= (int)$userId ?>">
                            <img src="<?= htmlspecialchars($userImg) ?>" alt="User" width="50" height="50">
                        </a>
                    </td>
                    <td>
                        <a href="profile.php?user_id=<?= (int)$userId ?>"><?= $userName ?></a>
                    </td>
                    <td><?= $placeName ?></td>
                    <td><?= (int)$rev['rating'] ?></td>
                    <td><?= $text ?></td>
                    <td><?= $created ?></td>
                    <td class="actions">
                        <a href="single-place.php?place_id=<?= $rev['place_id'] ?>&review_id=<?= $rev['id'] ?>&action=edit#review_<?= $rev['id'] ?>" class="btn-edit">Edit</a>
                        <a href="delete_review.php?id=<?= $rev['id'] ?>" class="btn-delete" onclick="return confirm('Delete this review?');">Delete</a>
                    </td>
                </tr>
<?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="listing_indicator">
        <ul class="listing_indicator">
            <?php
            $range       = 2;
            $jump        = 3;
            $currentPage = $page;

            // Previous arrow
            if ($currentPage > 1): ?>
                <li class="indicator_item">
                    <a href="?page=<?= $currentPage - 1 ?>&search=<?= urlencode($search) ?>">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php
            // Leading ellipsis (and first page)
            if ($currentPage > $range + 1):
                $leadTarget = max(1, $currentPage - $jump);
            ?>
                <li class="indicator_item">
                    <a href="?page=1&search=<?= urlencode($search) ?>">1</a>
                </li>
                <?php renderEllipsis($leadTarget, $search); ?>
            <?php endif; ?>

            <?php
            // Pages around current
            $start = max(1, $currentPage - $range);
            $end   = min($totalPages, $currentPage + $range);
            for ($i = $start; $i <= $end; $i++): ?>
                <li class="indicator_item <?= $i === $currentPage ? 'active' : '' ?>">
                    <?php if ($i === $currentPage): ?>
                        <a href="javascript:void(0)"><?= $i ?></a>
                    <?php else: ?>
                        <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                    <?php endif; ?>
                </li>
            <?php endfor; ?>

            <?php
            // Trailing ellipsis (and last page)
            if ($currentPage < $totalPages - $range):
                $trailTarget = min($totalPages, $currentPage + $jump);
            ?>
                <?php renderEllipsis($trailTarget, $search); ?>
                <li class="indicator_item">
                    <a href="?page=<?= $totalPages ?>&search=<?= urlencode($search) ?>"><?= $totalPages ?></a>
                </li>
            <?php endif; ?>

            <?php
            // Next arrow
            if ($currentPage < $totalPages): ?>
                <li class="indicator_item">
                    <a href="?page=<?= $currentPage + 1 ?>&search=<?= urlencode($search) ?>">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

</main>

<?php include 'footer.php'; ?>