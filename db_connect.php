<?php
    $host = "localhost"; // Change if not using localhost
    $username = "root";  // Default XAMPP user
    $password = "";      // Default is empty in XAMPP
    $database = "Alphonsus_Primary_School"; // Database name

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>