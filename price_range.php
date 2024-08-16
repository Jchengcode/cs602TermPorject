<?php
include '../config/database.php';

header('Content-Type: application/json');

$low = $_GET['low'];
$high = $_GET['high'];
$sql = "SELECT * FROM products WHERE price BETWEEN $low AND $high";
$result = $conn->query($sql);

$products = array();
while($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);

$conn->close();
?>
