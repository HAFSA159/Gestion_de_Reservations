<?php
session_start();

include '../connection.php';

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION["id"] = $user['id'];
                $_SESSION["email"] = $user['email'];

                header("Location: ../views/Home.php");
                exit();
            } else {
                echo "Invalid password";
            }
        } else {
            echo "User with this email does not exist";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_free_result($result);
}

mysqli_close($conn);
?>
