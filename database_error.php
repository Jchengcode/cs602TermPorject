<?php
// database_error.php
// Displays an error message when a database connection fails.

$error_message = filter_input(INPUT_GET, 'error', FILTER_SANITIZE_STRING);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Error</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<div class="container">
    <h1>Database Error</h1>
    <p><?php echo htmlspecialchars($error_message); ?></p>
    <a href="index.php">Go back to Home</a>
</div>
</body>
</html>
