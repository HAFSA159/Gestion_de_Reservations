<?php
//$host = 'localhost';
//$username = 'root';
//$password = '';
//$database = 'fitness';
//
//$conn = mysqli_connect($host, $username, $password, $database);
//
//if (!$conn) {
//    die('Connection failed: ' . mysqli_connect_error());
//} else {
////    echo 'Connection successful';
//    return $conn;
//}


    $host = 'localhost';
    $dbname = 'fitness';
    $username = 'root';
    $password = '';

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        // Set PDO to throw exceptions on error
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Handle connection error
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
?>

