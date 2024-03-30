<?php
session_start();

// Step 1: Ensure user authentication
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once 'db_connect.php';

// Check if product ID is provided in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details from the database
    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $query);

    // Check if product exists
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $product_name = $row['product_name'];
        $description = $row['description'];
        $price = $row['price'];
        $image = $row['image'];
        // You can fetch user rating from the database if available
    } else {
        // Product not found, redirect to user dashboard
        header("Location: user_dashboard.php");
        exit();
    }
} else {
    // Product ID not provided, redirect to user dashboard
    header("Location: user_dashboard.php");
    exit();
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - <?php echo $product_name; ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/product_details.css">
</head>

<body>
    <header class="site-header">
        <div class="header-container">
            <h1 class="site-title">TechTrove</h1>
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
        <section id="product-details">
            <div class="product-image">
                <img src="<?php echo $image; ?>" alt="<?php echo $product_name; ?>">
            </div>
            <div class="product-info">
                <h2><?php echo $product_name; ?></h2>
                <span class="product-description"><?php echo $description; ?></span>
                <!-- Add interactive buttons for adding to cart and buying -->
                <div class="product-info-footer">
                    <span class="product-price">RM <?php echo $price; ?></span>
                    <div class="product-actions">
                        <a href="order.php?product_id=<?php echo $product_id; ?>" class="button-link add-to-cart-button">Add to Cart</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

</body>

</html>