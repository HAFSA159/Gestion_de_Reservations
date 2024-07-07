<?php
class Reservation {
    private $id;
    private $utilisateurId;
    private $activiteId;
    private $date;

    public function __construct($id, $utilisateurId, $activiteId, $date) {
        $this->id = $id;
        $this->utilisateurId = $utilisateurId;
        $this->activiteId = $activiteId;
        $this->date = $date;
    }

    public function getId() {
        return $this->id;
    }

    public function getUtilisateurId() {
        return $this->utilisateurId;
    }

    public function getActiviteId() {
        return $this->activiteId;
    }

    public function getDate() {
        return $this->date;
    }
}
?>
