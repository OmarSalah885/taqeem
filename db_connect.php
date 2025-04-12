<?php
$servername = "localhost";
$username = "root";
$db_password = "";
$database = "taqeem";

$conn = new mysqli($servername, $username, $db_password, $database);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}