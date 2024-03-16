<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/pay-history.css">
</head>

<body>

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
                    require('database.php');

                    $sql_query = "SELECT * FROM payment";
                    $result = mysqli_query($con, $sql_query);
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