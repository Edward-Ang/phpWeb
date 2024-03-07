<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <link rel="stylesheet" href="css/payment.css">
    <script src="https://kit.fontawesome.com/d7d8d20a77.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="scripts/payment.js"></script>
</head>

<body>
    <?php
require('database.php');
if (isset($_REQUEST['name'])){
$name = stripslashes($_REQUEST['name']);
$name = mysqli_real_escape_string($con,$name);
$contact = stripslashes($_REQUEST['contact']);
$contact = mysqli_real_escape_string($con,$contact);
$address = stripslashes($_REQUEST['address']);
$address = mysqli_real_escape_string($con,$address);
$method = stripslashes($_REQUEST['method']);
$method = mysqli_real_escape_string($con,$method);

$query = "INSERT into payment (name, contact, address, method)
VALUES ('$name', '$contact', '$address', '$method')";
$result = mysqli_query($con,$query);

if($result){
?>
    <div class="popup-div" id="popup-div" style="display: flex;">
        <div class="popup-container">
            <div class="header">
                <div class="image">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                        <g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#000000"
                                d="M20 7L9.00004 18L3.99994 13"></path>
                        </g>
                    </svg>
                </div>
                <div class="content">
                    <span class="title">Order validated</span>
                    <p class="message">Thank you for your purchase. you package will be delivered within 2 days of your
                        purchase</p>
                </div>
                <div class="actions">
                    <button type="button" class="continue-shop-btn"><a href="index.php">Continue shop</a></button>
                    <button type="button" class="track">View my order</button>
                </div>
            </div>
        </div>
    </div>
    <div class="main-div">
        <div class="left-div">
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-cash-coin" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                                    <path
                                        d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                                    <path
                                        d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-bank2" viewBox="0 0 16 16">
                                    <path
                                        d="M8.277.084a.5.5 0 0 0-.554 0l-7.5 5A.5.5 0 0 0 .5 6h1.875v7H1.5a.5.5 0 0 0 0 1h13a.5.5 0 1 0 0-1h-.875V6H15.5a.5.5 0 0 0 .277-.916zM12.375 6v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zM8 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2M.5 15a.5.5 0 0 0 0 1h15a.5.5 0 1 0 0-1z" />
                                </svg>
                            </span>
                            <span class="radio-label">Bank Transfer</span>
                        </span>
                    </label>
                    <label>
                        <input class="radio-input" type="radio" name="method" value="Credit/Debit Card">
                        <span class="radio-tile">
                            <span class="radio-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1" />
                                </svg>
                            </span>
                            <span class="radio-label">Credit/Debit Card</span>
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <div class="rigth-div">
            <div class="payment-summary-div">
                <div class="payment-summary-container">
                    <div class="payment-summary-header">
                        <span>Payment Details</span>
                    </div>
                    <div class="payment-summary-body">
                        <div class="price-row">
                            <span>Price</span>
                            <span>RM 20.69</span>
                        </div>
                        <div class="quantity-row">
                            <span>Quantity</span>
                            <span>x1</span>
                        </div>
                        <div class="subtotal-row">
                            <span>Subtotal</span>
                            <span>RM 20.69</span>
                        </div>
                        <div class="shipping-row">
                            <span>Shipping</span>
                            <span>RM 5.00</span>
                        </div>
                        <div class="tax-row">
                            <span>Tax</span>
                            <span>RM 2.00</span>
                        </div>
                    </div>
                    <div class="payment-summary-footer">
                        <span>Total</span>
                        <span>RM 27.69</span>
                    </div>
                    <div class="payment-btn-div">
                        <button class="payment-btn" id="payment-btn" type="submit">Proceed to payment &nbsp<i
                                class="fa-solid fa-right-long"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
    }
}
else{ ?>
    <div class="main-div">
        <div class="left-div">
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-cash-coin" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                                    <path
                                        d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                                    <path
                                        d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-bank2" viewBox="0 0 16 16">
                                    <path
                                        d="M8.277.084a.5.5 0 0 0-.554 0l-7.5 5A.5.5 0 0 0 .5 6h1.875v7H1.5a.5.5 0 0 0 0 1h13a.5.5 0 1 0 0-1h-.875V6H15.5a.5.5 0 0 0 .277-.916zM12.375 6v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zm-2.5 0v7h-1.25V6zM8 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2M.5 15a.5.5 0 0 0 0 1h15a.5.5 0 1 0 0-1z" />
                                </svg>
                            </span>
                            <span class="radio-label">Bank Transfer</span>
                        </span>
                    </label>
                    <label>
                        <input class="radio-input" type="radio" name="method" value="Credit/Debit Card">
                        <span class="radio-tile">
                            <span class="radio-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1" />
                                </svg>
                            </span>
                            <span class="radio-label">Credit/Debit Card</span>
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <div class="rigth-div">
            <div class="payment-summary-div">
                <div class="payment-summary-container">
                    <div class="payment-summary-header">
                        <span>Payment Details</span>
                    </div>
                    <div class="payment-summary-body">
                        <div class="price-row">
                            <span>Price</span>
                            <span>RM 20.69</span>
                        </div>
                        <div class="quantity-row">
                            <span>Quantity</span>
                            <span>x1</span>
                        </div>
                        <div class="subtotal-row">
                            <span>Subtotal</span>
                            <span>RM 20.69</span>
                        </div>
                        <div class="shipping-row">
                            <span>Shipping</span>
                            <span>RM 5.00</span>
                        </div>
                        <div class="tax-row">
                            <span>Tax</span>
                            <span>RM 2.00</span>
                        </div>
                    </div>
                    <div class="payment-summary-footer">
                        <span>Total</span>
                        <span>RM 27.69</span>
                    </div>
                    <div class="payment-btn-div">
                        <button class="payment-btn" id="payment-btn" type="submit">Proceed to payment &nbsp<i
                                class="fa-solid fa-right-long"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</body>

</html>