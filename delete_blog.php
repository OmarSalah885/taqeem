<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

if (empty($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header('Location: index.php');
    exit;
}

$blog_id = $_GET['id'] ?? null;

if (!$blog_id || !is_numeric($blog_id)) {
    die("Invalid blog ID.");
}

// Fetch blog info (to remove image/folder)
$stmt = $conn->prepare("SELECT title, image FROM blogs WHERE id = ?");
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$stmt->bind_result($title, $image);
if (!$stmt->fetch()) {
    $stmt->close();
    die("Blog not found.");
}
$stmt->close();

// Normalize title for folder name
$folder_name = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $title)));
$folder_path = __DIR__ . "/assets/images/blogs/$folder_name";

// Delete image if exists
if (!empty($image)) {
    $image_path = __DIR__ . '/' . $image;
    if (file_exists($image_path)) {
        unlink($image_path);
    }
}

// Delete folder recursively
function deleteDirectory($dir) {
    if (!file_exists($dir)) return;
    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        $path = "$dir/$file";
        is_dir($path) ? deleteDirectory($path) : unlink($path);
    }
    rmdir($dir);
}
deleteDirectory($folder_path);

// Delete blog from DB
$delete = $conn->prepare("DELETE FROM blogs WHERE id = ?");
$delete->bind_param("i", $blog_id);
$delete->execute();
$delete->close();

header("Location: admin_blogs.php?deleted=1");
exit;
?>
