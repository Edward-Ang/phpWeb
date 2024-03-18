<?php
session_start();
// Include database connection file
include_once 'db_connect.php';

// Get username and password from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Sanitize user input to prevent SQL injection
$username = mysqli_real_escape_string($conn, $username);

// Query the database to check if the user exists
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    // Verify password
    if (password_verify($password, $row['password'])) {
        // Password is correct, set session variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        // Redirect to appropriate page based on role
        if ($_SESSION['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: user_dashboard.php");
        }
        exit();
    } else {
        // Incorrect password
        header("Location: login.php?error=incorrect");
        exit();
    }
} else {
    // User does not exist
    header("Location: login.php?error=notfound");
    exit();
}
?>
