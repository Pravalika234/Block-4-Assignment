<?php
    // Connecting to the database
    include 'db_connect.php';

    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    // Handle form submission for adding a new parent
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $parentId = $_POST['parent_id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phone_number'];

        $insertQuery = "INSERT INTO `Parents/Guardians` (Parent_ID, Name, Address, Email, `Phone Number`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("issss", $parentId, $name, $address, $email, $phoneNumber);
        $stmt->execute();
    }

    // Query to fetch parents data
    $query = "SELECT Parent_ID, Name, Address, Email, `Phone Number` FROM `Parents/Guardians` WHERE Name LIKE ?";
    $search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query was successful
    if ($result === false) {
        die("Error executing query: " . $conn->error);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Images/Logo.png" type="image/png">
    <link rel="stylesheet" href="parents.css">
    <script src="https://kit.fontawesome.com/e39c4d7f07.js" crossorigin="anonymous"></script>
    <title>Parents</title>
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <ul>
        <li class="logo"><a href="Home.php"><img src="Images/Logo.png" alt="logo"></a></li>
        <li><a href="Home.php">Home</a></li>
        <li><a href="Classes.php">Classes</a></li>
        <li><a href="Pupils.php">Pupils</a></li>
        <li><a href="Parents.php">Parents</a></li>
        <li><a href="Teachers.php">Teachers</a></li>
        <li class="logout-btn">
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </li>
        </ul>
    </nav>

    <!-- Parents Table -->
    <section class="parents-section">
        <div class="container">
            <h1>Parents</h1>

            <form method="GET" class="parents-search">
                <input type="text" name="search" placeholder="Search Parents" 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit">Search</button>
            </form>

            <form method="POST" class="add-parent">
                <input type="number" name="parent_id" placeholder="Parent ID" required>
                <input type="text" name="name" placeholder="Parent Name" required>
                <input type="text" name="address" placeholder="Address" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone_number" placeholder="Phone Number" required>
                <button type="submit">Add Parent</button>
            </form>

            <?php if ($result->num_rows > 0): ?>
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Parent ID</th>
                        <th>Parent Name</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Parent_ID']); ?></td>
                        <td><?php echo htmlspecialchars($row['Name']); ?></td>
                        <td><?php echo htmlspecialchars($row['Address']); ?></td>
                        <td><?php echo htmlspecialchars($row['Email']); ?></td>
                        <td><?php echo htmlspecialchars($row['Phone Number']); ?></td>
                        <td>
                            <a href="edit_parent.php?id=<?php echo $row['Parent_ID']; ?>">Edit</a> |
                            <a href="delete_parent.php?id=<?php echo $row['Parent_ID']; ?>">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No parents found.</p>
            <?php endif; ?>
        </div>
    </section>

    <br>
    <br>

    <!-- Footer Section -->
    <section class="footer-section">
        <div class="footer-content">
            <h3>Contact Us</h3>
            <p>123 School Road, City, Country</p>
            <p>Email: info@school.com</p>
            <p>Phone: +123 456 7890</p>

            <h3>Follow Us</h3>
            <div class="icons2">
                <i class="fa fa-facebook"></i>
                <i class="fa fa-twitter"></i>
                <i class="fa fa-instagram"></i>
                <i class="fa fa-linkedin"></i>
            </div>
        </div>
    </section>
</body>
</html>