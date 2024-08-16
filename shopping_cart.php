<?php
session_start();
require_once('database.php');

$customer_id = $_SESSION['user_id'];

// Ensure the cart is specific to the current customer
if (!isset($_SESSION['cart'][$customer_id])) {
    $_SESSION['cart'][$customer_id] = array();
}

// Handle restoring stock when an order is deleted
if (isset($_GET['action']) && $_GET['action'] == 'delete_order') {
    $order_id = $_GET['order_id'];

    // Get the order items
    $sql = "SELECT product_id, quantity FROM order_items WHERE order_id = $order_id";
    $result = $conn->query($sql);

    // Restore the stock for each product in the order
    while ($item = $result->fetch_assoc()) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];

        $sql = "UPDATE products SET stock_quantity = stock_quantity + $quantity WHERE id = $product_id";
        $conn->query($sql);
    }

    // Delete the order items
    $sql = "DELETE FROM order_items WHERE order_id = $order_id";
    $conn->query($sql);

    // Delete the order
    $sql = "DELETE FROM orders WHERE id = $order_id";
    $conn->query($sql);

    // Redirect back to the manage orders page after deletion
    header("Location: admin_orders.php");
    exit();
}

// Handle adding a product to the cart
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = intval($_POST['quantity']);  // Convert quantity to an integer

        if (isset($_SESSION['cart'][$customer_id][$product_id])) {
            // Update the quantity directly, instead of adding to the current quantity
            $_SESSION['cart'][$customer_id][$product_id] = $quantity;
        } else {
            $_SESSION['cart'][$customer_id][$product_id] = $quantity;
        }
    }

    header("Location: shopping_cart.php");
    exit();
}

// Handle removing a product from the cart
if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $product_id = $_GET['id'];
    unset($_SESSION['cart'][$customer_id][$product_id]);
    header("Location: shopping_cart.php");
    exit();
}

// Handle submitting the order
if (isset($_GET['action']) && $_GET['action'] == 'submit') {
    $sql = "INSERT INTO orders (customer_id) VALUES ($customer_id)";
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;

        foreach ($_SESSION['cart'][$customer_id] as $product_id => $quantity) {
            $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES ($order_id, $product_id, $quantity)";
            $conn->query($sql);

            // Decrease the product stock by the ordered quantity
            $sql = "UPDATE products SET stock_quantity = stock_quantity - $quantity WHERE id = $product_id";
            $conn->query($sql);
        }

        // Clear the shopping cart for the current customer
        $_SESSION['cart'][$customer_id] = array();

        header("Location: my_orders.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/main.css">


</head>
<body>
<div class="main-header">
    <div class="logo">
        <a href="index.php"><h2>CS602</h2></a>
    </div>
    <div class="main-nav">
        <a href="list_products.php">Product List</a>
        <a href="my_orders.php">My Orders</a>
        <a href="customer_dashboard.php">Customer Dashboard</a>
    </div>
</div>

<div class="shopping-cart-container">
    <h1>Shopping Cart</h1>
    <table>
        <tr>
            <th>Product</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>
        <?php
        if (isset($_SESSION['cart'][$customer_id]) && count($_SESSION['cart'][$customer_id]) > 0) {
            foreach ($_SESSION['cart'][$customer_id] as $product_id => $quantity) {
                $sql = "SELECT name, description, stock_quantity FROM products WHERE id=$product_id";
                $result = $conn->query($sql);
                $product = $result->fetch_assoc();

                echo "<tr>
                        <td>".$product['name']."</td>
                        <td>".$product['description']."</td>
                        <td>
                            <form method='post' action='shopping_cart.php?action=update'>
                                <input type='hidden' name='product_id' value='$product_id'>
                                <button type='button' onclick='decrementQuantity(this)'>-</button>
                                <input type='number' name='quantity' value='$quantity' min='1' max='".$product['stock_quantity']."' readonly>
                                <button type='button' onclick='incrementQuantity(this)'>+</button>
                                <input type='submit' value='Update' class='update-btn'>
                            </form>
                        </td>
                        <td>
                            <a href='shopping_cart.php?action=remove&id=$product_id' class='remove-link'>Remove</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Your cart is empty</td></tr>";
        }
        ?>
    </table>
    <?php if (count($_SESSION['cart'][$customer_id]) > 0): ?>
        <a href="shopping_cart.php?action=submit" class="submit-order-btn">Submit Order</a>
    <?php endif; ?>
</div>

<script>
    function incrementQuantity(button) {
        let quantityInput = button.previousElementSibling;
        let max = quantityInput.getAttribute('max');
        if (parseInt(quantityInput.value) < parseInt(max)) {
            quantityInput.value = parseInt(quantityInput.value) + 1;
        }
    }

    function decrementQuantity(button) {
        let quantityInput = button.nextElementSibling;
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
        }
    }
</script>

</body>
</html>

<?php
$conn->close();
?>
