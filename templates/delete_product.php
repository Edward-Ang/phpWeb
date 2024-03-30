<?php
session_start();
include_once 'db_connect.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch image path before deleting product
    $query = "SELECT image FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $image_path = $row['image'];

    $query = "DELETE FROM products WHERE id = $product_id";
    if (mysqli_query($conn, $query)) {
        // Delete associated image file
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        $_SESSION['success_message'] = "Product deleted successfully.";
        header("Location: product_list.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error deleting product: " . mysqli_error($conn);
        header("Location: product_list.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Product ID not provided.";
    header("Location: product_list.php");
    exit();
}
?>
