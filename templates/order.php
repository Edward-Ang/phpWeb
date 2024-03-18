<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <link rel="stylesheet" href="../css/header.css">
</head>

<body>
    <header class="site-header">
        <div class="container">
            <h1 class="site-title">Your Website</h1>
            <nav class="site-navigation">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="order.php">Order</a></li>
                    <li><a href="pay_history.php" class="button-link">Payment History</a></li>
                    <li><a href="#">Staff</a></li>
                </ul>
            </nav>
            <span>Account</span>
        </div>
    </header>

    <?php
    require('database.php');
    $arrayid = array(1, 2);
    $serialized_array = urlencode(serialize($arrayid));

    $sql_query = "SELECT * FROM order_table";
    $result = mysqli_query($con, $sql_query);
    $row = mysqli_fetch_assoc($result);
    ?>

    <a href="payment.php?ids=<?php echo $serialized_array; ?>" class="button-link">Checkout Button</a>

</body>

</html>