<?php
// api.php
// Provides REST APIs in JSON and XML formats for product data.

require_once('database.php');

// Function to convert array to XML
function array_to_xml($data, &$xml_data) {
    foreach($data as $key => $value) {
        if (is_array($value)) {
            if (is_numeric($key)) {
                $key = 'item'.$key; // Deal with numeric keys
            }
            $subnode = $xml_data->addChild($key);
            array_to_xml($value, $subnode);
        } else {
            $xml_data->addChild("$key", htmlspecialchars("$value"));
        }
    }
}

header("Access-Control-Allow-Origin: *"); // Allow cross-origin requests

// Determine the format requested (JSON or XML)
$format = isset($_GET['format']) ? strtolower($_GET['format']) : 'json';

// Initialize response array
$response = [];

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // 1. Product list
    if ($action == 'product_list') {
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        if ($result) {
            while($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response['error'] = "Database query failed.";
        }
    }

    // 2. Product matching a specified name
    if ($action == 'product_search' && isset($_GET['name'])) {
        $name = $conn->real_escape_string($_GET['name']);
        $sql = "SELECT * FROM products WHERE name LIKE '%$name%'";
        $result = $conn->query($sql);

        if ($result) {
            while($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response['error'] = "Database query failed.";
        }
    }

    // 3. Products within a specified price range
    if ($action == 'product_price_range' && isset($_GET['low']) && isset($_GET['high'])) {
        $low = (float)$_GET['low'];
        $high = (float)$_GET['high'];
        $sql = "SELECT * FROM products WHERE price BETWEEN $low AND $high";
        $result = $conn->query($sql);

        if ($result) {
            while($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response['error'] = "Database query failed.";
        }
    }
} else {
    $response['error'] = "No action specified.";
}

// Convert response to JSON or XML
if ($format == 'xml') {
    header("Content-Type: application/xml; charset=UTF-8");
    $xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
    array_to_xml($response, $xml_data);
    echo $xml_data->asXML();
} else {
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($response, JSON_PRETTY_PRINT); // Pretty-print JSON by default
}

$conn->close();
?>
