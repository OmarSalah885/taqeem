<?php
// Include the database connection file
include 'db_connect.php'; 

// Fetch all users from the database
$query = "SELECT id, password FROM users";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($user = $result->fetch_assoc()) {
        // Hash the user's password using password_hash
        $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);

        // Update the password in the database with the hashed password
        $update_query = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("si", $hashed_password, $user['id']);
        $stmt->execute();

        // You can also print a message to confirm each password is hashed if desired
        // echo "Password for user ID {$user['id']} has been updated to hashed version.<br>";
    }

    echo "All passwords have been successfully hashed and updated.<br>";
} else {
    echo "No users found to update.<br>";
}

$stmt->close();
$conn->close();
?>
