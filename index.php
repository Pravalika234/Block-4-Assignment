<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "Alphonsus_Primary_School";
    $error = "";

    $conn = new mysqli
    ($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT Password FROM Login_Form WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($raw_password);
        $stmt->fetch();

        if ($stmt->num_rows > 0 && $password == $raw_password) {
                $_SESSION['username'] = $username; 
                header("Location: Home.php");
        } else {
            $error = "Invalid username or password.";
        }

        $stmt->close();
    }
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Images/Logo.png" type="image/png">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>
<body>
    <img src="Images/Logo.png" alt="logo">
    <h1>Login Form</h1>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>

        <br>
        <span style="color: red;"> <?php echo $error; ?> </span>
    </form> 
</body>
</html>