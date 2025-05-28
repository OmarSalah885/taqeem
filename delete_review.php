<?php
require_once 'config.php';
require_once 'db_connect.php';


// Helper: delete files safely
function deleteFiles(array $paths) {
    foreach ($paths as $p) {
        $full = __DIR__ . '/' . ltrim($p, '/');
        if (file_exists($full)) {
            @unlink($full);
        }
    }
}

// Determine review ID and mode
$isAdmin = isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'admin';
$userId  = $_SESSION['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $isAdmin && isset($_GET['id'])) {
    // Admin path: delete via GET?id=…
    $reviewId = (int)$_GET['id'];
    $jsonMode = false;
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_id'])) {
    // Owner or admin via POST
    $reviewId = (int)$_POST['review_id'];
    $jsonMode = true;
}
else {
    // Invalid access
    if (php_sapi_name() === 'cli' || headers_sent()) {
        exit('Access denied');
    }
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
    exit('Access denied');
}

// Fetch review owner
$stmt = $conn->prepare("SELECT user_id FROM reviews WHERE id = ?");
$stmt->bind_param("i", $reviewId);
$stmt->execute();
$stmt->bind_result($ownerId);
if (!$stmt->fetch()) {
    $stmt->close();
    if ($jsonMode) {
        header('Content-Type: application/json');
        echo json_encode(['success'=>false,'error'=>'Review not found']);
    } else {
        header('Location: admin_reviews.php?error=notfound');
    }
    exit;
}
$stmt->close();

// Authorization: admin can delete any, owner only their own
if (!$isAdmin && $ownerId !== $userId) {
    if ($jsonMode) {
        header('Content-Type: application/json');
        echo json_encode(['success'=>false,'error'=>'Unauthorized']);
    } else {
        header('Location: admin_reviews.php?error=unauthorized');
    }
    exit;
}

// 1) Gather image URLs
$images = [];
$stmt = $conn->prepare("
    SELECT image_url
      FROM review_images
     WHERE review_id = ?
");
$stmt->bind_param("i", $reviewId);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $images[] = $row['image_url'];
}
$stmt->close();

// 2) Delete from DB inside transaction
$conn->begin_transaction();
try {
    // review_images
    $d1 = $conn->prepare("DELETE FROM review_images WHERE review_id = ?");
    $d1->bind_param("i", $reviewId);
    $d1->execute();
    $d1->close();

    // review_comments (if exists)
    $d2 = $conn->prepare("DELETE FROM review_comments WHERE review_id = ?");
    $d2->bind_param("i", $reviewId);
    $d2->execute();
    $d2->close();

    // reviews
    $d3 = $conn->prepare("DELETE FROM reviews WHERE id = ?");
    $d3->bind_param("i", $reviewId);
    $d3->execute();
    $d3->close();

    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
    if ($jsonMode) {
        header('Content-Type: application/json');
        echo json_encode(['success'=>false,'error'=>'DB error']);
    } else {
        header('Location: admin_reviews.php?error=db');
    }
    exit;
}

// 3) Delete image files
deleteFiles($images);

// 4) Respond or redirect
if ($jsonMode) {
    header('Content-Type: application/json');
    echo json_encode(['success'=>true]);
} else {
    header('Location: admin_reviews.php?msg=deleted');
}
exit;
