<?php
// customer_dashboard.php
// Displays the customer dashboard.

session_start();
require_once('database.php');

// Check if the user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$customer_id = $_SESSION['user_id'];

// Fetch customer information
$sql = "SELECT username FROM users WHERE id = $customer_id";
$result = $conn->query($sql);
$customer = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="css/main.css">


</head>
<body>

<!-- Header -->
<div class="main-header">
    <div class="logo">
        <a href="index.php"><h2>CS602</h2></a>
    </div>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- Welcome Section -->
<div class="welcome-section">
    <h1>Welcome, <?php echo htmlspecialchars($customer['username']); ?>!</h1>
</div>

<!-- Dashboard Links -->
<div class="dashboard-links">
    <a href="list_products.php">List of Products</a>
    <a href="shopping_cart.php">Shopping Cart</a>
    <a href="my_orders.php">My Orders</a>
</div>

</body>
</html>

<?php
$conn->close();
?>
