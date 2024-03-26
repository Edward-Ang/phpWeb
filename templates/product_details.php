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
    <style>
        /* Additional styling for product details */
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

        nav {
            padding: 10px 0;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin-right: 20px;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            text-align: center;
            margin-bottom: 20px;
        }

        .product-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .product-info {
            text-align: left;
        }

        .product-info h2 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #333;
        }

        .product-price {
            font-size: 18px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .product-description {
            color: #666;
            margin-bottom: 20px;
        }

        .product-actions {
            display: flex;
            justify-content: center;
        }

        .product-actions button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }

        .product-actions button:hover {
            background-color: #0056b3;
        }

        .add-to-cart-button {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    background-color: #007bff; /* Button background color */
    color: #fff; /* Button text color */
    text-decoration: none;
    transition: background-color 0.3s ease;
    margin-right: 10px; /* Add margin to create space */
}

.buy-now-button {
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    background-color: #007bff; /* Button background color */
    color: #fff; /* Button text color */
    cursor: pointer;
    transition: background-color 0.3s ease;
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

    <main style="padding-top: 400px;">
    <section id="product-details">
        <div class="product-image">
            <img src="<?php echo $image; ?>" alt="<?php echo $product_name; ?>">
        </div>
        <div class="product-info">
            <h2><?php echo $product_name; ?></h2>
            <p class="product-price">Price: RM <?php echo $price; ?></p>
            <p class="product-description"><?php echo $description; ?></p>
            <!-- Add interactive buttons for adding to cart and buying -->
            <div class="product-actions">
                <a href="order.php?product_id=<?php echo $product_id; ?>" class="button-link add-to-cart-button">Add to Cart</a>
                <button onclick="buyNow(<?php echo $product_id; ?>)" class="buy-now-button">Buy Now</button>
            </div>
        </div>
    </section>
</main>

</body>
</html>

