<?php
session_start();
require_once('database.php');

$sql = "SELECT * FROM users WHERE role='customer'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Customers</title>
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
</div>

<div class="container">
    <h1 style="text-align:center;">List of Customers</h1>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row['id']."</td>
                        <td>".$row['username']."</td>
                        <td>".$row['created_at']."</td>
                        <td>
                            <a href='view_customer_orders.php?customer_id=".$row['id']."'>View Orders</a> | 
                            <a href='delete_customer.php?id=".$row['id']."' onclick=\"return confirm('Are you sure you want to delete this customer?');\">Delete</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4' style='text-align: center;'>No customers found</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>
