<?php
// Include the database connection file
include 'db_connect.php';

// Check if product_id is set in the POST request
if (isset($_POST['order_id'])) {
    // Sanitize the product ID
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);

    // Prepare SQL statement to delete the record
    $sql = "DELETE FROM order_table WHERE id = ?";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Deletion successful
        echo "Item deleted successfully.";
    } else {
        // Error occurred
        echo "Error deleting item: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // product_id parameter not set
    echo "Product ID not provided.";
}
?>
