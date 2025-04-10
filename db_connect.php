<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "taqeem";

$conn = new mysqli($servername, $username, $password, $database,3307);
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}