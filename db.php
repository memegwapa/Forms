<?php
if (php_sapi_name() == "cli-server" || $_SERVER['SERVER_NAME'] == 'localhost') {
    // Local XAMPP
    $servername = "localhost";
    $username   = "root";
    $password   = ""; // usually empty in XAMPP
    $database   = "data_connector";
} else {
    // Docker / Coolify
    $servername = "mysql"; // MySQL service name in Coolify
    $username   = "coolify_user";
    $password   = "kweWtntbfJa5kF6uHmp1FpMPvlCEyg0Bi5t3YoSHfeFM8miVYxsP3rayr7tmmxmM";
    $database   = "data_connector";
}

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
