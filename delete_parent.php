<?php
    // Connecting to the database
    include 'db_connect.php';

    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    // Handle form submission for deleting a parent
    $parent_id = $_GET['id'] ?? null;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $conn->prepare("DELETE FROM `Parents/Guardians` WHERE Parent_ID = ?");
        $stmt->bind_param("i", $parent_id);
        $stmt->execute();

        if ($stmt->error) {
            echo "Error: " . $stmt->error;
        } else {
            header("Location: Parents.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Parent</title>
    <link rel="stylesheet" href="delete_parent.css">
</head>
<body>
    <!-- Delete Parent -->
    <form method="POST" class="delete-parent">
        <p>Are you sure you want to delete this parent?</p>
        <button type="submit">Delete Parent</button>
        <button type="button" onclick="window.location.href='Parents.php'">Cancel</button>
    </form>
</body>
</html>