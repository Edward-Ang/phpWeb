<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechTrove Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/pay-history.css">
    <link rel="stylesheet" href="../css/header.css">
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

    <div class="pay-history-container">
        <div class="pay-history-header">
            <span>Payment history</span>
        </div>
        <div class="pay-history-body">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Method</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    session_start();
                    require('db_connect.php');

                    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

                    $sql_query = "SELECT * FROM payment WHERE u_id = '$user_id'";
                    $result = mysqli_query($conn, $sql_query);
                    $counter = 1;
                    while ($row = mysqli_fetch_assoc($result)) {

                    ?>
                        <tr>
                            <td><?php echo $counter ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['contact'] ?></td>
                            <td><?php echo $row['address'] ?></td>
                            <td><?php echo $row['method'] ?></td>
                            <td><?php echo $row['date'] ?></td>
                            <td><span class="badge rounded-pill text-bg-success">Paid</span></td>
                            <td>RM <?php echo $row['total'] ?></td>
                        </tr>
                    <?php
                        $counter++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>