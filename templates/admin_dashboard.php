
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome to the Admin Dashboard</h1>
    
    <h2>Create New Product</h2>
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
    </form>
    
    <hr>
    
    <h2>Edit Product</h2>
    <!-- Display a list of existing products with edit links -->
    <ul>
        <?php
        include_once 'db_connect.php';
        $query = "SELECT * FROM products";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li><a href='edit_product.php?id=" . $row['id'] . "'>" . $row['product_name'] . "</a></li>";
            }
        } else {
            echo "<li>No products found</li>";
        }
        ?>
    </ul>
    
    <hr>
    
    <h2>Delete Product</h2>
    <!-- Display a list of existing products with delete links -->
    <ul>
        <?php
        if (mysqli_num_rows($result) > 0) {
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>" . $row['product_name'] . " <a href='delete_product.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a></li>";
            }
        } else {
            echo "<li>No products found</li>";
        }
        ?>
    </ul>
</body>
</html>
