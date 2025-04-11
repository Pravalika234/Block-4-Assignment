<?php
    // Connecting to the database
    include 'db_connect.php';

    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    // Handle form submission for deleting a teacher
    $teacher_id = $_GET['id'] ?? null;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $conn->prepare("DELETE FROM Teachers WHERE Teacher_ID = ?");
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();

        if ($stmt->error) {
            echo "Error: " . $stmt->error;
        } else {
            header("Location: Teachers.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Teacher</title>
    <link rel="stylesheet" href="delete_teacher.css">
</head>
<body>
    <!-- Delete Teacher -->
    <form method="POST" class="delete-teacher">
        <p>Are you sure you want to delete this teacher?</p>
        <button type="submit">Delete Teacher</button>
        <button type="button" onclick="window.location.href='Teachers.php'">Cancel</button>
    </form>
</body>
</html>