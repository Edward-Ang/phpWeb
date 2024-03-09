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
    $sql_query = "SELECT * FROM order_table WHERE id = 1";
    $result = mysqli_query($con, $sql_query);
    $row = mysqli_fetch_assoc($result)?>

    <a href="payment.php?id=<?php echo $row["id"]; ?>" class="button-link">Checkout</a>
</body>

</html>
