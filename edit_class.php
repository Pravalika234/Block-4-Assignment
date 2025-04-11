<?php
    include 'db_connect.php';

    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    $class_id = $_GET['id'] ?? null;

    if ($class_id) {
        $stmt = $conn->prepare("SELECT * FROM Classes WHERE Class_ID = ?");
        $stmt->bind_param("i", $class_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $class = $result->fetch_assoc();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $class_name = $_POST['class_name'];
        $capacity = $_POST['capacity'];
        $teacher_id = $_POST['teacher_id'];

        $stmt = $conn->prepare("UPDATE Classes SET Class_Name=?, Capacity=?, Teacher_ID=? WHERE Class_ID=?");
        $stmt->bind_param("siii", $class_name, $capacity, $teacher_id, $class_id);

        if (!$stmt->execute()) {
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
    <title>Edit Class</title>
    <link rel="stylesheet" href="edit_class.css">
</head>
<body>
    <form method="POST" class="edit-class">
        <h1>Edit Class</h1>
        <input type="text" name="class_name" value="<?php echo $class['Class_Name']; ?>" required>
        <input type="number" name="capacity" value="<?php echo $class['Capacity']; ?>" required>
        <input type="number" name="teacher_id" value="<?php echo $class['Teacher_ID']; ?>" required>
        <button type="submit">Done</button>
        <button type="button" onclick="window.location.href='Classes.php'">Cancel</button>
    </form>
</body>
</html>