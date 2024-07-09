<?php
include dirname(__DIR__) . '/connection.php';

class Activity
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createActivity($name, $type, $description, $price, $date)
    {
        $sql = "INSERT INTO activities (name, type, description, price, date) 
                VALUES (:name, :type, :description, :price, :date)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':type' => $type,
            ':description' => $description,
            ':price' => $price,
            ':date' => $date,
        ]);
    }

    public function getActivityById($id)
    {
        $sql = "SELECT * FROM activities WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteActivity($id)
    {
        $sql = "DELETE FROM activities WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    public function getAllActivities()
    {
        $sql = "SELECT * FROM activities";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
