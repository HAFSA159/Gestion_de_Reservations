<?php
//include '../connection.php';
//
//if (session_status() == PHP_SESSION_NONE) {
//    session_start();
//}
//
//class Cart
//{
//    private $user_id;
//    private $db;
//
//    public function __construct($user_id, $db)
//    {
//        $this->user_id = $user_id;
//        $this->db = $db;
//    }
//
//    public function addActivityToCart($activity_id)
//    {
//        $query = $this->db->prepare("SELECT * FROM cart WHERE user_id = ? AND activity_id = ?");
//        $query->execute([$this->user_id, $activity_id]);
//
//        if ($query->rowCount() == 0) {
//            $query = $this->db->prepare("INSERT INTO cart (user_id, activity_id) VALUES (?, ?)");
//            $query->execute([$this->user_id, $activity_id]);
//        }
//    }
//
//    public function removeActivityFromCart($activity_id)
//    {
//        $query = $this->db->prepare("DELETE FROM cart WHERE user_id = ? AND activity_id = ?");
//        $query->execute([$this->user_id, $activity_id]);
//    }
//
//    public function clearCart()
//    {
//        $query = $this->db->prepare("DELETE FROM cart WHERE user_id = ?");
//        $query->execute([$this->user_id]);
//    }
//
////    public function getCart()
////    {
////        return $this->activities;
////    }
//
//}
//
//?>
<!---->
<!---->
