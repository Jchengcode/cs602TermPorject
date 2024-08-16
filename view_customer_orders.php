<?php
session_start();
require_once('database.php');

if (!isset($_GET['customer_id'])) {
    echo "Customer ID is missing.";
    exit();
}

$customer_id = $_GET['customer_id'];

// Fetch orders for the specific customer
$sql = "SELECT * FROM orders WHERE customer_id=$customer_id";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customer Orders</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="main-header">
    <div class="logo">
        <a href="index.php"><h2>CS602</h2></a>
    </div>
    <div class="main-nav-links">
        <a href="admin_dashboard.php">Admin Dashboard</a>
        <a href="list_products.php?admin=true">Product List</a>
        <a href="add_product.php">Add Product</a>
        <a href="manage_orders.php">Manage Orders</a>
    </div>
</div>

<div class="container">
    <h1 style="text-align:center;">Customer Orders</h1>
    <?php
    if ($result->num_rows > 0) {
        while($order = $result->fetch_assoc()) {
            echo "<div class='order-card'>";
            echo "<h2>Order ID: " . $order['id'] . "</h2>";
            echo "<p>Order Date: " . $order['order_date'] . "</p>";
            echo "<p>Items:</p><ul>";

            $sql_items = "SELECT oi.*, p.name, p.description 
                          FROM order_items oi
                          JOIN products p ON oi.product_id = p.id
                          WHERE oi.order_id=" . $order['id'];
            $result_items = $conn->query($sql_items);

            while($item = $result_items->fetch_assoc()) {
                echo "<li><strong>Product:</strong> " . $item['name'] . "<br>";
                echo "<strong>Description:</strong> " . $item['description'] . "<br>";
                echo "<strong>Quantity:</strong> " . $item['quantity'] . "</li>";
            }

            echo "</ul>";
            echo "</div>";
        }
    } else {
        echo "<p>No orders found for this customer.</p>";
    }
    ?>
</div>

</body>
</html>

<?php
$conn->close();
?>
