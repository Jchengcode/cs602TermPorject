<?php
session_start();
require_once('database.php');

// Check if the user is an admin
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] == 'admin';

$search_query = '';
$results = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['query'])) {
        // Search by name or description
        $search_query = $_GET['query'];
        $sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ?";
        $stmt = $conn->prepare($sql);
        $like_query = "%" . $search_query . "%";
        $stmt->bind_param("ss", $like_query, $like_query);
    } elseif (isset($_GET['min_price']) && isset($_GET['max_price'])) {
        // Search by price range
        $min_price = $_GET['min_price'];
        $max_price = $_GET['max_price'];
        $sql = "SELECT * FROM products WHERE price BETWEEN ? AND ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dd", $min_price, $max_price);
    }

    $stmt->execute();
    $results = $stmt->get_result();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="main-header">
    <div class="logo">
        <a href="index.php"><h2>CS602</h2></a>
    </div>
    <div class="main-nav-links">
        <?php if ($is_admin): ?>
            <a href="admin_dashboard.php">Admin Dashboard</a>
            <a href="add_product.php">Add Product</a>
            <a href="list_products.php?admin=true">List of Products</a>
            <a href="list_customers.php">List of Customers</a>
            <a href="manage_orders.php">Manage Orders</a>
        <?php else: ?>
            <a href="my_orders.php">My Orders</a>
            <a href="customer_dashboard.php">Customer Dashboard</a>
            <a href="shopping_cart.php">
                <img src="images/shopping_cart.png" alt="Shopping Cart" style="height: 24px; vertical-align: middle;">
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <h1>Search Results</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock Quantity</th>
        </tr>
        <?php if ($results && $results->num_rows > 0): ?>
            <?php while ($row = $results->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['stock_quantity']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No results found.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>
