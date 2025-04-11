<?php
    // Connecting to the database
    include 'db_connect.php';

    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    // Handle form submission for editing a teacher
    $teacher_id = $_GET['id'] ?? null;

    if ($teacher_id) {
        $stmt = $conn->prepare("SELECT * FROM Teachers WHERE Teacher_ID = ?");
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $teacher = $result->fetch_assoc();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $salary = $_POST['salary'];
        $background_check = $_POST['background_check'];

        $stmt = $conn->prepare("UPDATE Teachers SET First_Name=?, Last_Name=?, Address=?, Email=?, `Phone Number`=?, Salary=?, `Background Check`=? WHERE Teacher_ID=?");
        $stmt->bind_param("sssssisi", $first_name, $last_name, $address, $email, $phone_number, $salary, $background_check, $teacher_id);

        if (!$stmt->execute()) {
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
    <title>Edit Teacher</title>
    <link rel="stylesheet" href="edit_teacher.css">
</head>
<body>
    <!-- Edit Teacher -->
    <form method="POST" class="edit-teacher">
        <h1>Edit Teacher</h1>
        <input type="text" name="first_name" value="<?php echo $teacher['First_Name']; ?>" required>
        <input type="text" name="last_name" value="<?php echo $teacher['Last_Name']; ?>" required>
        <input type="text" name="address" value="<?php echo $teacher['Address']; ?>" required>
        <input type="email" name="email" value="<?php echo $teacher['Email']; ?>" required>
        <input type="text" name="phone_number" value="<?php echo $teacher['Phone Number']; ?>" required>
        <input type="number" name="salary" value="<?php echo $teacher['Salary']; ?>" required>
        <input type="text" name="background_check" value="<?php echo $teacher['Background Check']; ?>" required>
        <button type="submit">Done</button>
        <button type="button" onclick="window.location.href='Teachers.php'">Cancel</button>
    </form>
</body>
</html>