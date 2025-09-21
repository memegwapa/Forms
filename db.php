<?php
// Read database credentials from environment variables
$servername = getenv('DB_HOST') ?: 'localhost';   // fallback to localhost
$username   = getenv('DB_USER') ?: 'root';
$password   = getenv('DB_PASS') ?: '';
$database   = getenv('DB_NAME') ?: 'data_connector';

// Create MySQLi connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8");
?>
