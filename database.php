<?php
// database.php
// Database connection settings

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopping_cart";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
