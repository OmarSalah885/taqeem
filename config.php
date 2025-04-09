<?php
// Secure session settings
ini_set('session.cookie_httponly', 1); // Prevent JavaScript access to session cookies
ini_set('session.cookie_secure', 1);  // Use secure cookies (requires HTTPS)
ini_set('session.use_strict_mode', 1); // Prevent session fixation attacks
?>