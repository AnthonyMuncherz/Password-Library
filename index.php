<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // If logged in, redirect to the dashboard
    header('Location: dashboard.php');
} else {
    // If not logged in, redirect to the login page
    header('Location: login.php');
}
exit;
?> 