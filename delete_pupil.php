<?php
    // Connecting to the database
    include 'db_connect.php';

    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    // Handle form submission for deleting a pupil
    $pupil_id = $_GET['id'] ?? null;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conn->autocommit(false);

        $stmt1 = $conn->prepare("DELETE FROM Classes_Pupils WHERE Pupil_ID = ?");
        $stmt1->bind_param("i", $pupil_id);
        $stmt1->execute();

        $stmt2 = $conn->prepare("DELETE FROM Pupils WHERE Pupil_ID = ?");
        $stmt2->bind_param("i", $pupil_id);
        $stmt2->execute();

        if ($stmt1->error || $stmt2->error) {
            $conn->rollback();
            echo "Error: " . ($stmt1->error ?: $stmt2->error);
        } else {
            $conn->commit();
            header("Location: Pupils.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Pupil</title>
    <link rel="stylesheet" href="delete_pupil.css">
</head>
<body>
    <!-- Delete Pupil -->
    <form method="POST" class="delete-pupil">
        <p>Are you sure you want to delete this pupil?</p>
        <button type="submit">Delete Pupil</button>
        <button type="button" onclick="window.location.href='Pupils.php'">Cancel</button>
    </form>
</body>
</html>