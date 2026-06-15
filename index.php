<?php
session_start();

/*
|--------------------------------------------------------------------------
| Index Page (Entry Point)
|--------------------------------------------------------------------------
| Checks if the user is logged in and redirects accordingly
*/

if (isset($_SESSION['user_id'])) {
    // User logged in -> redirect to dashboard
    header("Location: dashboard.php");
    exit;
} else {
    // User not logged in -> redirect to login page
    header("Location: auth/login.php");
    exit;
}