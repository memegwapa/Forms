<?php
// Use environment variables for database credentials
$servername = getenv('DB_HOST') ?: 'mysql'; // Default to 'mysql' if not set
$username   = getenv('DB_USER') ?: 'root';
$password   = getenv('DB_PASS') ?: '';
$database   = getenv('DB_NAME') ?: 'data_connector';

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8");
?>
