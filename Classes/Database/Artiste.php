<?php
namespace Database;

/**
 * Classe pour la table Artiste
 * 
 */
class Artiste extends AbstractTable {
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
     * Vérifie si un artiste existe
     * 
     * @param string $nomArtiste
     * @return array
     */
    public function artisteExist($nomArtiste) {
        $stmt = $this->pdo->prepare("SELECT * FROM ARTISTE WHERE nomArtiste = ?");
        $stmt->execute([$nomArtiste]);
        return $stmt->fetch();
    }

    /**
     * Crée un artiste
     * 
     * @param string $nomArtiste
     * @param string $imageArtiste
     */
    public function createArtiste($nomArtiste, $imageArtiste) {
        $query = <<<EOF
        INSERT INTO artiste (nomArtiste, imageArtiste)
        VALUES (:nomArtiste, :imageArtiste)
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':nomArtiste' => $nomArtiste,
            ':imageArtiste' => $imageArtiste,
        ]);
    }

    /**
     * Met à jour un artiste
     * 
     * @param int $idArtiste
     * @param string $nomArtiste
     * @param string $imageArtiste
     */
    public function updateArtiste($idArtiste, $nomArtiste, $imageArtiste) {
        $query = <<<EOF
        UPDATE artiste
        SET nomArtiste = :nomArtiste, imageArtiste = :imageArtiste
        WHERE idArtiste = :idArtiste
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':idArtiste' => $idArtiste,
            ':nomArtiste' => $nomArtiste,
            ':imageArtiste' => $imageArtiste,
        ]);
    }

    /**
     * Supprime un artiste
     * 
     * @param int $idArtiste
     */
    public function deleteArtiste($idArtiste) {
        $query = <<<EOF
        DELETE FROM artiste
        WHERE idArtiste = :idArtiste
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':idArtiste' => $idArtiste]);
    }

    /**
     * Récupère tous les artistes
     * 
     * @return array
     */
    public function getArtistes(): array {
        $stmt = $this->pdo->query("SELECT * FROM ARTISTE ORDER BY nomArtiste ASC");
        return $stmt->fetchAll();
    }

    /**
     * Récupère un artiste par son id
     * 
     * @param int $idArtiste
     * @return array
     */
    public function getArtisteById($idArtiste) {
        $stmt = $this->pdo->prepare("SELECT * FROM ARTISTE WHERE idArtiste = ?");
        $stmt->execute([$idArtiste]);
        return $stmt->fetch();
    }

    /**
     * Vérifie si un artiste possède un album
     * 
     * @param int $idArtiste
     * @return array
     */
    public function possedeAlbum($idArtiste) {
        $query = <<<EOF
            SELECT * FROM ALBUM
            WHERE idArtiste = :idArtiste
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':idArtiste' => $idArtiste]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère les albums d'un artiste
     * 
     * @param int $idArtiste
     * @return array
     */
    public function getAlbumsOfArtiste($idArtiste) {
        $query = <<<EOF
            SELECT * FROM ALBUM
            WHERE idArtiste = :idArtiste
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':idArtiste' => $idArtiste]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère un artiste par son nom
     * 
     * @param string $nomArtiste
     * @return array
     */
    public function getArtisteByName($nomArtiste) {
        $stmt = <<<EOF
            SELECT * FROM ARTISTE
            WHERE LOWER(nomArtiste) = LOWER(:nomArtiste)
        EOF;
        $stmt = $this->pdo->prepare($stmt);
        $stmt->execute([':nomArtiste' => $nomArtiste]);
        return $stmt->fetch();
    }
}

?>