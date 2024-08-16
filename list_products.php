<?php
session_start();
require_once('database.php');

// Determine if the user is an admin or a customer
$is_admin = isset($_GET['admin']) && $_GET['admin'] == 'true';

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Products</title>
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

<div class="search-container">
    <form method="get" action="search_product.php">
        <input type="text" name="query" placeholder="Search for products...">
        <input type="submit" value="Search">
    </form>
    <form method="get" action="search_product.php">
        <label for="min_price">Min Price:</label>
        <input type="number" name="min_price" id="min_price" step="0.01">
        <label for="max_price">Max Price:</label>
        <input type="number" name="max_price" id="max_price" step="0.01">
        <input type="submit" value="Search by Price Range">
    </form>
</div>

<div class="container">
    <h1 style="text-align:center;">List of Products</h1>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock Quantity</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row['id']."</td>
                        <td>".$row['name']."</td>
                        <td>".$row['description']."</td>
                        <td>".$row['price']."</td>
                        <td>".$row['stock_quantity']."</td>
                        <td>";
                if ($is_admin) {
                    echo "<form method='post' action='update_stock.php' class='update-stock-form'>
                            <input type='hidden' name='product_id' value='".$row['id']."'>
                            <input type='number' name='new_stock_quantity' value='".$row['stock_quantity']."' min='0'>
                            <input type='submit' value='Update Stock' class='update-stock-btn'>
                          </form>
                          <a href='delete_product.php?id=".$row['id']."' onclick=\"return confirm('Are you sure you want to delete this product?');\">Delete</a>";
                } else {
                    echo "<form method='post' action='shopping_cart.php'>
                            <input type='hidden' name='product_id' value='".$row['id']."'>
                            <div class='quantity-controls'>
                                <button type='button' onclick='decrementQuantity(this)'>-</button>
                                <input type='number' name='quantity' value='1' min='1' max='".$row['stock_quantity']."' readonly>
                                <button type='button' onclick='incrementQuantity(this)'>+</button>
                            </div>
                            <input type='submit' value='Add to Cart'>
                          </form>";
                }
                echo "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align: center;'>No products found</td></tr>";
        }
        ?>
        </tbody>
    </table>
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
