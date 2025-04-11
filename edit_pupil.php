<?php
    // Connecting to the database
    include 'db_connect.php';

    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    // Handle form submission for editing a pupil
    $class_id = $_GET['id'] ?? null;

    if ($class_id) {
        $stmt = $conn->prepare("SELECT * FROM Pupils WHERE Pupil_ID = ?");
        $stmt->bind_param("i", $class_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $class = $result->fetch_assoc();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $medical_info = $_POST['medical_info'];

        $stmt = $conn->prepare("UPDATE Pupils SET Name=?, Age=?, Address=?, Medical_Information=? WHERE Pupil_ID=?");
        $stmt->bind_param("ssssi", $name, $age, $address, $medical_info, $class_id);

        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        } else {
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
    <title>Edit Class</title>
    <link rel="stylesheet" href="edit_pupil.css">
</head>
<body>
    <!-- Edit Pupil -->
    <form method="POST" class="edit-pupil">
        <h1>Edit Pupil</h1>
        <input type="text" name="name" value="<?php echo $class['Name']; ?>" required>
        <input type="number" name="age" value="<?php echo $class['Age']; ?>" required>
        <input type="text" name="address" value="<?php echo $class['Address']; ?>" required>
        <input type="text" name="medical_info" value="<?php echo $class['Medical_Information']; ?>" required>
        <button type="submit">Done</button>
        <button type="button" onclick="window.location.href='Pupils.php'">Cancel</button>
    </form>
</body>
</html>