<?php
session_start();

// Step 1: Ensure user authentication
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection
include_once 'db_connect.php';

// Step 2: Implement category filter
$categories_query = "SELECT DISTINCT category FROM products";
$categories_result = mysqli_query($conn, $categories_query);
$categories = array();
while ($row = mysqli_fetch_assoc($categories_result)) {
    $categories[] = $row['category'];
}

// Fetch products with concatenated categories
if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $search_query = "AND product_name LIKE '%$search_term%'";
} else {
    $search_query = ""; // No search filter
}

$products_query = "SELECT *, GROUP_CONCAT(category) AS categories FROM products WHERE stock_level > 0 $search_query GROUP BY id";
$products_result = mysqli_query($conn, $products_query);

// Fetch favorite products
$favorite_products = isset($_SESSION['favorite_products']) ? $_SESSION['favorite_products'] : array();
$favorite_products_string = implode(',', $favorite_products);

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
        <section id="product-listings">
            <h2>Product Listings</h2>
            <div id="filter">
                <label for="category-filter">Filter by Category:</label>
                <select id="category-filter">
                    <option value="all">All Categories</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                    <?php endforeach; ?>
                </select>
                <form style="display: flex; align-items: center; width: fit-content">
            <input type="text" id="search-input" name="search" placeholder="Enter search keyword..." style="border: 1px solid #ccc; border-radius: 4px; padding: 8px; width: 150px; margin-right: 20px;">
            <div id="search-icon" style="cursor: pointer;"onclick="toggleSearchInput()">
                <p>Search
                <img src="../uploads/magnifying_glass_icon.png" alt="Search" style="width: 20px; height: 20px;">
            </div>
        </form>
            </div>
            <div id="product-grid">
                <?php while ($row = mysqli_fetch_assoc($products_result)) : ?>
                    <div class="product-box" data-categories="<?php echo htmlspecialchars(strtolower($row['categories'])); ?>">
                        <div class="product-name">
                            <a href="product_details.php?id=<?php echo $row['id']; ?>"><?php echo $row['product_name']; ?></a>
                        </div>
                        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>" class="product-image">
                        <div class="product-price">RM <?php echo $row['price']; ?></div>
                        <!-- Favorite button -->
                        <button class="favorite-button <?php echo (in_array($row['id'], $favorite_products) ? 'favorited' : ''); ?>" onclick="toggleFavorite(this, <?php echo $row['id']; ?>)">
                            <?php echo (in_array($row['id'], $favorite_products) ? 'Unfavorite' : 'Favorite'); ?>
                        </button>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>

    <script src="../scripts/script.js"></script>
    <script>
        function toggleSearchInput() {
            var searchInput = document.getElementById('search-input');
            var searchIcon = document.getElementById('search-icon');

            if (searchInput.style.display === 'none') {
                searchInput.style.display = 'inline-block';
                searchIcon.style.display = 'none';
                searchInput.focus(); // Focus on the search input when displayed
            } else {
                searchInput.style.display = 'none';
                searchIcon.style.display = 'inline-block';
            }
        }

        function searchProducts(event) {
            // If Enter key is pressed (key code 13)
            if (event.keyCode === 13) {
                event.preventDefault(); // Prevent form submission
                var searchInput = document.getElementById('search-input');
                var searchTerm = searchInput.value.trim(); // Get the search term
                // Redirect to the same page with the search term as a query parameter
                window.location.href = 'user_dashboard.php?search=' + encodeURIComponent(searchTerm);
            }
        }

        function toggleFavorite(button, productId) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'toggle_favorite.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        if (xhr.responseText === 'added') {
                            button.textContent = 'Unfavorite';
                            button.classList.add('favorited');
                        } else if (xhr.responseText === 'removed') {
                            button.textContent = 'Favorite';
                            button.classList.remove('favorited');
                        }
                    } else {
                        console.error('Toggle favorite request failed: ' + xhr.status);
                    }
                }
            };
            xhr.send('product_id=' + encodeURIComponent(productId));
        }
    </script>


</body>

</html>