<?php
session_start();
require_once('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $new_stock_quantity = $_POST['new_stock_quantity'];

    $sql = "UPDATE products SET stock_quantity=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $new_stock_quantity, $product_id);

    if ($stmt->execute()) {
        header("Location: list_products.php?admin=true");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
