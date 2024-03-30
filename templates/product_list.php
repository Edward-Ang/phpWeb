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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/product_list.css">
        <style>
            .product-list-container .delete-btn {
                background-color: red; /* Set background color to red */
                border: none; /* Remove border */
                padding: 8px;
                border-radius: 5px;
            }

            .product-list-container .delete-btn:hover {
                background-color: darkred; /* Change background color on hover */
                cursor: pointer;
            }

            .product-list-container .delete-btn i {
                color: white; /* Set icon color to white */
                font-size: 16px; /* Adjust icon size if needed */
            }
        </style>
    </head>

    <body>
        <header class="site-header">
            <div class="header-container">
                <h1 class="site-title">Welcome <?php echo $_SESSION['username']; ?>!</h1>
                <nav class="site-navigation">
                    <ul>
                        <li><a href="admin_db.php">User Management</a></li>
                        <li><a href="product_list.php">Product Management</a></li>
                    </ul>
                </nav>
                <span class="logout-btn"><a href="logout.php">Logout</a></span>
            </div>
        </header>

        <div class="product-list-container">
            <div class="product-list-header">
                <span>Product List</span>
            </div>
            <div class="product-list-body">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Stock Quantity</th>
                            <th>Last Modified</th>
                            <th colspan="2">Modification</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require('db_connect.php');

                        $sql_query = "SELECT * FROM products";
                        $result = mysqli_query($conn, $sql_query);
                        $counter = 1;

                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $counter ?></td>
                                <td><?php echo $row['product_name'] ?></td>
                                <td><?php echo $row['stock_level'] ?></td>
                                <td><?php echo $row['updated_at'] ?></td>
                                <!--<td><a href="edit_product_process.php?id=<?php echo $row["id"]; ?>">Edit</a></td>-->
                                <td><a href="edit_product.php?id=<?php echo $row["id"]; ?>"><i class="fas fa-edit"></i></a></td>
                                <td><button class="delete-btn" onclick="confirmDelete('<?php echo $row['id']; ?>')"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                        <?php
                            $counter++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <button class="add-btn" onclick="window.location.href='add_product.php'">Add Product</button>
        </div>
        <script>
            function confirmDelete(id) {
                if (confirm("Are you sure you want to delete the product?")) {
                    window.location.href = 'delete_product.php?id=' + encodeURIComponent(id);
                }
            }
        </script>
    </body>
</html>