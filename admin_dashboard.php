<?php
session_start();
$_SESSION['role'] = 'admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/main.css">



</head>
<body>
<div class="main-header">
    <div class="logo">
        <a href="index.php"><h2>CS602</h2></a>
    </div>
    <div class="main-nav">
        <a href="logout.php" class="logout-link">Log Out</a>
    </div>
</div>

<div class="container">
    <h1 class="dashboard-heading">Admin Dashboard</h1>
    <p class="welcome-message">Welcome! Manage the store from here.</p>
    <nav class="dashboard-links">
        <a href="list_products.php?admin=true">List of Products</a>
        <a href="add_product.php">Add Product</a>
        <a href="list_customers.php">List of Customers</a>
        <a href="manage_orders.php">Manage Orders</a>
    </nav>
</div>
</body>
</html>
