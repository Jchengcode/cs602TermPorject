<?php
// register.php
// Handles user registration.

session_start();
require_once('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    // Check if the username already exists
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Username already taken. Please choose another one.";
    } else {
        // Insert the new user into the database
        $sql = "INSERT INTO users (username, role) VALUES ('$username', 'customer')";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account</title>
    <link rel="stylesheet" href="css/main.css">


</head>
<body>
<div class="main-header">
    <div class="logo">
        <a href="index.php"><h2>CS602</h2></a>
    </div>
    <div class="main-nav">
        <a href="admin_dashboard.php">Admin</a>
    </div>
</div>

<div class="form-container">
    <h1>Create an Account</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <input type="submit" value="Register">
    </form>
    <div class="back-home">
        <a href="index.php" class="back-btn">Back to Home</a>
    </div>
</div>
</body>
</html>
