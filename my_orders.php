<?php
// my_orders.php
// Displays the list of orders placed by the currently logged-in customer.

session_start();
require_once('database.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$customer_id = $_SESSION['user_id'];

// Fetch orders for the logged-in customer
$sql = "SELECT * FROM orders WHERE customer_id=$customer_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="css/main.css">


</head>
<body>
<div class="main-header">
    <div class="logo">
        <a href="index.php"><h2>CS602</h2></a>
    </div>
    <div class="main-nav">
        <a href="customer_dashboard.php">Customer Dashboard</a>
        <a href="list_products.php">Product List</a>
        <a href="shopping_cart.php">
            <img src="images/shopping_cart.png" alt="Shopping Cart" style="height: 24px; vertical-align: middle;">
        </a>
    </div>
</div>

<div class="container">
    <h1 style="text-align: center;">My Orders</h1>
    <?php
    if ($result->num_rows > 0) {
        while($order = $result->fetch_assoc()) {
            // Fetch items for this order
            $sql_items = "SELECT oi.*, p.name, p.description 
                          FROM order_items oi
                          JOIN products p ON oi.product_id = p.id
                          WHERE oi.order_id=" . $order['id'];
            $result_items = $conn->query($sql_items);

            if ($result_items->num_rows > 0) {
                echo "<div class='order-card'>";
                echo "<h2>Order ID: " . $order['id'] . "</h2>";
                echo "<p>Order Date: " . $order['order_date'] . "</p>";
                echo "<h3>Items:</h3><ul>";

                while($item = $result_items->fetch_assoc()) {
                    echo "<li><strong>Product:</strong> " . $item['name'] . "<br><strong>Description:</strong> " . $item['description'] . "<br><strong>Quantity:</strong> " . $item['quantity'] . "</li>";
                }

                echo "</ul>";
                echo "</div>";
            }
        }
    } else {
        echo "<p style='text-align: center;'>No orders found.</p>";
    }
    ?>
</div>
</body>
</html>

<?php
$conn->close();
?>
