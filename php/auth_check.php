<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../pages/login.php");
    exit();
}


?>