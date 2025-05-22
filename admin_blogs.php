<?php
require_once 'config.php';
require_once 'db_connect.php';

session_start();

// 1) Only admins can access
if (empty($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header('Location: index.php');
    exit;
}

// 2) Handle search input
$search = trim($_GET['search'] ?? '');
$searchParam = "%{$search}%";

// 3) Pagination setup
$perPage = 25;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $perPage;

// 4) Build WHERE clauses and parameters for search
$whereClauses = [];
$params = [];
$types = '';

if ($search !== '') {
    // Use OR between columns inside one big parentheses
    $whereClauses[] = "(title LIKE ? OR tags LIKE ? OR created_at LIKE ?)";
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= 'sss';
}

// 5) Count total matching blogs
$countSql = "SELECT COUNT(*) FROM blogs";
if (!empty($whereClauses)) {
    $countSql .= ' WHERE ' . implode(' AND ', $whereClauses);
}

$countStmt = $conn->prepare($countSql);
if ($countStmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

if (!empty($whereClauses)) {
    $bindNames = [];
    $bindNames[] = & $types;
    for ($i = 0; $i < count($params); $i++) {
        $bindNames[] = & $params[$i];
    }
    call_user_func_array([$countStmt, 'bind_param'], $bindNames);
}

$countStmt->execute();
$countStmt->bind_result($totalBlogs);
$countStmt->fetch();
$countStmt->close();

$totalPages = (int)ceil($totalBlogs / $perPage);

// 6) Fetch blogs for current page
$baseSql = "SELECT id, image, title, tags, content, created_at FROM blogs";
if (!empty($whereClauses)) {
    $baseSql .= ' WHERE ' . implode(' AND ', $whereClauses);
}
$baseSql .= " ORDER BY id ASC LIMIT ?, ?";

// Bind params (replace LIMIT placeholders directly because LIMIT can't be parameterized)
$stmt = $conn->prepare(str_replace('?, ?', (int)$offset . ', ' . (int)$perPage, $baseSql));
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

if (!empty($whereClauses)) {
    $bindNames = [];
    $bindNames[] = & $types;
    for ($i = 0; $i < count($params); $i++) {
        $bindNames[] = & $params[$i];
    }
    call_user_func_array([$stmt, 'bind_param'], $bindNames);
}

$stmt->execute();
$blogs = $stmt->get_result();
$stmt->close();

include 'header.php';
?>

<main class="admin_main">
    <h1>Blog Management</h1>

    <form method="GET" action="" class="search-container">
        <input type="text" id="blogSearch" name="search" placeholder="Search by title, tags, or date..."
            value="<?php echo htmlspecialchars($search, ENT_QUOTES); ?>">
        <button type="submit">Search</button>
    </form>

    <div class="table-container">
        <a href="add-blog.php" class="btn__red--l btn__red btn">ADD BLOG</a>
        <table id="blogTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Tags</th>
                    <th>Content</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
$rowNum = $offset + 1;
if ($blogs->num_rows > 0):
    while ($blog = $blogs->fetch_assoc()):
        $blogId = (int)$blog['id'];
        $image = $blog['image'] ?: 'assets/images/blogs/placeholder.png';
        $title = $blog['title'] ?: 'Untitled';
        $tags = $blog['tags'] ?: 'None';
        $content = $blog['content'] ? mb_strimwidth(strip_tags($blog['content']), 0, 50, '…') : 'No content';
        $created_at = $blog['created_at'] ? substr($blog['created_at'], 0, 10) : 'Unknown';
?>
                <tr>
                    <td><?php echo $rowNum++; ?></td>
                    <td>
                        <a href="single-blog.php?id=<?php echo $blogId; ?>">
                            <img src="<?php echo htmlspecialchars($image, ENT_QUOTES); ?>"
                                alt="Blog Image" width="80" height="50">
                        </a>
                    </td>
                    <td>
                        <a href="single-blog.php?id=<?php echo $blogId; ?>" class="admins_links">
                            <?php echo htmlspecialchars($title, ENT_QUOTES); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($tags, ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($content); ?></td>
                    <td><?php echo htmlspecialchars($created_at, ENT_QUOTES); ?></td>
                    <td class="actions">
                        <a href="edit_blog.php?id=<?php echo $blogId; ?>" class="btn-edit">Edit</a>
                        <a href="delete_blog.php?id=<?php echo $blogId; ?>" class="btn-delete"
                            onclick="return confirm('Delete this blog?');">Delete</a>
                    </td>
                </tr>
                <?php
    endwhile;
else:
?>
                <tr>
                    <td colspan="7" style="text-align:center;">No blogs found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="listing_indicator">
        <?php
$range = 2;   // pages to show on each side of current
$jump = 3;    // pages to jump when clicking "…"

function renderEllipsis(int $targetPage, string $search) {
    echo '<li class="indicator_item ellipsis">';
    echo '<a href="?page=' . $targetPage . '&search=' . urlencode($search) . '">…</a>';
    echo '</li>';
}

$currentPage = $page;

if ($totalPages > 1):
?>
        <ul class="listing_indicator">
            <!-- Previous arrow -->
            <?php if ($currentPage > 1): ?>
            <li class="indicator_item">
                <a href="?page=<?php echo $currentPage - 1; ?>&search=<?php echo urlencode($search); ?>">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            </li>
            <?php endif; ?>

            <!-- First page + leading ellipsis -->
            <?php if ($currentPage > $range + 1): ?>
            <li class="indicator_item">
                <a href="?page=1&search=<?php echo urlencode($search); ?>">1</a>
            </li>
            <?php renderEllipsis(max(1, $currentPage - $jump), $search); ?>
            <?php endif; ?>

            <!-- Pages around current -->
            <?php
    $start = max(1, $currentPage - $range);
    $end = min($totalPages, $currentPage + $range);
    for ($i = $start; $i <= $end; $i++): ?>
            <li class="indicator_item <?php echo $i === $currentPage ? 'active' : ''; ?>">
                <?php if ($i === $currentPage): ?>
                <a href="javascript:void(0)"><?php echo $i; ?></a>
                <?php else: ?>
                <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            </li>
            <?php endfor; ?>

            <!-- Trailing ellipsis + last page -->
            <?php if ($currentPage < $totalPages - $range): ?>
            <?php renderEllipsis(min($totalPages, $currentPage + $jump), $search); ?>
            <li class="indicator_item">
                <a
                    href="?page=<?php echo $totalPages; ?>&search=<?php echo urlencode($search); ?>"><?php echo $totalPages; ?></a>
            </li>
            <?php endif; ?>

            <!-- Next arrow -->
            <?php if ($currentPage < $totalPages): ?>
            <li class="indicator_item">
                <a href="?page=<?php echo $currentPage + 1; ?>&search=<?php echo urlencode($search); ?>">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </li>
            <?php endif; ?>
        </ul>
        <?php endif; ?>
    </div>
</main>

<?php include 'footer.php'; ?>