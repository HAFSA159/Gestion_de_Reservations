<?php
include '../connection.php';

class Utilisateur {
    private $id;
    private $nom;
    private $email;
    private $role;
    private $favoris = [];

    public function __construct($id, $nom, $email, $type) {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->role = $role;
    }


    public function ajouterFavori($idActivité) {
        if (!in_array($idActivité, $this->favoris)) {
            $this->favoris[] = $idActivité;
        }
    }

    public function supprimerFavori($idActivité) {
        $this->favoris = array_filter($this->favoris, function($favori) use ($idActivité) {
            return $favori !== $idActivité;
        });
    }

    public function getFavoris() {
        return $this->favoris;
    }
}
