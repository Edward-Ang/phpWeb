<?php
echo "Hello World";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
</head>

<body><?php
        require('database.php');
        $arrayid = array(1, 2);
        $serialized_array = urlencode(serialize($arrayid));

        $sql_query = "SELECT * FROM order_table";
        $result = mysqli_query($con, $sql_query);
        $row = mysqli_fetch_assoc($result);
        ?>

    <a href="payment.php?ids=<?php echo $serialized_array; ?>" class="button-link">Checkout Button</a>
    <a href="pay_history.php" class="button-link">Payment History</a>
</body>

</html>