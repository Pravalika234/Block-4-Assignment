<?php
    // Connecting to the database
    include 'db_connect.php';

    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    // Handle form submission for deleting a class
    $class_id = $_GET['id'] ?? null;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $conn->prepare("DELETE FROM Classes WHERE Class_ID = ?");
        $stmt->bind_param("i", $class_id);
        $stmt->execute();

        if ($stmt->error) {
            echo "Error: " . $stmt->error;
        } else {
            header("Location: Classes.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Class</title>
    <link rel="stylesheet" href="delete_class.css">
</head>
<body>
    <!-- Delete Class -->
    <form method="POST" class="delete-class">
        <p>Are you sure you want to delete this class?</p>
        <button type="submit">Delete Class</button>
        <button type="button" onclick="window.location.href='Classes.php'">Cancel</button>
    </form>
</body>
</html>