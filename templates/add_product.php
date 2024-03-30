<?php
session_start();

// User authentication
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/add_product.css">
    </head>

    <body>
        <header class="site-header">
            <div class="header-container">
                <h1 class="site-title">Welcome <?php echo $_SESSION['username']; ?>!</h1>
                <nav class="site-navigation">
                    <ul>
                        <li><a href="admin_db.php">Home</a></li>
                        <li><a href="admin_dashboard.php">Product Management</a></li>
                        <li><a href="product_list.php">Product List</a></li>
                        <li><a href="add_product.php">Add Product</a></li>
                    </ul>
                </nav>
                <span class="logout-btn"><a href="logout.php">Logout</a></span>
            <div>
        </header>

        <div class="add-product-container">
            <div class="add-product-header">
                <span>Add New Product</span>
            </div>
            <div class="add-product-body">
                <form action="create_product.php" method="post" enctype="multipart/form-data">
                    <label for="product_name">Product Name:</label><br>
                    <input type="text" id="product_name" name="product_name" required><br>
                    <label for="description">Description:</label><br>
                    <textarea id="description" name="description" rows="4" cols="50"></textarea><br>
                    <label for="price">Price:</label><br>
                    <input type="number" id="price" name="price" min="0" step="0.01" required><br>
                    <label for="category">Category:</label><br>
                    <input type="text" id="category" name="category"><br>
                    <label for="stock_level">Stock Level:</label><br>
                    <input type="number" id="stock_level" name="stock_level" min="0" required><br>
                    <label for="image">Product Image:</label><br>
                    <input type="file" id="image" name="image"><br>
                    <button type="submit">Create Product</button>
                    <button type="button" class="cancel-btn" onclick="window.location.href='product_list.php'">Cancel</button>
                </form>
            </div>
        </div>
    </body>
</html>