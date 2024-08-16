<?php
// update_order.php
// Allows the admin to update the quantity of products in an order but not to add new products.

require_once('database.php');

$order_id = $_GET['order_id'];

// Fetch the order items for this order
$sql = "SELECT oi.*, p.name, p.description FROM order_items oi 
        JOIN products p ON oi.product_id = p.id 
        WHERE oi.order_id = $order_id";
$result = $conn->query($sql);

// Handle form submission to update quantities or delete items
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        foreach ($_POST['items'] as $item_id => $new_quantity) {
            if ($new_quantity > 0) {
                // Update the quantity
                $sql = "UPDATE order_items SET quantity = $new_quantity WHERE id = $item_id";
                $conn->query($sql);
            } elseif ($new_quantity == 0) {
                // Delete the item if the new quantity is zero
                $sql = "DELETE FROM order_items WHERE id = $item_id";
                $conn->query($sql);
            }
        }
    }

    if (isset($_POST['delete_order'])) {
        // Delete the entire order and all associated items
        $sql = "DELETE FROM order_items WHERE order_id = $order_id";
        $conn->query($sql);

        $sql = "DELETE FROM orders WHERE id = $order_id";
        $conn->query($sql);

        header("Location: manage_orders.php");
        exit();
    }

    header("Location: update_order.php?order_id=$order_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="main-header">
    <div class="back-arrow">
        <a href="manage_orders.php"><img src="images/backArrow.png" alt="Back to Orders"></a>
    </div>
    <div class="main-nav-links">
        <a href="admin_dashboard.php">Admin Dashboard</a>
        <a href="list_products.php?admin=true">Product List</a>
        <a href="add_product.php">Add Product</a>
        <a href="manage_orders.php">Manage Orders</a>
    </div>
</div>

<div class="container">
    <h1>Update Order #<?php echo $order_id; ?></h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?order_id=".$order_id; ?>">
        <table>
            <tr>
                <th>Product Name</th>
                <th>Description</th>
                <th>Current Quantity</th>
                <th>New Quantity</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($item = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$item['name']."</td>
                            <td>".$item['description']."</td>
                            <td>".$item['quantity']."</td>
                            <td>
                                <div class='quantity-controls'>
                                    <button type='button' onclick='decrementQuantity(this)'>-</button>
                                    <input type='number' name='items[".$item['id']."]' value='".$item['quantity']."' min='0' readonly>
                                    <button type='button' onclick='incrementQuantity(this)'>+</button>
                                </div>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No items found for this order</td></tr>";
            }
            ?>
        </table>
        <div class="form-actions">
            <input type="submit" name="update" value="Update Quantities" class="update-btn">
            <input type="submit" name="delete_order" value="Delete Order" class="delete-order-btn">
        </div>
    </form>
</div>

<script>
    function incrementQuantity(button) {
        let quantityInput = button.previousElementSibling;
        quantityInput.value = parseInt(quantityInput.value) + 1;
    }

    function decrementQuantity(button) {
        let quantityInput = button.nextElementSibling;
        if (parseInt(quantityInput.value) > 0) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
        }
    }
</script>

</body>
</html>

<?php
$conn->close();
?>
