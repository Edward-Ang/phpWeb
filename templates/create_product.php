<?php
session_start();
include_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock_level = $_POST['stock_level'];

    $product_name = mysqli_real_escape_string($conn, $product_name);
    $description = mysqli_real_escape_string($conn, $description);
    $price = floatval($price);
    $category = mysqli_real_escape_string($conn, $category);
    $stock_level = intval($stock_level);

    // File upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    $image_path = $target_file;

    $query = "INSERT INTO products (product_name, description, price, category, stock_level, image) VALUES ('$product_name', '$description', $price, '$category', $stock_level, '$image_path')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success_message'] = "Product created successfully.";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error creating product: " . mysqli_error($conn);
        header("Location: admin_dashboard.php");
        exit();
    }
}
?>
