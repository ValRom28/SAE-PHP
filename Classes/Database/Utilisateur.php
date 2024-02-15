<?php
namespace Database;

class Utilisateur extends AbstractTable {
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function connexion($mailUtilisateur, $mdpUtilisateur) {
        $stmt = $this->pdo->prepare("SELECT * FROM UTILISATEURS WHERE mailUtilisateur = ? AND mdpUtilisateur = ?");
        $stmt->execute([$mailUtilisateur, $mdpUtilisateur]);
        return $stmt->fetch();
    }

    public function inscription($pseudoUtilisateur, $mailUtilisateur, $mdpUtilisateur) {
        $stmt = $this->pdo->prepare("INSERT INTO UTILISATEURS (pseudoUtilisateur, mailUtilisateur, mdpUtilisateur,estAdmin) VALUES (?, ?, ?,?)");
        $stmt->execute([$pseudoUtilisateur, $mailUtilisateur, $mdpUtilisateur,0]);
    }

    public function isAdmin($idUtilisateur) {
        $stmt = $this->pdo->prepare("SELECT estAdmin FROM UTILISATEURS WHERE idUtilisateur = ?");
        $stmt->execute([$idUtilisateur]);
        if($stmt->fetch()['estAdmin'] == 1){
            return true;
        }
        return false;
    }
}

?>