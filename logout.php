<?php
include('connexion.php');
// Start the session
session_start();

// Destroy session variables
session_unset();

// Destroy the session
session_destroy();

// Clear the 'Remember Me' cookies if they exist
if (isset($_COOKIE['user_id']) && isset($_COOKIE['email'])) {
    setcookie('user_id', '', time() - 3600, '/');  // Expire the cookie
    setcookie('email', '', time() - 3600, '/');     // Expire the cookie
}

// Redirect to the login page after logging out
header('Location: login.php');
exit();
?>
