<?php
// edit_product.php
// Allows admins to edit the details of a product.

require_once('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    $sql = "UPDATE products SET 
            name='$name', 
            description='$description', 
            price=$price, 
            stock_quantity=$stock_quantity 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: list_products.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        die("Error: Product ID is missing.");
    }

    $id = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT * FROM products WHERE id=$id";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error: Could not execute query: " . $conn->error);
    }

    $product = $result->fetch_assoc();

    if (!$product) {
        die("Error: No product found with the given ID.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="container">
    <nav>
        <a href="index.php">Home</a> |
        <a href="add_product.php">Add Product</a> |
        <a href="list_customers.php">List of Customers</a> |
        <a href="list_products.php">Edit Product</a>
    </nav>
    <h1>Edit Product</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
        Name: <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br>
        Description: <input type="text" name="description" value="<?php echo htmlspecialchars($product['description']); ?>" required><br>
        Price: <input type="text" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br>
        Stock Quantity: <input type="text" name="stock_quantity" value="<?php echo htmlspecialchars($product['stock_quantity']); ?>" required><br>
        <input type="submit" value="Update Product">
    </form>
</div>
</body>
</html>
