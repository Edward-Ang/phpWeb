<?php
session_start();

// Step 1: Ensure user authentication
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

if (!isset($_SESSION['favorite_products'])) {
    $_SESSION['favorite_products'] = array();
}

// Include database connection
include_once 'db_connect.php';

// Fetch favorite products
$favorite_products = $_SESSION['favorite_products'];
$favorite_products_string = implode(',', $favorite_products);
if (!empty($favorite_products)) {
    $favorite_query = "SELECT * FROM products WHERE id IN ($favorite_products_string)";
    $favorite_result = mysqli_query($conn, $favorite_query);
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Favorite Products</title>
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/header.css">
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
            <section id="favorite-products">
                <h2>Favorite Products</h2>
                <div id="product-grid">
                    <?php while ($row = mysqli_fetch_assoc($favorite_result)) : ?>
                        <div class="product-box">
                            <div class="product-name">
                                <a href="product_details.php?id=<?php echo $row['id']; ?>"><?php echo $row['product_name']; ?></a>
                            </div>
                            <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>" class="product-image">
                            <div class="product-price">RM <?php echo $row['price']; ?></div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </section>
        </main>

    </body>

    </html>

<?php
} else {
    // Output the message with styling
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>No Favorite Products</title>
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/header.css">
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
        <section id="favorite-products">
            <p>You haven\'t added any products to your favorites yet.</p>
        </section>
    </main>

    </body>
    </html>';
}

// Close database connection
mysqli_close($conn);
?>