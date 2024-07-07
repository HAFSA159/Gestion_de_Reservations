<?php
class Utilisateur {
    private $id;
    private $nom;
    private $email;
    private $favoris = array();
    private $panier = array();

    public function __construct($id, $nom, $email) {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
    }

    public function ajouterFavori($activite) {
        array_push($this->favoris, $activite);
    }

    public function supprimerFavori($activiteId) {
        $this->favoris = array_filter($this->favoris, function($activite) use ($activiteId) {
            return $activite->getId() !== $activiteId;
        });
    }

    public function ajouterPanier($activite) {
        array_push($this->panier, $activite);
    }

    public function supprimerPanier($activiteId) {
        $this->panier = array_filter($this->panier, function($activite) use ($activiteId) {
            return $activite->getId() !== $activiteId;
        });
    }

    public function getFavoris() {
        return $this->favoris;
    }

    public function getPanier() {
        return $this->panier;
    }
}
?>
<?php
include_once 'Database.php';

class Users extends Database {
    private $UserTable = 'users';
    private $sql;
    private $conn;

    public function listUsers() {
        $this->conn = parent::conn();
        $this->sql = "SELECT * FROM {$this->UserTable}";
        $stmt = mysqli_stmt_init($this->conn);
        mysqli_stmt_prepare($stmt, $this->sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
        return $users;
    }

    public function insertUser($username, $email, $hashed_password) {
        $this->conn = parent::conn();
        $this->sql = "INSERT INTO users (username, email, password) VALUES (?,?,?)";
        $stmt = mysqli_stmt_init($this->conn);
        mysqli_stmt_prepare($stmt, $this->sql);
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
        mysqli_stmt_execute($stmt);
    }

    public function updateTicket() {
        $sql = "UPDATE tickets SET titre = ? WHERE id_ticket = ?";

        if ($this->conn->query($sql) === TRUE) {
            return "User updated successfully";
        } else {
            return "Error updating user: " . $this->conn->error;
        }
    }

    public function deleteTicket() {
        $sql = "DELETE FROM tickets WHERE id = ?";

        if ($this->conn->query($sql) === TRUE) {
            return "User deleted successfully";
        } else {
            return "Error deleting user: " . $this->conn->error;
        }
    }
}

$db = new Database();
$user = new Users();
$users = $user->listUsers();




?>