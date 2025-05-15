<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

// 1) Only admins
if (empty($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header('Location: index.php');
    exit;
}

// 2) Handle search
$search      = trim($_GET['search'] ?? '');
$searchParam = "%{$search}%";

// 3) Pagination setup
$perPage = 25;
$page    = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $perPage;

// 4) Count total blogs (with optional search on title, tags, created_at)
$countSql     = "SELECT COUNT(*) FROM blogs";
$whereClauses = [];
$params       = [];
$types        = '';

if ($search !== '') {
    $whereClauses[] = "(
        title LIKE ? OR
        tags LIKE ? OR
        DATE(created_at) LIKE ?
    )";
    array_push($params,
        $searchParam,  // title
        $searchParam,  // tags
        $searchParam   // created_at
    );
    $types .= str_repeat('s', 3);
}

if (!empty($whereClauses)) {
    $countSql .= ' WHERE ' . implode(' AND ', $whereClauses);
}

$countStmt = $conn->prepare($countSql);
if (!empty($whereClauses)) {
    $countStmt->bind_param($types, ...$params);
}
$countStmt->execute();
$countStmt->bind_result($totalBlogs);
$countStmt->fetch();
$countStmt->close();

$totalPages = (int)ceil($totalBlogs / $perPage);

// 5) Fetch page of blogs
$baseSql = "
    SELECT id, image, title, tags, content, created_at
    FROM blogs
";
if (!empty($whereClauses)) {
    $baseSql .= ' WHERE ' . implode(' AND ', $whereClauses);
}
$offsetInt  = (int)$offset;
$perPageInt = (int)$perPage;
$baseSql   .= " ORDER BY id ASC LIMIT {$offsetInt}, {$perPageInt}";

$stmt = $conn->prepare($baseSql);
if (!empty($whereClauses)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$blogs = $stmt->get_result();
$stmt->close();

include 'header.php';
?>

<main class="admin_main">
    <h1>Blog Management</h1>

    <form method="GET" action="" class="search-container">
        <input
          type="text"
          id="blogSearch"
          name="search"
          placeholder="Search by title, tags, or date..."
          value="<?php echo htmlspecialchars($search); ?>"
        >
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
while ($blog = $blogs->fetch_assoc()):
?>
                <tr>
                    <td><?php echo $rowNum++; ?></td>
                    <td>
                        <img
                          src="<?php echo htmlspecialchars($blog['image'] ?: 'assets/images/blogs/placeholder.png'); ?>"
                          alt="Blog Image"
                          width="80"
                          height="50"
                        >
                    </td>
                    <td><?php echo htmlspecialchars($blog['title']); ?></td>
                    <td><?php echo htmlspecialchars($blog['tags']); ?></td>
                    <td><?php echo htmlspecialchars(mb_strimwidth($blog['content'],0,50,'…')); ?></td>
                    <td><?php echo htmlspecialchars(substr($blog['created_at'],0,10)); ?></td>
                    <td class="actions">
                        <a href="edit_blog.php?id=<?= $blog['id'] ?>" class="btn-edit">Edit</a>

                        <a href="delete_blog.php?id=<?php echo $blog['id']; ?>" class="btn-delete"
                           onclick="return confirm('Delete this blog?');">Delete</a>
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
