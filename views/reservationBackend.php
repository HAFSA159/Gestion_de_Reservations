<?php
include '../connection.php';
include '../classes/Cart.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $reservation = new Cart($_SESSION['user_id'], $db);
    $activity_id = $_POST['activity_id'];
    $user_id = $_SESSION['user_id'];
    $intReverser = intval($activity_id,10);
    $cart_id = $_POST['cart_id'];

    var_dump($intReverser, $_SESSION['user_id']);

    $reservation_id = $reservation->addReservationFromCart($user_id, $intReverser, $cart_id);
//var_dump($reservation_id);
    if ($reservation_id) {
        header("Location: cart.php");
        exit();
    } else {
        echo "Failed to make reservation.";
    }
}