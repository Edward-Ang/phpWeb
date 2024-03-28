<?php
session_start();

// Ensure user authentication
if (!isset($_SESSION['user_id'])) {
    // You may handle unauthorized access here, redirecting to login page or displaying an error message
    exit("Unauthorized access");
}

// Include database connection
include_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    
    // Check if the product is already in the user's favorites
    $isFavorite = in_array($productId, $_SESSION['favorite_products']);
    
    if ($isFavorite) {
        // Remove from favorites
        $index = array_search($productId, $_SESSION['favorite_products']);
        unset($_SESSION['favorite_products'][$index]);
        
        // Delete record from user_favorites table
        $userId = $_SESSION['user_id'];
        $deleteQuery = "DELETE FROM user_favorites WHERE user_id = $userId AND product_id = $productId";
        mysqli_query($conn, $deleteQuery);
        
        echo 'removed';
    } else {
        // Add to favorites
        $_SESSION['favorite_products'][] = $productId;
        
        // Insert record into user_favorites table
        $userId = $_SESSION['user_id'];
        $insertQuery = "INSERT INTO user_favorites (user_id, product_id) VALUES ($userId, $productId)";
        mysqli_query($conn, $insertQuery);
        
        echo 'added';
    }
} else {
    // Handle invalid request method or missing product ID
    echo 'error';
}

// Close database connection
mysqli_close($conn);
?>
