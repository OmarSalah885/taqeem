<?php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
echo "Session data cleared. You can now test login and logout functionality.";
?>