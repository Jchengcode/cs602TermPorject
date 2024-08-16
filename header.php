<?php
// header.php
// Common header file to be included in other pages.

session_start();
require_once('database.php');

// Ensure session user_id is set for customer actions
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$customer_id = $_SESSION['user_id'];

// Fetch customer information (if needed in the header)
$sql = "SELECT username FROM users WHERE id = $customer_id";
$result = $conn->query($sql);
$customer = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Platform</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<nav>
    <a href="index.php">Home</a>
    <span style="float:right;">Logged in as: <?php echo htmlspecialchars($customer['username']); ?></span>
</nav>
