<?php
session_start();
require_once('database.php');

// Check if the order ID is provided
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Fetch all products and quantities from the order_items table for this order
        $sql = "SELECT product_id, quantity FROM order_items WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];

            // Update the stock for each product
            $update_stock_sql = "UPDATE products SET stock_quantity = stock_quantity + ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_stock_sql);
            $update_stmt->bind_param('ii', $quantity, $product_id);
            $update_stmt->execute();
        }

        // Delete the order items associated with the order
        $delete_order_items_sql = "DELETE FROM order_items WHERE order_id = ?";
        $delete_stmt = $conn->prepare($delete_order_items_sql);
        $delete_stmt->bind_param('i', $order_id);
        $delete_stmt->execute();

        // Delete the order itself
        $delete_order_sql = "DELETE FROM orders WHERE id = ?";
        $delete_order_stmt = $conn->prepare($delete_order_sql);
        $delete_order_stmt->bind_param('i', $order_id);
        $delete_order_stmt->execute();

        // Commit the transaction
        $conn->commit();

        // Redirect to admin_orders.php after successful deletion
        header("Location: manage_orders.php");
        exit(); // Ensure no further code is executed after redirection
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No order ID provided.";
}

$conn->close();
?>
