<?php
session_start(); // Start the session
require_once('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $_SESSION['user_id'] = $customer_id;

    header("Location: customer_dashboard.php");
    exit();
}

$sql = "SELECT * FROM users WHERE role = 'customer'";
$result = $conn->query($sql);
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link rel="stylesheet" href="css/main.css">

    </head>
    <body>
    <header class="main-header">
        <div class="logo">
            <a href="index.php"><h2>CS602</h2></a>
        </div>
        <nav class="main-nav">
            <a href="register.php">Register</a>
            <a href="admin_dashboard.php">Admin</a>
        </nav>
    </header>

    <div class="hero-section">
        <div class="hero-content">
            <h1>Welcome to the Shopping Cart Platform</h1>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label for="customer_id">Select Customer:</label>
                <select name="customer_id" id="customer_id" required>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row['id']."'>".$row['username']."</option>";
                        }
                    }
                    ?>
                </select>
                <input type="submit" value="Start Shopping">
            </form>
        </div>
        <div class="hero-image">
            <img src="images/shopping_cart.png" alt="Shopping Cart">
        </div>
    </div>
    </body>
    </html>

<?php
$conn->close();
?>