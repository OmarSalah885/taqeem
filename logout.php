<?php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header('Location: index.php?logout=success'); // Redirect to the homepage or login page
exit;
?>