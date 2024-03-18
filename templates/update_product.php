<?php
session_start();
include_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
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
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_path = $target_file;

        // Update product with new image
        $query = "UPDATE products SET product_name = '$product_name', description = '$description', price = $price, category = '$category', stock_level = $stock_level, image = '$image_path' WHERE id = $product_id";
    } else {
        // Update product without changing image
        $query = "UPDATE products SET product_name = '$product_name', description = '$description', price = $price, category = '$category', stock_level = $stock_level WHERE id = $product_id";
    }

    if (mysqli_query($conn, $query)) {
        $_SESSION['success_message'] = "Product updated successfully.";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error updating product: " . mysqli_error($conn);
        header("Location: admin_dashboard.php");
        exit();
    }
}
?>
