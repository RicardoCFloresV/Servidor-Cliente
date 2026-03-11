<?php
// Database connection settings
$host = 'localhost';
$dbname = 'testdb';
$dbuser = 'ricardo';
$dbpass = 'ricardo1';

// Create connection
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Using a prepared statement to prevent SQL Injection
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Check the password. 
        // NOTE: This checks plain text for this simple test.
        // In a real application, NEVER store plain text passwords. Use password_hash() instead!
        if ($pass === $row['password']) {
            $message = "<p style='color:green;'>Login successful! Welcome to the server, " . htmlspecialchars($user) . ".</p>";
        } else {
            $message = "<p style='color:red;'>Incorrect password.</p>";
        }
    } else {
        $message = "<p style='color:red;'>User not found.</p>";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Login - ServidorWeb1</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .login-box { border: 1px solid #ccc; padding: 20px; width: 300px; border-radius: 5px; }
        input[type="text"], input[type="password"] { width: 90%; padding: 8px; margin: 10px 0; }
        input[type="submit"] { padding: 10px 15px; cursor: pointer; }
    </style>
</head>
<body>

    <div class="login-box">
        <h2>Login Test</h2>
        <?php echo $message; ?>
        
        <form method="POST" action="">
            <label>Username:</label>
            <input type="text" name="username" required>
            
            <label>Password:</label>
            <input type="password" name="password" required>
            
            <input type="submit" value="Login">
        </form>
    </div>

</body>
</html>