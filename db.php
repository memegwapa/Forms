<?php
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    // Local XAMPP setup
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $database   = "data_connector";
} else {
    // Coolify / Docker setup (values come from Environment Variables in Coolify)
    $servername = getenv('DB_HOST') ?: 'mariadb';
    $username   = getenv('DB_USERNAME') ?: 'mariadb';
    $password   = getenv('DB_PASSWORD') ?: 'password_from_coolify';
    $database   = getenv('DB_DATABASE') ?: 'user_db';
}

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
} else {
    $conn->set_charset("utf8mb4");
}
?>
