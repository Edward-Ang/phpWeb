<!DOCTYPE html>
<html lang="en">
<?php
// Include the database connection file
include 'db_connect.php';

// Start the session (if not already started)
session_start();

// Check if the product ID is provided in the URL parameter and the user is logged in
if (isset($_GET['product_id']) && !empty($_GET['product_id']) && isset($_SESSION['user_id'])) {
    // Retrieve the product ID from the URL parameter
    $product_id = $_GET['product_id'];

    // Retrieve the user ID from the session variable
    $user_id = $_SESSION['user_id'];

    // Check if the item already exists in the cart for the current user
    $check_query = "SELECT * FROM order_table WHERE user_id = ? AND p_id = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("ii", $user_id, $product_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Item already exists in the cart
        echo "This item is already in your cart.";
    } else {
        // Item does not exist in the cart, proceed with insertion
        // Default quantity value
        $default_quantity = 1;

        // Prepare SQL statement to insert order details into the order table
        $insert_sql = "INSERT INTO order_table (user_id, p_id, product_quantity) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iii", $user_id, $product_id, $default_quantity);

        // Execute the insert statement
        if ($insert_stmt->execute()) {
            //echo "Product added to cart successfully.";
        } else {
            echo "Error: " . $insert_stmt->error;
        }

        // Close the insert statement
        $insert_stmt->close();
    }

    // Close the check statement
    $check_stmt->close();
}

// Close the connection
$conn->close();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My cart</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/order.css">
    <script src="https://kit.fontawesome.com/d7d8d20a77.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        main {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px 20px 0px 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        #cart-items {
            margin-bottom: 20px;
        }

        #cart-items h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>
    <header class="site-header">
        <div class="header-container">
            <h1 class="site-title">Your Website</h1>
            <nav class="site-navigation">
                <ul>
                    <li><a href="user_dashboard.php">Home</a></li>
                    <li><a href="favorite.php">Favorite</a></li>
                    <li><a href="order.php">Order</a></li>
                    <li><a href="pay_history.php" class="button-link">Payment History</a></li>
                </ul>
            </nav>
            <span class="logout-btn"><a href="logout.php">Logout</a></span>
        </div>
    </header>

    <main>
        <section id="cart-items">
            <h2>Shopping Cart</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Delete</th> <!-- New column for delete button -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db_connect.php';

                    // Check if the user is logged in
                    if (isset($_SESSION['user_id'])) {
                        // Retrieve the user ID from the session variable
                        $user_id = $_SESSION['user_id'];

                        // Fetch items from order_table for the current user
                        $sql_query = "SELECT * FROM order_table WHERE user_id = $user_id";
                        $result = mysqli_query($conn, $sql_query);

                        $total_amount = 0;

                        // Display cart items
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            // Fetch product details from products table based on product ID
                            $order_id = $row['id'];
                            $product_id = $row['p_id'];
                            $product_query = "SELECT * FROM products WHERE id = $product_id";
                            $product_result = mysqli_query($conn, $product_query);
                            if ($product_result && mysqli_num_rows($product_result) == 1) {
                                $product_row = mysqli_fetch_assoc($product_result);
                                echo "<td>" . $product_row['product_name'] . "</td>";
                                echo "<td class='description'>" . $product_row['description'] . "</td>";
                                echo "<td>RM " . $product_row['price'] . "</td>";
                                echo "<td class='quantity'>";
                                echo "<button onclick='decrement(this, $product_id)'>&minus;</button>";
                                echo "<input type='number' value='" . $row['product_quantity'] . "' min='1' onchange='updateQuantity(this, $product_id)'>";
                                echo "<button onclick='increment(this, $product_id)'>&plus;</button>";
                                echo "</td>";
                                $subtotal = $product_row['price'] * 1;
                                $total_amount += $subtotal;
                                echo "<td class='subtotal'>RM " . number_format($subtotal, 2) . "</td>";
                                echo "<td><button class='dltBtn' onclick='deleteItem(this.parentNode.parentNode, $order_id)'><i class='fa-solid fa-trash'></i></button></td>";
                            }
                            echo "</tr>";
                        }

                        // Close database connection
                        mysqli_close($conn);
                    } else {
                        echo "System Error: User has not logged in.";
                    }
                    ?>
                </tbody>
            </table>
            <div class="total">
                <span>Total Amount</span>
                <span class="totalamount">RM <?php echo number_format($total_amount, 2); ?></span>
            </div>
        </section>
    </main>
</body>

<?php
require('db_connect.php');

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$sql_query = "SELECT id FROM order_table WHERE user_id ='$user_id'"; // Select only the ID column
$result = mysqli_query($conn, $sql_query);

$arrayid = array(); // Initialize an empty array to store IDs

// Iterate over the result set
while ($row = mysqli_fetch_assoc($result)) {
    // Push each ID into the array
    $arrayid[] = $row['id'];
}

// Serialize the array for storage or further processing
$serialized_array = urlencode(serialize($arrayid));

// Unserialize the serialized array
$unserialized_array = unserialize(urldecode($serialized_array));

// Check if the unserialized array is not empty
if (!empty($unserialized_array)) {
?>
    <a href="payment.php?ids=<?php echo $serialized_array; ?>" class="button-link checkout-button">Checkout</a>
<?php
} else { ?>
<?php }
?>

<script>
    function increment(element, productId) {
        var input = element.parentNode.querySelector('input');
        input.value = parseInt(input.value) + 1;
        updateSubtotal(input);
        updateQuantity(input, productId);
    }

    function decrement(element, productId) {
        var input = element.parentNode.querySelector('input');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            updateSubtotal(input);
        }
        updateQuantity(input, productId);
    }

    function updateSubtotal(input) {
        var price = input.parentNode.previousElementSibling.textContent.replace('RM ', '');
        var subtotal = parseFloat(price) * parseInt(input.value);
        input.parentNode.nextElementSibling.textContent = 'RM ' + subtotal.toFixed(2);
        updateTotal();
    }

    function updateTotal() {
        var subtotals = document.querySelectorAll('.subtotal');
        var totalAmount = 0;
        subtotals.forEach(function(subtotal) {
            totalAmount += parseFloat(subtotal.textContent.replace('RM ', ''));
        });
        document.querySelector('.totalamount').textContent = 'RM ' + totalAmount.toFixed(2);
    }

    function updateQuantity(input, productId) {
        var quantity = input.value;
        var formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_quantity.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Quantity updated successfully
                    updateSubtotalAndTotal(xhr.responseText); // Update subtotal and total
                } else {
                    // Error occurred
                    console.error('Error updating quantity: ' + xhr.responseText);
                }
            }
        };
        xhr.send(formData);
    }

    function deleteItem(row, orderId) {
        var confirmation = confirm("Are you sure you want to delete this item?");
        if (confirmation) {
            // Send an AJAX request to delete the item
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Item deleted successfully, remove the row from the table
                        row.parentNode.removeChild(row);
                        // Update the total
                        updateTotal();

                        location.reload();
                    } else {
                        // Error occurred, handle it appropriately
                        console.error('Error:', xhr.responseText);
                    }
                }
            };
            xhr.open("POST", "delete_item.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("order_id=" + orderId);
        }
    }
</script>

</body>

</html>