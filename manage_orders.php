<?php
// manage_orders.php
// Allows the admin to view, update, or delete orders.

require_once('database.php');

// Fetch all orders
$sql = "
    SELECT 
        o.id AS order_id, 
        o.customer_id, 
        u.username AS customer_username, 
        o.order_date, 
        p.name, 
        p.description, 
        oi.quantity 
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    JOIN users u ON o.customer_id = u.id
";

$result = $conn->query($sql);

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="css/main.css">


</head>
<body>
<div class="main-header">
    <div class="logo">
        <a href="index.php"><h2>CS602</h2></a>
    </div>
    <div class="main-nav-links">
        <a href="admin_dashboard.php">Admin Dashboard</a>
        <a href="add_product.php">Add Product</a>
        <a href="list_products.php?admin=true">List of Products</a>
        <a href="list_customers.php">List of Customers</a>
    </div>
</div

    <div class="container">
    <h1>Manage Orders</h1>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Customer ID</th>
            <th>Customer Username</th>
            <th>Order Date</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($order = $result->fetch_assoc()) {
                echo "<tr>
            <td>".$order['order_id']."</td>
            <td>".$order['customer_id']."</td>
            <td>".$order['customer_username']."</td>
            <td>".$order['order_date']."</td>
            <td>".$order['name']."</td>
            <td>".$order['description']."</td>
            <td>".$order['quantity']."</td>
            <td>
                <a href='update_order.php?order_id=".$order['order_id']."' class='btn update-btn'>Update Order</a> |
                <a href='delete_order.php?order_id=".$order['order_id']."' class='btn delete-btn' onclick=\"return confirm('Are you sure you want to delete this order?');\">Delete Order</a>
            </td>
        </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No orders found</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>

<?php
$conn->close();
?>
