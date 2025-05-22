<?php
require_once 'config.php';
require_once 'db_connect.php';

function getAllImagesFromDB($conn) {
    $dbImages = [];

    // Featured images
    $result = $conn->query("SELECT featured_image FROM places WHERE featured_image IS NOT NULL");
    while ($row = $result->fetch_assoc()) {
        $dbImages[] = $row['featured_image'];
    }

    // Gallery images
    $result = $conn->query("SELECT image_url FROM place_gallery");
    while ($row = $result->fetch_assoc()) {
        $dbImages[] = $row['image_url'];
    }

    // Menu images
    $result = $conn->query("SELECT image FROM menu_items");
    while ($row = $result->fetch_assoc()) {
        $dbImages[] = $row['image'];
    }

    return array_unique($dbImages);
}

function getAllImageFilesFromDisk($baseDir = 'assets/images/places') {
    $allFiles = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($baseDir));

    foreach ($iterator as $file) {
        if ($file->isFile() && preg_match('/\.(jpg|jpeg|png|webp|gif)$/i', $file->getFilename())) {
            $path = str_replace('\\', '/', $file->getPathname());
            $relative = str_replace('C:/xampp/htdocs/taqeem/', '', $path); // Adjust for your base path
            $allFiles[] = $relative;
        }
    }

    return $allFiles;
}

// Run diagnostics
$dbImages = getAllImagesFromDB($conn);
$diskImages = getAllImageFilesFromDisk();

$dbImagesSet = array_flip($dbImages);
$diskImagesSet = array_flip($diskImages);

// 1. DB references missing from disk
$missingFiles = array_diff($dbImages, $diskImages);

// 2. Disk files not referenced in DB
$orphanedFiles = array_diff($diskImages, $dbImages);

echo "<h2>🛑 Images in DB but Missing on Disk:</h2><ul>";
foreach ($missingFiles as $img) {
    echo "<li>$img</li>";
}
echo "</ul>";

echo "<h2>🧹 Files on Disk not Referenced in DB:</h2><ul>";
foreach ($orphanedFiles as $img) {
    echo "<li>$img</li>";
}
echo "</ul>";
