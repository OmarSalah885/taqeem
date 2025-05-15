<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

// Redirect if not admin
if (empty($_SESSION['role']) || strtolower(trim($_SESSION['role'])) !== 'admin') {
    header('Location: index.php');
    exit;
}

// Fetch admin user details
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT first_name, last_name, email, profile_image, location FROM users WHERE id = ?");
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($firstName, $lastName, $email, $profileImage, $location);
$stmt->fetch();
$stmt->close();

// Fallbacks
$profileImage = $profileImage ?: 'assets/images/profiles/pro_null.png';
$location = $location ?: 'Unknown Location';

// Fetch dashboard counts
function fetchCount($conn, $table) {
    $count = 0;
    if ($stmt = $conn->prepare("SELECT COUNT(*) FROM $table")) {
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
    }
    return $count;
}

$userCount   = fetchCount($conn, 'users');
$placeCount  = fetchCount($conn, 'places');
$reviewCount = fetchCount($conn, 'reviews');
$blogCount   = fetchCount($conn, 'blogs');

include 'header.php';
?>
<main class="profile admin_main">
    <div class="profile_sidebar">
        <div class="profile_sidebar--img">
            <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="Admin Profile">
        </div>
        <div class="profile_sidebar--info">
            <h3 class="name"><?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></h3>
            <a href="mailto:<?php echo htmlspecialchars($email); ?>"><?php echo htmlspecialchars($email); ?></a>
            <h2 class="location"><?php echo htmlspecialchars($location); ?></h2>
        </div>
        <a href="logout.php" class="btn__transparent--l btn__transparent btn">LOGOUT</a>
    </div>
    <div class="profile_main">
        <div class="profile_main_collection">
            <h2 class="profile_title">Admin Dashboard</h2>
            <div class="admin_container">
                <div class="admin_card admin_users">
                    <h1>USERS <span><?php echo $userCount; ?></span></h1>
                    <a href="admin_users.php">View all users</a>
                </div>
                <div class="admin_card admin_places">
                    <h1>PLACES <span><?php echo $placeCount; ?></span></h1>
                    <a href="admin_places.php">View all places</a>
                </div>
                <div class="admin_card admin_reviews">
                    <h1>REVIEWS <span><?php echo $reviewCount; ?></span></h1>
                    <a href="admin_reviews.php">View all reviews</a>
                </div>
                <div class="admin_card admin_blogs">
                    <h1>BLOGS <span><?php echo $blogCount; ?></span></h1>
                    <a href="admin_blogs.php">View all blogs</a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>
