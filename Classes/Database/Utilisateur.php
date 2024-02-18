<?php
namespace Database;

/**
 * Classe pour la table Utilisateur
 * 
 */
class Utilisateur extends AbstractTable {
    private $pdo;

    /**
     * Constructeur de la classe
     * 
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Connecte un utilisateur
     * 
     * @param string $mailUtilisateur
     * @param string $mdpUtilisateur
     * @return array
     */
    public function connexion($mailUtilisateur, $mdpUtilisateur) {
        $stmt = $this->pdo->prepare("SELECT * FROM UTILISATEURS WHERE mailUtilisateur = ? AND mdpUtilisateur = ?");
        $stmt->execute([$mailUtilisateur, $mdpUtilisateur]);
        return $stmt->fetch();
    }

    /**
     * Inscription d'un utilisateur
     * 
     * @param string $pseudoUtilisateur
     * @param string $mailUtilisateur
     * @param string $mdpUtilisateur
     */
    public function inscription($pseudoUtilisateur, $mailUtilisateur, $mdpUtilisateur) {
        $stmt = $this->pdo->prepare("INSERT INTO UTILISATEURS (pseudoUtilisateur, mailUtilisateur, mdpUtilisateur,estAdmin) VALUES (?, ?, ?,?)");
        $stmt->execute([$pseudoUtilisateur, $mailUtilisateur, $mdpUtilisateur,0]);
    }

    /**
     * Vérifie si un utilisateur est admin
     * 
     * @param int $idUtilisateur
     * @return bool
     */
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