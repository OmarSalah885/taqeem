<?php
include 'config.php';
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get form fields
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$about_me = $_POST['about_me'] ?? '';
$gender = $_POST['gender'] ?? '';
$visibility = $_POST['visibility'] ?? '';
$location = $_POST['location'] ?? '';

// Fetch current profile image
$stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$current_image = $user['profile_image'] ?? 'assets/images/profiles/pro_null.png';
$default_image = 'assets/images/profiles/pro_null.png';
$new_image_path = $current_image;

// Handle delete image
if (isset($_POST['delete_image']) && $_POST['delete_image'] == 'on') {
    // Delete the current profile image from the server
    $stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $profile_image_path = $user['profile_image'];

    // Only delete if the profile image exists and is not the default one
    if ($profile_image_path !== $default_image && file_exists($profile_image_path)) {
        unlink($profile_image_path); // Delete the image file
    }

    // Set profile image to default
    $new_image_path = $default_image;

    // Update session profile image
    $_SESSION['profile_image'] = $default_image;
}

// Handle image upload if provided
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['profile_image'];
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    $maxSize = 2 * 1024 * 1024; // 2MB
    $fileType = mime_content_type($image['tmp_name']);
    $fileSize = $image['size'];

    if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
        $tmpName = $image['tmp_name'];
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' . $ext;
        $targetDir = 'assets/images/profiles/';
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($tmpName, $targetFile)) {
            // Delete old image if not default
            if ($current_image !== $default_image && file_exists($current_image)) {
                unlink($current_image); // Remove the old image file
            }

            $new_image_path = $targetFile; // Set new image path
            $_SESSION['profile_image'] = $new_image_path; // Update the session with the new image
        }
    } else {
        echo "<script>alert('Invalid file type or file too large. Only JPG, JPEG, PNG under 2MB are allowed.');</script>";
    }
}

// Update all profile fields including new image
$update = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, about_me = ?, gender = ?, visibility = ?, location = ?, profile_image = ? WHERE id = ?");
$update->bind_param("sssssssi", $first_name, $last_name, $about_me, $gender, $visibility, $location, $new_image_path, $user_id);

if ($update->execute()) {
    // Update session variables for the name
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;

    $update->close();
    $_SESSION['success'] = "Profile updated successfully!";
    header("Location: edit-profile.php"); // Refresh the page to reflect changes
    exit();
} else {
    echo "Error updating profile: " . $conn->error;
    $update->close();
}
?>
