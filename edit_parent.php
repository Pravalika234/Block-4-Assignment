<?php
    // Connecting to the database
    include 'db_connect.php';

    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    // Handle form submission for editing a parent
    $parent_id = $_GET['id'] ?? null;

    if ($parent_id) {
        $stmt = $conn->prepare("SELECT * FROM `Parents/Guardians` WHERE Parent_ID = ?");
        $stmt->bind_param("i", $parent_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $class = $result->fetch_assoc();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $parent_name = $_POST['parent_name'];
        $parent_email = $_POST['parent_email'];
        $parent_address = $_POST['parent_address'];
        $parent_phone = $_POST['parent_phone'];

        $stmt = $conn->prepare("UPDATE `Parents/Guardians` SET Name=?, Email=?, Address=?, `Phone Number`=? WHERE Parent_ID=?");
        $stmt->bind_param("ssssi", $parent_name, $parent_email, $parent_address, $parent_phone, $parent_id);

        if (!$stmt->execute()) {
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
    <title>Edit Parent</title>
    <link rel="stylesheet" href="edit_parent.css">
</head>
<body>
    <!-- Edit Parent -->
    <form method="POST" class="edit-parent">
        <h1>Edit Parent</h1>
        <input type="text" id="parent_name" name="parent_name" value="<?php echo $class['Name']; ?>" required>
        <input type="email" id="parent_email" name="parent_email" value="<?php echo $class['Email']; ?>" required>
        <input type="text" id="parent_address" name="parent_address" value="<?php echo $class['Address']; ?>" required>
        <input type="text" id="parent_phone" name="parent_phone" value="<?php echo $class['Phone Number']; ?>" required>
        <button type="submit">Done</button>
        <button type="button" onclick="window.location.href='Parents.php'">Cancel</button>
    </form>
</body>
</html>