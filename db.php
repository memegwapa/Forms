<?php
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    // Local XAMPP setup
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $database   = "data_connector";
} else {
    // Coolify setup
    $servername = "mariadb";
    $username   = "mariadb";
    $password   = "your_password_from_coolify";
    $database   = "user_db";
}

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
} else {
    $conn->set_charset("utf8mb4");
}
?>
