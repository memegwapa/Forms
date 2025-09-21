<?php
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    // Local XAMPP setup
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $database   = "data_connector";
} else {
    // Coolify setup (read from environment variables)
    $servername = getenv('DB_HOST') ?: 'user_db';
    $username   = getenv('DB_USERNAME') ?: 'mariadb';
    $password   = getenv('DB_PASSWORD') ?: 'your_password';
    $database   = getenv('DB_DATABASE') ?: 'default';
}

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
} else {
    $conn->set_charset("utf8mb4");
}
?>
