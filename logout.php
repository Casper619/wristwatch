<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear user_id cookie
if(isset($_COOKIE['user_id'])) {
    // Set cookie to expire in the past
    setcookie('user_id', '', time() - 3600, '/');
}

// Clear any session data
$_SESSION = array();
session_destroy();

// Redirect to home page
header("Location: index.php");
exit;
?> 

