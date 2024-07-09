<?php
include __DIR__ . '/../connection.php';

class Reservation {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addReservation($user_id, $activity_id)
    {
        $sqlCheck = "SELECT COUNT(*) as count FROM reservations WHERE user_id = :user_id AND activity_id = :activity_id";
        $stmtCheck = $this->db->prepare($sqlCheck);
        $stmtCheck->execute([
            ':user_id' => $user_id,
            ':activity_id' => $activity_id,
        ]);
        $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            return false;
        }
        $sql = "INSERT INTO reservations (user_id, activity_id, created_at) 
            VALUES (:user_id, :activity_id, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':activity_id' => $activity_id,
        ]);

        return true;
    }

    public function getUserReservations($user_id)
    {
        $sql = "SELECT r.*, a.name AS activity_name, a.date AS activity_date, a.price AS activity_price
                FROM reservations r
                INNER JOIN activities a ON r.activity_id = a.id
                WHERE r.user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteReservation($reservation_id) {
        try {
            $sql = "DELETE FROM reservations WHERE id = :reservation_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':reservation_id' => $reservation_id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('PDOException: ' . $e->getMessage());
            return false;
        }
    }

    public function getAllReservationsWithActivityDetails() {
        $sql = "SELECT reservations.id, reservations.user_id, reservations.created_at, activities.name as activity_name, users.username as user_name
            FROM reservations 
            JOIN activities ON reservations.activity_id = activities.id
            JOIN users ON reservations.user_id = users.id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

