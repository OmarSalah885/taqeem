<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "sql113.infinityfree.com";
$dbname = "if0_38497686_teqeem";
$username = "if0_38497686";
$password = "bh55ioWpTbXLr";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully!";
?>
