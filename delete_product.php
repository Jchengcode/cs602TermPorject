<?php
// delete_product.php
// Deletes a product from the database only if it is not part of any orders.

require_once('database.php');

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Check if the product is part of any order
    $sql = "SELECT * FROM order_items WHERE product_id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // If the product is in any orders, do not delete and display an error message
        echo "<script>alert('Error: Cannot delete product because it is part of an existing order.'); window.location.href='list_products.php?admin=true';</script>";
    } else {
        // Proceed to delete the product
        $sql = "DELETE FROM products WHERE id = $product_id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Product deleted successfully.'); window.location.href='list_products.php?admin=true';</script>";
        } else {
            echo "Error deleting product: " . $conn->error;
        }
    }
} else {
    echo "No product ID provided.";
}

$conn->close();
?>
