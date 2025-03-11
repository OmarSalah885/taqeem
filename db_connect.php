<?php
$host = "sql113.infinityfree.com";  // Your MySQL hostname
$username = "if0_38497686";        // Your MySQL username
$password = "bh55ioWpTbXLr";       // Your MySQL password
$database = "if0_38497686_teqeem"; // Your MySQL database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";
?>
