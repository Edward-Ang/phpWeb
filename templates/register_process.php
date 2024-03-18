<?php
session_start();
// Include database connection file
include_once 'db_connect.php';

// Get form data
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$role = $_POST['role'];

// Validate form data
if (empty($username) || empty($password) || empty($confirm_password)) {
    header("Location: register.php?error=emptyfields&username=".$username."&role=".$role);
    exit();
} elseif ($password !== $confirm_password) {
    header("Location: register.php?error=passwordcheck&username=".$username."&role=".$role);
    exit();
}

// Check if username already exists
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    header("Location: register.php?error=usertaken&role=".$role);
    exit();
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
$query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
if (mysqli_query($conn, $query)) {
    header("Location: login.php?registration=success");
    exit();
} else {
    header("Location: register.php?error=sqlerror");
    exit();
}
?>
