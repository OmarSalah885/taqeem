<?php
include 'db_connect.php'; // Include your database connection

// Define the plain-text password that all users currently have
$plain_password = 'password123';

// Hash the password
$hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

// Update all users' passwords in the database
$stmt = $conn->prepare("UPDATE users SET password = ?");
$stmt->bind_param("s", $hashed_password);

if ($stmt->execute()) {
    echo "All user passwords have been updated successfully.";
} else {
    echo "Error updating passwords: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>