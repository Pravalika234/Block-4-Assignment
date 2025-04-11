<?php
    // Connecting to the database
    include 'db_connect.php';

    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    // Handle form submission for adding a new class
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $class_id = $_POST['class_id'];
        $class_name = $_POST['class_name'];
        $capacity = $_POST['capacity'];
        $teacher_id = $_POST['teacher_id'];
    
        $stmt = $conn->prepare("INSERT INTO Classes (Class_ID, Class_Name, Capacity, Teacher_ID) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isii", $class_id, $class_name, $capacity, $teacher_id);
    
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }
    }

    // Query to fetch classes data
    $stmt = $conn->prepare("SELECT * FROM Classes");
    $stmt->execute();
    $result = $stmt->get_result();
    
    $search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
    $stmt = $conn->prepare("SELECT * FROM Classes WHERE Class_Name LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Images/Logo.png" type="image/png">
    <link rel="stylesheet" href="classes.css">
    <script src="https://kit.fontawesome.com/e39c4d7f07.js" crossorigin="anonymous"></script>
    <title>St. Alphonsus Primary School</title>
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <ul>
            <li class="logo"><a href="home.php"><img src="Images/Logo.png" alt="logo"></a></li>
            <li><a href="home.php">Home</a></li>
            <li><a href="Classes.php">Classes</a></li>
            <li><a href="Pupils.php">Pupils</a></li>
            <li><a href="Parents.php">Parents</a></li>
            <li><a href="Teachers.php">Teachers</a></li>
            <li class="logout-btn">
                <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </li>         
        </ul>
    </nav>

    <!-- Classes Section -->
    <section class="classes-section">
        <div class="container">
            <h1>Classes</h1>

                <form method="GET" class="classes-search">
                    <input type="text" name="search" placeholder="Search Classes" 
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit">Search</button>
                </form>

                <form method="POST" class="add-class">
                    <input type="number" name="class_id" placeholder="Class ID" required>
                    <input type="text" name="class_name" placeholder="Class Name" required>
                    <input type="number" name="capacity" placeholder="Capacity" required>
                    <input type="number" name="teacher_id" placeholder="Teacher ID" required>
                    <button type="submit">Add Class</button>
                </form>

                <?php if ($result->num_rows > 0): ?>
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Class ID</th>
                            <th>Class Name</th>
                            <th>Capacity</th>
                            <th>Teacher ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Fetching and displaying classes data -->
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Class_ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Class_Name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Capacity']); ?></td>
                                <td><?php echo htmlspecialchars($row['Teacher_ID']); ?></td>
                                <td>
                                    <!-- Edit and Delete Actions -->
                                    <a href='edit_class.php?id=<?php echo $row['Class_ID']; ?>'>Edit</a> |
                                    <a href='delete_class.php?id=<?php echo $row['Class_ID']; ?>' >Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p>No class data available.</p>
                <?php endif; ?>
        </div>
    </section>

    <br>

    <!-- Footer Section -->
    <section class="footer-section">
        <div class="footer"></div>
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