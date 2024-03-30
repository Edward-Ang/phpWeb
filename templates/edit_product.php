<?php
session_start();
include_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the product data from the database based on the provided ID
    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        $_SESSION['error_message'] = "Product not found.";
        header("Location: product_list.php");
        exit();
    }

    $row = mysqli_fetch_assoc($result);

    // Pre-fill the form fields with the retrieved product data
    $product_name = $row['product_name'];
    $description = $row['description'];
    $price = $row['price'];
    $category = $row['category'];
    $stock_level = $row['stock_level'];
    $image_path = $row['image'];

    mysqli_free_result($result);
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock_level = $_POST['stock_level'];

    // Sanitize input data
    $product_name = mysqli_real_escape_string($conn, $product_name);
    $description = mysqli_real_escape_string($conn, $description);
    $price = floatval($price);
    $category = mysqli_real_escape_string($conn, $category);
    $stock_level = intval($stock_level);

    // Handle file upload for the new image
    if ($_FILES["image"]["size"] > 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_path = $target_file;
    }

    // Update the product in the database, including the image path if it has been changed
    $query = "UPDATE products SET product_name = '$product_name', description = '$description', price = $price, category = '$category', stock_level = $stock_level, image = '$image_path' WHERE id = $product_id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success_message'] = "Product updated successfully.";
        header("Location: product_list.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error updating product: " . mysqli_error($conn);
        header("Location: product_list.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Invalid request.";
    header("Location: product_list.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Product</title>
        <link rel="stylesheet" href="../css/edit_product.css">
    </head>
    <body>
        <h1>Edit Product</h1>
        <form action="edit_product.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <label for="product_name">Product Name:</label><br>
            <input type="text" id="product_name" name="product_name" value="<?php echo $product_name; ?>" required><br>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="4" cols="50" required><?php echo $description; ?></textarea><br>
            <label for="price">Price:</label><br>
            <input type="number" id="price" name="price" min="0" step="0.01" value="<?php echo $price; ?>" required><br>
            <label for="category">Category:</label><br>
            <input type="text" id="category" name="category" value="<?php echo $category; ?>"><br>
            <label for="stock_level">Stock Level:</label><br>
            <input type="number" id="stock_level" name="stock_level" min="0" value="<?php echo $stock_level; ?>" required><br>
            <label for="image">Product Image:</label><br>
            <input type="file" id="image" name="image"><br>
            <button type="submit">Update Product</button>
            <button type="button" class="cancel-btn" onclick="window.location.href='product_list.php'">Cancel</button>
        </form>
    </body>
</html>
