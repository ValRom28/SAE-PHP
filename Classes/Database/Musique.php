<?php
namespace Database;

/**
 * Classe pour la table Musique
 * 
 */
class Musique extends AbstractTable {
    private $pdo;

    /**
     * Constructeur de la classe
     * 
     * @param \PDO $pdo
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère toutes les musiques d'un album
     * 
     * @param int $idAlbum
     * @return array
     */
    public function getMusiques($idAlbum) {
        $stmt = $this->pdo->prepare("SELECT * FROM MUSIQUE WHERE idAlbum = :idAlbum");
        $stmt->execute(['idAlbum' => $idAlbum]);
        return $stmt->fetchAll();
    }

    /**
     * Réupère une musique
     * 
     * @param int $idMusique
     * @return array
     */
    public function getMusique($idMusique) {
        $stmt = $this->pdo->prepare("SELECT * FROM MUSIQUE WHERE idMusique = :idMusique");
        $stmt->execute(['idMusique' => $idMusique]);
        return $stmt->fetch();
    }
}
?>