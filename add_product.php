<?php
session_start();
require_once('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    $sql = "INSERT INTO products (name, description, price, stock_quantity) VALUES ('$name', '$description', $price, $stock_quantity)";
    if ($conn->query($sql) === TRUE) {
        echo "New product added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="main-header">
    <div class="logo">
        <a href="index.php"><h2>CS602</h2></a>
    </div>
    <div class="main-nav-links">
        <a href="admin_dashboard.php">Admin Dashboard</a>
        <a href="list_products.php?admin=true">List of Products</a>
        <a href="list_customers.php">List of Customers</a>
    </div>
</div>

<div class="form-container">
    <h1>Add Product</h1>
    <form method="post" action="add_product.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required>

        <label for="stock_quantity">Stock Quantity:</label>
        <input type="text" id="stock_quantity" name="stock_quantity" required>

        <input type="submit" value="Add Product">
    </form>
</div>
</body>
</html>
