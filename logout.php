<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
}

// Redirect to the login page or home page
header("Location:index.php");
exit();
?>
