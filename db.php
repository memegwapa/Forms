<?php
// ---------- DATABASE CONFIGURATION ----------

// Detect environment
$isLocal = ($_SERVER['SERVER_NAME'] === 'localhost');

// Local XAMPP setup
if ($isLocal) {
    $servername = "localhost";
    $username   = "root";
    $password   = "";               // XAMPP default
    $database   = "data_connector"; // your local DB
    $port       = 3306;
} else {
    // Coolify setup (read from environment variables)
    $servername = getenv('DB_HOST') ?: 'mariadb';   // service name of MariaDB container
    $username   = getenv('DB_USERNAME') ?: 'mariadb';
    $password   = getenv('DB_PASSWORD') ?: 'your_password';
    $database   = getenv('DB_DATABASE') ?: 'user_db'; // your database in Coolify
    $port       = getenv('DB_PORT') ?: 3306;
}

// ---------- CONNECT TO DATABASE ----------
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");
?>
