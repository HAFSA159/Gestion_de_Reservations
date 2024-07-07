<?php
class Activite {
    private $id;
    private $nom;
    private $type;
    private $description;
    private $disponibilite;

    public function __construct($id, $nom, $type, $description, $disponibilite) {
        $this->id = $id;
        $this->nom = $nom;
        $this->type = $type;
        $this->description = $description;
        $this->disponibilite = $disponibilite;
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getType() {
        return $this->type;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDisponibilite() {
        return $this->disponibilite;
    }

    public function setDisponibilite($disponibilite) {
        $this->disponibilite = $disponibilite;
    }
}
?>
