<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechTrove</title>
    <link rel="stylesheet" href="../css/payment.css">
    <link rel="stylesheet" href="../css/header.css">
    <script src="https://kit.fontawesome.com/d7d8d20a77.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
    <?php
    session_start();
    require('db_connect.php');

    if (isset($_REQUEST['name'])) {
        $name = stripslashes($_REQUEST['name']);
        $name = mysqli_real_escape_string($conn, $name);
        $contact = stripslashes($_REQUEST['contact']);
        $contact = mysqli_real_escape_string($conn, $contact);
        $address = stripslashes($_REQUEST['address']);
        $address = mysqli_real_escape_string($conn, $address);
        $method = stripslashes($_REQUEST['method']);
        $method = mysqli_real_escape_string($conn, $method);
        $date_pay = date("Y-m-d");
        $total_pay = $_REQUEST['total'];
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        $query = "INSERT into payment (name, contact, address, method, date, total, u_id)
        VALUES ('$name', '$contact', '$address', '$method', '$date_pay', '$total_pay', '$user_id')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $ids = unserialize(urldecode($_GET['ids']));
            $count = count($ids);
            $ids = implode(",", $ids);

            $order_query = "SELECT * FROM order_table WHERE id IN ($ids)";
            $order_result = mysqli_query($conn, $order_query);
    ?>
            <div class="popup-div" id="popup-div" style="display: flex;">
                <div class="popup-container">
                    <div class="header">
                        <div class="image">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#000000" d="M20 7L9.00004 18L3.99994 13"></path>
                                </g>
                            </svg>
                        </div>
                        <div class="content">
                            <span class="title">Order validated</span>
                            <p class="message">Thank you for your purchase. you package will be delivered within 2 days of your
                                purchase</p>
                        </div>
                        <div class="actions">
                            <button type="button" class="continue-shop-btn"><a href="user_dashboard.php">Continue shop</a></button>
                            <button type="button" class="pay-history-btn"><a href="pay_history.php">Payment history</a></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="payment-wrapper">
                <div class="payment-header-div">
                    <span>Checkout</span>
                    <button class="cancel-button" onclick="window.location.href = 'order.php'">
                        <p class="cancel-text">Cancel</p>
                    </button>
                </div>
                <div class="main-div">
                    <div class="left-div">
                        <div class="order-container">
                            <div class="order-container-header">
                                <span>Order Details</span>
                            </div>
                            <?php
                            // Define an empty array
                            $productData = array();

                            for ($i = 0; $i < $count; $i++) {
                                $order_row = mysqli_fetch_assoc($order_result);

                                $product_id = $order_row['p_id'];

                                $product_query = "SELECT * FROM products WHERE id = $product_id";
                                $product_result = mysqli_query($conn, $product_query);
                                $product_row = mysqli_fetch_assoc($product_result);

                                $price = $product_row['price'];
                                $desc = $product_row['description'];

                                // Append values to the array
                                $productData[] = array(
                                    "product_price" => $price,
                                    "product_quantity" => $order_row["product_quantity"]
                                );
                            ?>
                                <div class="order-container-body">
                                    <div class="order-container-left">
                                        <img src="<?php echo $product_row['image'] ?>" />
                                    </div>
                                    <div class="order-container-right">
                                        <div class="order-name-div">
                                            <span><?php echo $product_row["product_name"] ?></span>
                                        </div>
                                        <div class="order-desc-div">
                                            <span><?php echo $desc ?></span>
                                        </div>
                                        <div class="order-price-quantity-div">
                                            <span>RM <?php echo number_format($product_row["price"], 2) ?></span>
                                            <span><span id="qty">X</span> <?php echo $order_row["product_quantity"] ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            $subtotal = 0;

                            // Loop through each element of the $productData array
                            foreach ($productData as $item) {
                                // Check if the product price is numeric
                                if (is_numeric($item['product_price'])) {
                                    // Multiply the product price by the product quantity and add it to the total
                                    $subtotal += $item['product_price'] * $item['product_quantity'];
                                } else {
                                    // Handle non-numeric values (e.g., output an error message)
                                    echo "Error: Non-numeric value encountered for product price";
                                }
                            }

                            $shipping = 5;
                            $tax = round($subtotal * 0.1, 2);
                            $total = $subtotal + $shipping + $tax;
                            $display_total = number_format($total, 2);
                            ?>
                        </div>
                        <div class="form-container">
                            <div class="recipient-detail-div">
                                <div class="recipient-div">
                                    <span class="recipient-title">Recipient Details</span>
                                    <form class="form" id="payment-form" action="" method="post">
                                        <div class="group">
                                            <input placeholder="" type="text" id="name" name="name" required>
                                            <label for="name">Name</label>
                                        </div>
                                        <div class="group">
                                            <input placeholder="" type="tel" id="contact" name="contact" required>
                                            <label for="contact">Contact</label>
                                        </div>
                                        <div class="group">
                                            <textarea placeholder="" id="address" name="address" rows="5" required></textarea>
                                            <label for="address">Address</label>
                                        </div>
                                </div>
                            </div>
                            <div class="payment-method-div">
                                <div class="payment-header">
                                    <span>Payment Method</span>
                                </div>
                                <div class="radio-inputs">
                                    <label>
                                        <input class="radio-input" type="radio" name="method" value="Cash On Delivery" checked>
                                        <span class="radio-tile">
                                            <span class="radio-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                                                    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                                                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                                                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                                                </svg>
                                            </span>
                                            <span class="radio-label">Cash On Delivery</span>
                                        </span>
                                    </label>
                                    <label>
                                        <input class="radio-input" type="radio" name="method" value="Bank Transfer">
                                        <span class="radio-tile">
                                            <span class="radio-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bank2" viewBox="0 0 16 16">
                                                    <path d="M8.277.084a.5.5 0 0 0-.554 0l-7.5 5A.5.5 0 0 0 .5 6h1.875v7H1.5a.5.5 0 0 0 0 1h13a.5.5 0 1 0 0-1h-.875V6H15.5a.5.5 0 0 0 .277-.916zM12.375 6v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zM8 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2M.5 15a.5.5 0 0 0 0 1h15a.5.5 0 1 0 0-1z" />
                                                </svg>
                                            </span>
                                            <span class="radio-label">Bank Transfer</span>
                                        </span>
                                    </label>
                                    <label>
                                        <input class="radio-input" type="radio" name="method" value="Credit/Debit Card">
                                        <span class="radio-tile">
                                            <span class="radio-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1" />
                                                </svg>
                                            </span>
                                            <span class="radio-label">Credit/Debit Card</span>
                                        </span>
                                    </label>
                                    <label>
                                        <input class="radio-input" type="radio" name="method" value="E-Wallet">
                                        <span class="radio-tile">
                                            <span class="radio-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-coin" viewBox="0 0 16 16">
                                                    <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518z" />
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                    <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11m0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12" />
                                                </svg>
                                            </span>
                                            <span class="radio-label">E-Wallet</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right-div">
                        <div class="payment-summary-div">
                            <div class="payment-summary-container">
                                <div class="payment-summary-header">
                                    <span>Payment Details</span>
                                </div>
                                <div class="payment-summary-body">
                                    <div class="subtotal-row">
                                        <span>Subtotal</span>
                                        <span>RM <?php echo $subtotal ?></span>
                                    </div>
                                    <div class="shipping-row">
                                        <span>Shipping</span>
                                        <span>RM 5.00</span>
                                    </div>
                                    <div class="tax-row">
                                        <span>Tax (10%)</span>
                                        <span>RM <?php echo $tax ?></span>
                                    </div>
                                </div>
                                <div class="payment-summary-footer">
                                    <span>Total</span>
                                    <span>RM <?php echo $display_total ?></span>
                                    <input type="hidden" name="total" value="<?php echo $total; ?>">
                                </div>
                                <div class="payment-btn-div">
                                    <button class="payment-btn" id="payment-btn" type="submit">Confirm To Pay &nbsp<i class="fa-solid fa-right-long"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $dlt_sql = "DELETE FROM order_table WHERE user_id = '$user_id'";
                $dlt_result = mysqli_Query($conn, $dlt_sql); ?>
            <?php
        }
    } else {
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $ids = unserialize(urldecode($_GET['ids']));
        $count = count($ids);
        $ids = implode(",", $ids);

        $order_query = "SELECT * FROM order_table WHERE id IN ($ids) AND user_id = '$user_id'";
        $order_result = mysqli_query($conn, $order_query);

            ?>
            <div class="payment-wrapper">
                <div class="payment-header-div">
                    <span>Checkout</span>
                    <button class="cancel-button" onclick="window.location.href = 'order.php'">
                        <p class="cancel-text">Cancel</p>
                    </button>
                </div>
                <div class="main-div">
                    <div class="left-div">
                        <div class="order-container">
                            <div class="order-container-header">
                                <span>Order Details</span>
                            </div>
                            <?php
                            // Define an empty array
                            $productData = array();

                            for ($i = 0; $i < $count; $i++) {
                                $order_row = mysqli_fetch_assoc($order_result);

                                $product_id = $order_row['p_id'];

                                $product_query = "SELECT * FROM products WHERE id = $product_id";
                                $product_result = mysqli_query($conn, $product_query);
                                $product_row = mysqli_fetch_assoc($product_result);

                                $price = $product_row['price'];
                                $desc = $product_row['description'];

                                // Append values to the array
                                $productData[] = array(
                                    "product_price" => $price,
                                    "product_quantity" => $order_row["product_quantity"]
                                );
                            ?>
                                <div class="order-container-body">
                                    <div class="order-container-left">
                                        <img src="<?php echo $product_row['image'] ?>" />
                                    </div>
                                    <div class="order-container-right">
                                        <div class="order-name-div">
                                            <span><?php echo $product_row["product_name"] ?></span>
                                        </div>
                                        <div class="order-desc-div">
                                            <span><?php echo $desc ?></span>
                                        </div>
                                        <div class="order-price-quantity-div">
                                            <span>RM <?php echo number_format($product_row["price"], 2) ?></span>
                                            <span><span id="qty">X</span> <?php echo $order_row["product_quantity"] ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            $subtotal = 0;

                            // Loop through each element of the $productData array
                            foreach ($productData as $item) {
                                // Check if the product price is numeric
                                if (is_numeric($item['product_price'])) {
                                    // Multiply the product price by the product quantity and add it to the total
                                    $subtotal += $item['product_price'] * $item['product_quantity'];
                                } else {
                                    // Handle non-numeric values (e.g., output an error message)
                                    echo "Error: Non-numeric value encountered for product price";
                                }
                            }

                            $shipping = 5;
                            $tax = round($subtotal * 0.1, 2);
                            $total = $subtotal + $shipping + $tax;
                            $display_total = number_format($total, 2);
                            ?>
                        </div>
                        <div class="form-container">
                            <div class="recipient-detail-div">
                                <div class="recipient-div">
                                    <span class="recipient-title">Recipient Details</span>
                                    <form class="form" id="payment-form" action="" method="post">
                                        <div class="group">
                                            <input placeholder="" type="text" id="name" name="name" required>
                                            <label for="name">Name</label>
                                        </div>
                                        <div class="group">
                                            <input placeholder="" type="tel" id="contact" name="contact" required>
                                            <label for="contact">Contact</label>
                                        </div>
                                        <div class="group">
                                            <textarea placeholder="" id="address" name="address" rows="5" required></textarea>
                                            <label for="address">Address</label>
                                        </div>
                                </div>
                            </div>
                            <div class="payment-method-div">
                                <div class="payment-header">
                                    <span>Payment Method</span>
                                </div>
                                <div class="radio-inputs">
                                    <label>
                                        <input class="radio-input" type="radio" name="method" value="Cash On Delivery" checked>
                                        <span class="radio-tile">
                                            <span class="radio-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                                                    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                                                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                                                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                                                </svg>
                                            </span>
                                            <span class="radio-label">Cash On Delivery</span>
                                        </span>
                                    </label>
                                    <label>
                                        <input class="radio-input" type="radio" name="method" value="Bank Transfer">
                                        <span class="radio-tile">
                                            <span class="radio-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bank2" viewBox="0 0 16 16">
                                                    <path d="M8.277.084a.5.5 0 0 0-.554 0l-7.5 5A.5.5 0 0 0 .5 6h1.875v7H1.5a.5.5 0 0 0 0 1h13a.5.5 0 1 0 0-1h-.875V6H15.5a.5.5 0 0 0 .277-.916zM12.375 6v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zM8 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2M.5 15a.5.5 0 0 0 0 1h15a.5.5 0 1 0 0-1z" />
                                                </svg>
                                            </span>
                                            <span class="radio-label">Bank Transfer</span>
                                        </span>
                                    </label>
                                    <label>
                                        <input class="radio-input" type="radio" name="method" value="Credit/Debit Card">
                                        <span class="radio-tile">
                                            <span class="radio-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1" />
                                                </svg>
                                            </span>
                                            <span class="radio-label">Credit/Debit Card</span>
                                        </span>
                                    </label>
                                    <label>
                                        <input class="radio-input" type="radio" name="method" value="E-Wallet">
                                        <span class="radio-tile">
                                            <span class="radio-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-coin" viewBox="0 0 16 16">
                                                    <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518z" />
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                    <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11m0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12" />
                                                </svg>
                                            </span>
                                            <span class="radio-label">E-Wallet</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right-div">
                        <div class="payment-summary-div">
                            <div class="payment-summary-container">
                                <div class="payment-summary-header">
                                    <span>Payment Details</span>
                                </div>
                                <div class="payment-summary-body">
                                    <div class="subtotal-row">
                                        <span>Subtotal</span>
                                        <span>RM <?php echo $subtotal ?></span>
                                    </div>
                                    <div class="shipping-row">
                                        <span>Shipping</span>
                                        <span>RM 5.00</span>
                                    </div>
                                    <div class="tax-row">
                                        <span>Tax (10%)</span>
                                        <span>RM <?php echo $tax ?></span>
                                    </div>
                                </div>
                                <div class="payment-summary-footer">
                                    <span>Total</span>
                                    <span>RM <?php echo $display_total ?></span>
                                    <input type="hidden" name="total" value="<?php echo $total; ?>">
                                </div>
                                <div class="payment-btn-div">
                                    <button class="payment-btn" id="payment-btn" type="submit">Confirm To Pay &nbsp<i class="fa-solid fa-right-long"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
</body>

</html>