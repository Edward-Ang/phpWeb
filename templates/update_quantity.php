<?php
// Include the database connection file
include 'db_connect.php';

// Check if product_id and quantity are set in the POST request
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    // Sanitize the product ID and quantity
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    // Prepare SQL statement to update the quantity
    $sql = "UPDATE order_table SET product_quantity = ? WHERE p_id = ?";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $quantity, $product_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Quantity updated successfully
        echo "Quantity updated successfully.";
    } else {
        // Error occurred
        echo "Error updating quantity: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Product ID or quantity parameter not provided
    echo "Product ID or quantity not provided.";
}
?>
