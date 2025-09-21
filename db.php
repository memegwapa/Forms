<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "data_connector";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection and set charset
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
} 


?>
