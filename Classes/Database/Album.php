<?php
namespace Database;

/**
 * Classe pour la table Album
 * 
 */
class Album extends AbstractTable {
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
     * Crée un album
     * 
     * @param string $nomAlbum
     * @param string $imageAlbum
     * @param int $anneeSortie
     * @param int $idArtiste
     * @param string $description
     */
    public function createAlbum($nomAlbum, $imageAlbum, $anneeSortie, $idArtiste, $description) {
        $query = <<<EOF
        INSERT INTO album (nomAlbum, imageAlbum, anneeSortie, idArtiste, description)
        VALUES (:nomAlbum, :imageAlbum, :anneeSortie, :idArtiste, :description)
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':nomAlbum' => $nomAlbum,
            ':imageAlbum' => $imageAlbum,
            ':anneeSortie' => $anneeSortie,
            ':idArtiste' => $idArtiste,
            ':description' => $description
        ]);
    }

    /**
     * Met à jour un album
     * 
     * @param int $idAlbum
     * @param string $nomAlbum
     * @param string $imageAlbum
     * @param int $anneeSortie
     * @param int $idArtiste
     * @param string $description
     */
    public function updateAlbum($idAlbum, $nomAlbum, $imageAlbum, $anneeSortie, $idArtiste, $description) {
        $query = <<<EOF
        UPDATE album
        SET nomAlbum = :nomAlbum, imageAlbum = :imageAlbum, anneeSortie = :anneeSortie, idArtiste = :idArtiste, description = :description
        WHERE idAlbum = :idAlbum
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':idAlbum' => $idAlbum,
            ':nomAlbum' => $nomAlbum,
            ':imageAlbum' => $imageAlbum,
            ':anneeSortie' => $anneeSortie,
            ':idArtiste' => $idArtiste,
            ':description' => $description
        ]);
    }

    /**
     * Supprime un album
     * 
     * @param int $idAlbum
     */
    public function deleteAlbum($idAlbum) {
        $query = <<<EOF
        DELETE FROM album
        WHERE idAlbum = :idAlbum
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':idAlbum' => $idAlbum]);
    }

    /**
     * Recherche des albums
     * 
     * @param string $query
     * @return array
     */
    public function searchAlbums($query) {
        $stmt = $this->pdo->prepare("SELECT * FROM ALBUM WHERE nomAlbum LIKE ?");
        $stmt->execute(["%$query%"]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère les albums d'un artiste
     * 
     * @param int $idArtiste
     * @return array
     */
    public function getAlbumsByArtiste($idArtiste) {
        $stmt = $this->pdo->prepare("SELECT * FROM ALBUM WHERE idArtiste = ?");
        $stmt->execute([$idArtiste]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère les albums d'un genre
     * 
     * @param int $idGenre
     * @return array
     */
    public function getAlbumByGenre($idGenre) {
        $stmt = $this->pdo->prepare("SELECT * FROM ALBUM WHERE idAlbum IN (SELECT idAlbum FROM POSSEDE WHERE idGenre = ? LIMIT 6)");
        $stmt->execute([$idGenre]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère touts les albums d'un genre
     * 
     * @param int $idGenre
     * @return array
     */
    public function getAllAlbumByGenre($idGenre) {
        $stmt = $this->pdo->prepare("SELECT * FROM ALBUM WHERE idAlbum IN (SELECT idAlbum FROM POSSEDE WHERE idGenre = ?)");
        $stmt->execute([$idGenre]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère les 6 premiers albums
     * 
     * @return array
     */
    public function getAlbums(): array {
        $query = <<<EOF
            SELECT *
            FROM ALBUM
            ORDER BY nomAlbum
            LIMIT 6
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Récupère tous les albums
     * 
     * @return array
     */
    public function getAllAlbums(): array {
        $query = <<<EOF
            SELECT *
            FROM ALBUM
            ORDER BY nomAlbum
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Récupère les albums d'une playlist
     * 
     * @param int $idUtilisateur
     * @return array
     */
    public function getAlbumOfPlaylist(int $idUtilisateur): array {
        $query = <<<EOF
            SELECT *
            FROM ALBUM
            WHERE idAlbum IN (
                SELECT idAlbum
                FROM DANS_PLAYLIST
                WHERE idUtilisateur = :idUtilisateur
                AND inPlaylist = 1
            )
            ORDER BY nomAlbum
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':idUtilisateur' => $idUtilisateur]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère un album par son id
     * 
     * @param int $idAlbum
     * @return array
     */
    public function getAlbumById(int $idAlbum) {
        $query = <<<EOF
            SELECT * FROM ALBUM
            JOIN ARTISTE ON ALBUM.idArtiste = ARTISTE.idArtiste
            WHERE idAlbum = :idAlbum
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':idAlbum' => $idAlbum]);
        return $stmt->fetch();
    }

    /**
     * Récupère les albums d'un artiste
     * 
     * @param int $idArtiste
     * @return array
     */
    public function isAlbumInPlaylist(int $idAlbum, int $idUtilisateur) {
        $query = <<<EOF
            SELECT * FROM DANS_PLAYLIST
            WHERE idAlbum = :idAlbum
            AND idUtilisateur = :idUtilisateur
            AND inPlaylist = 1
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':idAlbum' => $idAlbum, ':idUtilisateur' => $idUtilisateur]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère les genres d'un album
     * 
     * @param int $idAlbum
     * @return array
     */
    public function getGenresOfAlbum(int $idAlbum) {
        $query = <<<EOF
            SELECT GENRE.idGenre, nomGenre
            FROM GENRE
            JOIN POSSEDE ON GENRE.idGenre = POSSEDE.idGenre
            WHERE idAlbum = :idAlbum
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':idAlbum' => $idAlbum]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère le dernier id des albums
     * 
     * @return int
     */
    public function getLastAlbumId() {
        $query = <<<EOF
            SELECT MAX(idAlbum) as idAlbum
            FROM ALBUM
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Récupère un album par son nom
     * 
     * @param string $nomAlbum
     * @return array
     */
    public function getAlbumByName($nomAlbum) {
        $query = <<<EOF
            SELECT * FROM ALBUM
            WHERE LOWER(nomAlbum) = LOWER(:nomAlbum)
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':nomAlbum' => $nomAlbum]);
        return $stmt->fetch();
    }
}
?>
