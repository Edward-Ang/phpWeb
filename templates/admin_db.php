<?php
session_start();

// User authentication
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/user_details.css">
        <style>
            .delete-btn {
                background-color: red; /* Set background color to red */
                border: none; /* Remove border */
                padding: 8px;
                border-radius: 5px;
            }

            .delete-btn:hover {
                background-color: darkred; /* Change background color on hover */
                cursor: pointer;
            }

            .delete-btn i {
                color: white; /* Set icon color to white */
                font-size: 16px; /* Adjust icon size if needed */
            }
        </style>
    </head>

    <body>
        <header class="site-header">
            <div class="header-container">
                <h1 class="site-title">Welcome <?php echo $_SESSION['username']; ?>!</h1>
                <nav class="site-navigation">
                    <ul>
                        <li><a href="admin_db.php">User Management</a></li>
                        <li><a href="product_list.php">Product Management</a></li>
                    </ul>
                </nav>
                <span class="logout-btn"><a href="logout.php">Logout</a></span>
            <div>
        </header>

        <div class="user-list-container">
            <div class="user-list-header">
                <span>Registered User Details</span>
            </div>
            <div class="user-list-body">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Modify</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require('db_connect.php');

                        $sql_query = "SELECT * FROM users WHERE role ='user'";
                        $result = mysqli_query($conn, $sql_query);
                        $counter = 1;

                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $counter ?></td>
                                <td><?php echo $row['username'] ?></td>
                                <td><button class="delete-btn" onclick="confirmDelete('<?php echo $row['username']; ?>')"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                        <?php
                            $counter++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            function confirmDelete(username) {
                if (confirm("Are you sure you want to delete the user '" + username + "'?")) {
                    window.location.href = 'delete_user.php?username=' + encodeURIComponent(username);
                }
            }
        </script>
    </body>
</html>