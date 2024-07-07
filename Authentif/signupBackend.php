<?php
include '../connection.php';

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

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', 'user')";
    if (mysqli_query($conn, $sql)) {
        echo "User registered successfully.";
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }


mysqli_close($conn);

?>
