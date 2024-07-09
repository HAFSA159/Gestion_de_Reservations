<?php
include '../connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class Cart
{
    private $db;
    private $user_id;

    public function __construct($user_id, $db)
    {
        $this->user_id = $user_id;
        $this->db = $db;
    }


    public function addActivityToCart($activity_id)
    {
        $sql_check = "SELECT COUNT(*) FROM cart WHERE user_id = :user_id AND activity_id = :activity_id";
        $stmt_check = $this->db->prepare($sql_check);
        $stmt_check->execute([':user_id' => $this->user_id, ':activity_id' => $activity_id]);
        $count = $stmt_check->fetchColumn();

        if ($count > 0) {
            return false;
        }
        $sql_insert = "INSERT INTO cart (user_id, activity_id) VALUES (:user_id, :activity_id)";
        $stmt_insert = $this->db->prepare($sql_insert);
        $stmt_insert->execute([':user_id' => $this->user_id, ':activity_id' => $activity_id]);

        return true;
    }

    public function getUserCartItems($user_id)
    {
        $sql = "SELECT c.*, a.name AS activity_name, a.type AS activity_type, a.date AS activity_date, a.price AS activity_price
                FROM cart c
                INNER JOIN activities a ON c.activity_id = a.id
                WHERE c.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $this->user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function deleteCartItem($cart_id)
    {
        $sql = "DELETE FROM cart WHERE id = :cart_id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':cart_id' => $cart_id, ':user_id' => $this->user_id]);

    }

    public function addReservationFromCart($userId, $activityId, $cart_id) {
        $checkQuery = "SELECT COUNT(*) FROM activities WHERE id = :activity_id";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->bindParam(':activity_id', $activityId, PDO::PARAM_INT);
        $checkStmt->execute();

        if ($checkStmt->fetchColumn() > 0) {
            $query = "INSERT INTO reservations (user_id, activity_id) VALUES (:user_id, :activity_id)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':activity_id', $activityId, PDO::PARAM_INT);
            $rslt = $stmt->execute();
//            var_dump($rslt);
            if($rslt){
                $this->deleteCartItem($cart_id);
                return true;
            }
        } else {
            echo "Error: Activity ID does not exist.";
        }
    }


//    public function addReservationFromCart($user_id,$activity_id)
//    {
//            $sqlCheck = "SELECT COUNT(*) as count FROM reservations WHERE user_id = :user_id AND activity_id = :activity_id";
////            var_dump($sqlCheck);
//            $stmtCheck = $this->db->prepare($sqlCheck);
//            $stmtCheck->execute([
//                ':user_id' => $user_id,
//                ':activity_id' => $activity_id,
//            ]);
////        var_dump($user_id, $activity_id);
//
//            $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);
////            var_dump($result);
//
//            if ($result['count'] !==0) {
//                return false;
//            }
//             $timestamp = time();
//
//            $sql = "INSERT INTO reservations (user_id, activity_id, created_at)
//                VALUES (:user_id, :activity_id, :created_at)";
//
//            $stmt = $this->db->prepare($sql);
//            $stmt->execute([
//                ':user_id' => $user_id,
//                ':activity_id' => $activity_id,
//                ':created_at' => $timestamp,
//            ]);
//            return true;
//
//
//    }

}

