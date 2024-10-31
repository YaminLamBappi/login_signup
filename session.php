<?php
session_start();

$timeout_duration = 1800; // Set timeout duration in seconds (e.g., 30 minutes)

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    // Session has expired
    session_unset(); // Unset session variables
    session_destroy(); // Destroy the session
    header("Location: logout.php"); // Redirect to logout page or login page
    exit();
}

$_SESSION['last_activity'] = time(); // Update last activity time



?>