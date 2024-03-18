<?php
// Database configuration
$host = 'localhost'; // Change this if your database is hosted elsewhere
$username = 'root';
$password = '';
$database = 'assignment_db';

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
