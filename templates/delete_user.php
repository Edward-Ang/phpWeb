<?php
require('db_connect.php');

if (isset($_GET['username'])) {

    // Get username to be deleted
    $username=$_GET['username'];

    $query = "DELETE FROM users WHERE username='$username'";
    $result = mysqli_query($conn,$query) or die ( mysqli_error($conn));

    // Check if the query was executed successfully
    if (mysqli_query($conn, $query)) {
        // Record deleted successfully
        echo "User record deleted successfully.";
    } else {
        // Error occurred while deleting record
        echo "Error deleting record: " . mysqli_error($con);
    }

} else {
    // Username parameter not provided
    echo "Error: Username parameter not provided.";
}

// Process complete, when user click delete, redirect user to home page
header("Location: admin_db.php");
exit();
?>