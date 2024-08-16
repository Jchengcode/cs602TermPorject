<?php
// delete_customer.php
// Deletes a customer and all associated orders from the database.

require_once('database.php');

if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // First, delete all orders associated with the customer
    $sql = "DELETE FROM orders WHERE customer_id = $customer_id";
    $conn->query($sql);

    // Then, delete the customer
    $sql = "DELETE FROM users WHERE id = $customer_id AND role = 'customer'";
    if ($conn->query($sql) === TRUE) {
        echo "Customer and associated orders deleted successfully.";
    } else {
        echo "Error deleting customer: " . $conn->error;
    }
} else {
    echo "No customer ID provided.";
}

$conn->close();

// Redirect back to the list of customers
header("Location: list_customers.php");
exit();
?>
