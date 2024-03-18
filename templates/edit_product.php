<?php
session_start();
include_once 'db_connect.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $product_name = $row['product_name'];
        $description = $row['description'];
        $price = $row['price'];
        $category = $row['category'];
        $stock_level = $row['stock_level'];
        $image = $row['image'];

        // Remove "uploads/" directory from image path
        $image_path = str_replace('uploads/', '', $image);

        // Check if the image file exists
        if (file_exists($image_path)) {
            $image_url = $image;
        } else {
            $image_url = 'placeholder_image.jpg'; // Provide a placeholder image path
        }
    } else {
        $_SESSION['error_message'] = "Product not found.";
        header("Location: admin_dashboard.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Product ID not provided.";
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form action="update_product.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <label for="product_name">Product Name:</label><br>
        <input type="text" id="product_name" name="product_name" value="<?php echo $product_name; ?>" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50"><?php echo $description; ?></textarea><br>
        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" value="<?php echo $price; ?>" min="0" step="0.01" required><br>
        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category" value="<?php echo $category; ?>"><br>
        <label for="stock_level">Stock Level:</label><br>
        <input type="number" id="stock_level" name="stock_level" value="<?php echo $stock_level; ?>" min="0" required><br>
        <label for="image">Product Image:</label><br>
        <img src="<?php echo $image_url; ?>" alt="Product Image"><br>
        <input type="file" id="image" name="image"><br>
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
