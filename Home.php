<?php
    // Connecting to the database
    include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Images/Logo.png" type="image/png">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/e39c4d7f07.js" crossorigin="anonymous"></script>
    <title>St. Alphonsus Primary School</title>
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

    <!-- Page Section -->
    <section class="page-section">
        <div class="container">
            <h1><strong>St. Alphonsus Primary School.</strong></h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque, veritatis sunt eaque sed quibusdam nostrum quas laudantium in fugit molestiae ea quia soluta cumque animi ipsum deserunt mollitia, eum dolorum!</p>
            <img src="Images/school.jpg" alt="school">
        </div>
    </section>

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