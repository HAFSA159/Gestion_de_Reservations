<?php
include '../connection.php';

//if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
//    $conn = mysqli_connect($host, $username, $password, $database) or die ("Connection Failed" .mysqli_connect_error());
//        if(isset($_POST['username']) && (isset($_POST['email']) && (isset($_POST['password'])){
//        $username = $_POST['username'];
//        $email = $_POST['email'];
//        $password = $_POST['password'];
//
//        $sql="INSERT INTO `users`(`username`, `email`,`password`) VALUES (`$username`, `$email`, `$password`)";
//        $query = mysqli_query($conn, $sql);
//            if($query){
//                echo 'entry success';
//            }
//            else{
//                echo 'error';
//            }
//        }
//}

    $username = isset($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? mysqli_real_escape_string($conn, $_POST['confirm_password']) : '';

    // Perform additional validation as needed
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "All input fields are required!";
        exit();
    }

    if ($password != $confirm_password) {
        echo "Passwords do not match";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', 'user')";

    if (mysqli_query($conn, $sql)) {
        echo "User registered successfully.";
        // Redirect to a success page or login page
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }


mysqli_close($conn);
?>
