<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'fitness';

// Establishing the database connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
} else {
    echo 'Connection successful';
    return $conn;
}
?>
