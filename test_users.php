<?php
include 'db_connect.php';

$sql = "SELECT id, first_name, email FROM users"; // Adjust column names if different
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Username: " . $row["username"] . " - Email: " . $row["email"] . "<br>";
    }
} else {
    echo "No users found.";
}
?>
