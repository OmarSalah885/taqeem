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

// --- NEW partial date search detection
$isDateSearch = false;
if ($search !== '') {
    // Full date exact match YYYY-MM-DD
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $search)) {
        $whereClauses[] = "DATE(created_at) = ?";
        $params[] = $search;
        $types .= 's';
        $isDateSearch = true;
    }
    // Partial date match YYYY-MM or YYYY
    else if (preg_match('/^\d{4}-\d{2}$/', $search) || preg_match('/^\d{4}$/', $search)) {
        // Use LIKE on created_at string (created_at is datetime, so LIKE works)
        $whereClauses[] = "created_at LIKE ?";
        $params[] = $search . '%';
        $types .= 's';
        $isDateSearch = true;
    }
    else {
        // General LIKE search on text fields
        $whereClauses[] = "(
            name LIKE ? OR
            tags LIKE ? OR
            country LIKE ? OR
            city LIKE ? OR
            email LIKE ?
        )";
        for ($i = 0; $i < 5; $i++) {
            $params[] = $searchParam;
        }
        $types .= str_repeat('s', 5);
    }
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
        <input type="text" id="placeSearch" name="search"
            placeholder="Search by name, tags, country, city, email, or date (YYYY-MM-DD or partial)..."
            value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>

    <div class="table-container">
        <?php if ($totalPlaces === 0): ?>
        <p>No results found.</p>
        <?php else: ?>
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
                        <a href="single-place.php?place_id=<?php echo $place['id']; ?>">
                            <img src="<?php echo htmlspecialchars($place['featured_image'] ?: 'assets/images/places/placeholder.png'); ?>"
                                alt="<?php echo htmlspecialchars('Featured image of ' . $place['name']); ?>" width="80"
                                height="50">
                        </a>
                    </td>
                    <td>
                        <a href="single-place.php?place_id=<?php echo $place['id']; ?>" class="admins_links">
                            <?php echo htmlspecialchars($place['name']); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($place['tags']); ?></td>
                    <td><?php echo htmlspecialchars(mb_strimwidth($place['description'], 0, 50, '…')); ?></td>
                    <td><?php echo htmlspecialchars($place['country']); ?></td>
                    <td><?php echo htmlspecialchars($place['city']); ?></td>
                    <td><?php echo htmlspecialchars($place['email']); ?></td>
                    <td><?php echo htmlspecialchars(substr($place['created_at'], 0, 10)); ?></td>
                    <td class="actions">
                        <a href="edit_place.php?place_id=<?php echo $place['id']; ?>" class="btn-edit">Edit</a>
                        <form action="delete_place.php" method="POST" style="display:inline;"
                            onsubmit="return confirm('Delete this place?');">
                            <input type="hidden" name="place_id" value="<?php echo $place['id']; ?>">
                            <input type="hidden" name="redirect_to"
                                value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 0): ?>
    <div class="listing_indicator">
        <?php
        $range       = 2;   // pages to show either side of current
        $jump        = 3;   // pages to jump when clicking “…”
        $currentPage = $page;

        // helper to render a clickable ellipsis
        function renderEllipsis($targetPage, $search) {
            echo '<li class="indicator_item ellipsis">';
            echo    '<a href="?page=' . $targetPage . '&search=' . urlencode($search) . '">…</a>';
            echo '</li>';
        }
        ?>
        <ul class="listing_indicator">
            <!-- Previous arrow -->
            <?php if ($currentPage > 1): ?>
            <li class="indicator_item">
                <a href="?page=<?= $currentPage - 1 ?>&search=<?= urlencode($search) ?>">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            </li>
            <?php endif; ?>

            <!-- First page + leading ellipsis -->
            <?php if ($currentPage > $range + 1): ?>
            <li class="indicator_item">
                <a href="?page=1&search=<?= urlencode($search) ?>">1</a>
            </li>
            <?php renderEllipsis(max(1, $currentPage - $jump), $search); ?>
            <?php endif; ?>

            <!-- Pages around current -->
            <?php
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

            <!-- Trailing ellipsis + last page -->
            <?php if ($currentPage < $totalPages - $range): ?>
            <?php renderEllipsis(min($totalPages, $currentPage + $jump), $search); ?>
            <li class="indicator_item">
                <a href="?page=<?= $totalPages ?>&search=<?= urlencode($search) ?>"><?= $totalPages ?></a>
            </li>
            <?php endif; ?>

            <!-- Next arrow -->
            <?php if ($currentPage < $totalPages): ?>
            <li class="indicator_item">
                <a href="?page=<?= $currentPage + 1 ?>&search=<?= urlencode($search) ?>">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <?php endif; ?>

</main>

<?php include 'footer.php'; ?>