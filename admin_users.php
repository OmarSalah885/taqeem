<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

// Ensure only admins
if (empty($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header('Location: index.php');
    exit;
}

// Handle search query
$search = trim($_GET['search'] ?? '');
$searchParam = "%{$search}%";

// Pagination setup
$perPage = 25;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $perPage;

// Fetch total user count with search filter
$countSql = "SELECT COUNT(*) FROM users";
$whereClauses = [];
$params = [];
$types = '';

if ($search !== '') {
    $whereClauses[] = "("
        . "CAST(id AS CHAR) LIKE ? OR "
        . "first_name LIKE ? OR "
        . "last_name LIKE ? OR "
        . "email LIKE ? OR "
        . "gender = ? OR "
        . "role = ? OR "
        . "location LIKE ? OR "
        . "DATE(created_at) LIKE ? OR "
        . "visibility LIKE ?"
    . ")";
    
    $params[] = $searchParam; // id
    $params[] = $searchParam; // first_name
    $params[] = $searchParam; // last_name
    $params[] = $searchParam; // email
    $params[] = $search;      // gender exact
    $params[] = $search;      // role exact
    $params[] = $searchParam; // location
    $params[] = $searchParam; // created_at
    $params[] = $searchParam; // visibility

    $types = str_repeat('s', 9);
}



if (!empty($whereClauses)) {
    $countSql .= ' WHERE ' . implode(' AND ', $whereClauses);
}

$countStmt = $conn->prepare($countSql);
if (!empty($whereClauses)) {
    $countStmt->bind_param($types, ...$params);
}
$countStmt->execute();
$countStmt->bind_result($totalUsers);
$countStmt->fetch();
$countStmt->close();

// Calculate total pages
$totalPages = (int)ceil($totalUsers / $perPage);
// … earlier code unchanged …

// Build base SQL with WHERE if needed
$baseSql = "
    SELECT id, profile_image, first_name, last_name, email,
           gender, about_me, location, role, created_at, visibility
    FROM users
";
if (!empty($whereClauses)) {
    $baseSql .= ' WHERE ' . implode(' AND ', $whereClauses);
}

// ** Append ORDER BY and LIMIT directly — no binding for LIMIT/offset **
$offsetInt  = (int)$offset;
$perPageInt = (int)$perPage;
$baseSql   .= " ORDER BY id ASC LIMIT {$offsetInt}, {$perPageInt}";

$userStmt = $conn->prepare($baseSql);
if (!empty($whereClauses)) {
    // bind only the search parameters here
    $userStmt->bind_param($types, ...$params);
}

$userStmt->execute();
$users = $userStmt->get_result();
$userStmt->close();


include 'header.php';
?>

<main class="users admin_main">
    <h1>User Management</h1>

    <form method="GET" action="" class="search-container">
        <input
          type="text"
          id="userSearch"
          name="search"
          placeholder="Search by name, email, or ID..."
          value="<?php echo htmlspecialchars($search); ?>"
        >
        <button type="submit">Search</button>
    </form>

    <div class="table-container">
        <table id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>About Me</th>
                    <th>Location</th>
                    <th>Role</th>
                    <th>Account Created</th>
                    <th>Visibility</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
<?php while ($user = $users->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td>
                        <img
                            src="<?php echo htmlspecialchars($user['profile_image'] ?: 'assets/images/profiles/pro_null.png'); ?>"
                            alt="User Image"
                            width="50"
                            height="50"
                        >
                    </td>
                    <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['gender']); ?></td>
                    <td><?php echo htmlspecialchars($user['about_me']); ?></td>
                    <td><?php echo htmlspecialchars($user['location']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td><?php echo htmlspecialchars(substr($user['created_at'], 0, 10)); ?></td>
                    <td>
                        <span class="badge <?php echo $user['visibility'] === 'public' ? 'public' : 'private'; ?>">
                            <?php echo htmlspecialchars($user['visibility']); ?>
                        </span>
                    </td>
                    <td class="actions">
                        <a href="edit-profile.php?user_id=<?php echo $user['id']; ?>" class="btn-edit">Edit</a>
                        <a href="delete_account.php?id=<?php echo $user['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>

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
                    <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
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
