<?php
// Database connection details
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'secure_upload';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: set charset
$conn->set_charset("utf8mb4");
