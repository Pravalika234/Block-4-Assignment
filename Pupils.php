<?php
    // Connecting to the database
    include 'db_connect.php';

    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
    }

     // Handle form submission for adding a new pupil
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pupilId = $_POST['pupil_id'];
        $pupilName = $_POST['pupil_name'];
        $className = $_POST['class_name'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $medicalInfo = $_POST['medical_info'];

        $insertQuery = "INSERT INTO Pupils (Pupil_ID, Name, Age, Address, Medical_Information) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("isiss", $pupilId, $pupilName, $age, $address, $medicalInfo);
        $insertStmt->execute();

        $pupilId = $insertStmt->insert_id;

        $classQuery = "SELECT Class_ID FROM Classes WHERE Class_Name = ?";
        $classStmt = $conn->prepare($classQuery);
        $classStmt->bind_param("s", $className);
        $classStmt->execute();
        $classResult = $classStmt->get_result();

        if ($classResult->num_rows > 0) {
            $classRow = $classResult->fetch_assoc();
            $classId = $classRow['Class_ID'];

            $insertClassPupilQuery = "INSERT INTO Classes_Pupils (Class_ID, Pupil_ID) VALUES (?, ?)";
            $insertClassPupilStmt = $conn->prepare($insertClassPupilQuery);
            $insertClassPupilStmt->bind_param("ii", $classId, $pupilId);
            $insertClassPupilStmt->execute();
        }
    }

    // Query to fetch pupils data
    $query = "SELECT Pupils.Pupil_ID, Pupils.Name AS Pupil_Name, Pupils.Age, Pupils.Address, Pupils.Medical_Information, Classes.Class_Name, Classes.Class_ID
              FROM Pupils
              JOIN Classes_Pupils ON Pupils.Pupil_ID = Classes_Pupils.Pupil_ID
              JOIN Classes ON Classes_Pupils.Class_ID = Classes.Class_ID
              WHERE Pupils.Name LIKE ?";
    
    $search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
    $stmt = $conn->prepare($query);
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
    <link rel="stylesheet" href="pupils.css">
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

    <!-- Pupils Section -->
    <section class="pupils-section">
        <div class="container">
            <h1>Pupils</h1>

            <!-- Search Pupils -->
            <form method="GET" class="pupils-search">
                <input type="text" name="search" placeholder="Search Pupils" 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit">Search</button>
            </form>

            <!-- Add New Pupil -->
            <form method="POST" class="add-pupil">
                <input type="number" name="pupil_id" placeholder="Pupil ID" required>
                <input type="text" name="pupil_name" placeholder="Pupil Name" required>
                <input type="text" name="class_name" placeholder="Class Name" required>
                <input type="number" name="age" placeholder="Age" required>
                <input type="text" name="address" placeholder="Address" required>
                <input type="text" name="medical_info" placeholder="Medical Information" required>
                <button type="submit">Add Pupil</button>
            </form>

            <!-- Displaying Pupil Data -->
            <?php if ($result->num_rows > 0): ?>
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Pupil ID</th>
                        <th>Pupil Name</th>
                        <th>Class Name</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Medical Information</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Fetching and displaying pupil data -->
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Pupil_ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Pupil_Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['Class_Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['Age']); ?></td>
                            <td><?php echo htmlspecialchars($row['Address']); ?></td>
                            <td><?php echo htmlspecialchars($row['Medical_Information']); ?></td>
                            <td>
                                <!-- Edit and Delete Actions -->
                                <a href='edit_pupil.php?id=<?php echo $row['Pupil_ID']; ?>'>Edit</a> |
                                <a href='delete_pupil.php?id=<?php echo $row['Pupil_ID']; ?>' >Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>No pupil data available.</p>
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