<?php
    // Connecting to the database
    include 'db_connect.php'; 

    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    // Handle form submission for adding a new teacher
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $teacher_id = $_POST['teacher_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $salary = $_POST['salary'];
        $background_check = $_POST['background_check'];
    
        $stmt = $conn->prepare("INSERT INTO Teachers (Teacher_ID, First_Name, Last_Name, Address, Email, `Phone Number`, Salary, `Background Check`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssis", $teacher_id, $first_name, $last_name, $address, $email, $phone_number, $salary, $background_check);
    
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        } else {
            echo "Teacher added successfully.";
        }
    }

    // Query to fetch teachers data
    $stmt = $conn->prepare("SELECT * FROM Teachers");
    $stmt->execute();
    $result = $stmt->get_result();

    $search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
    $stmt = $conn->prepare("SELECT * FROM Teachers WHERE First_Name LIKE ? OR Last_Name LIKE ?");
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Images/Logo.png" type="image/png">
    <link rel="stylesheet" href="teachers.css">
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

    <!-- Teachers Section -->
    <section class="teachers-section">
        <div class="container">
            <h1>Teachers</h1>

                <form method="GET" class="teachers-search">
                    <input type="text" name="search" placeholder="Search Teachers" 
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit">Search</button>
                </form>

                <form method="POST" class="add-teacher">
                    <input type="text" name="teacher_id" placeholder="Teacher ID" required>
                    <input type="text" name="first_name" placeholder="First Name" required>
                    <input type="text" name="last_name" placeholder="Last Name" required>
                    <input type="text" name="address" placeholder="Address" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="phone_number" placeholder="Phone Number" required>
                    <input type="number" name="salary" placeholder="Salary" required>
                    <input type="text" name="background_check" placeholder="Background Check" required>
                    <button type="submit">Add Teacher</button>
                </form>

                <?php if ($result->num_rows > 0): ?>
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Teacher ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Salary</th>
                            <th>Background Check</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Fetching and displaying teachers data -->
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Teacher_ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['First_Name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Last_Name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Address']); ?></td>
                                <td><?php echo htmlspecialchars($row['Email']); ?></td>
                                <td><?php echo htmlspecialchars($row['Phone Number']); ?></td>
                                <td><?php echo htmlspecialchars($row['Salary']); ?></td>
                                <td><?php echo htmlspecialchars($row['Background Check']); ?></td>
                                <td>
                                    <!-- Edit and Delete Actions -->
                                    <a href='edit_teacher.php?id=<?php echo $row['Teacher_ID']; ?>'>Edit</a> |
                                    <a href='delete_teacher.php?id=<?php echo $row['Teacher_ID']; ?>' >Delete</a>
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