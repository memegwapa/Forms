<?php
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    // Local XAMPP setup
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $database   = "data_connector";
    $port       = 3306;
} else {
    // Coolify setup
    $servername = getenv('DB_HOST') ?: 'mariadb';   // service name in Coolify
    $username   = getenv('DB_USERNAME') ?: 'mariadb';
    $password   = getenv('DB_PASSWORD') ?: 'your_password';
    $database   = getenv('DB_DATABASE') ?: 'user_db'; // your chosen DB name
    $port       = getenv('DB_PORT') ?: 3306;
}

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
} else {
    $conn->set_charset("utf8mb4");
}
?>
