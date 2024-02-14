<?php
namespace Database;

class Album {
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function createAlbum($nomAlbum, $lienImage, $anneeSortie, $idArtiste, $description) {
        $query = <<<EOF
        INSERT INTO album (nomAlbum, lienImage, anneeSortie, idArtiste, description)
        VALUES (:nomAlbum, :lienImage, :anneeSortie, :idArtiste, :description)
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':nomAlbum' => $nomAlbum,
            ':lienImage' => $lienImage,
            ':anneeSortie' => $anneeSortie,
            ':idArtiste' => $idArtiste,
            ':description' => $description
        ]);
    }

    public function updateAlbum($idAlbum, $nomAlbum, $lienImage, $anneeSortie, $idArtiste, $description) {
        $query = <<<EOF
        UPDATE album
        SET nomAlbum = :nomAlbum, lienImage = :lienImage, anneeSortie = :anneeSortie, idArtiste = :idArtiste, description = :description
        WHERE idAlbum = :idAlbum
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':idAlbum' => $idAlbum,
            ':nomAlbum' => $nomAlbum,
            ':lienImage' => $lienImage,
            ':anneeSortie' => $anneeSortie,
            ':idArtiste' => $idArtiste,
            ':description' => $description
        ]);
    }

    public function deleteAlbum($idAlbum) {
        $query = <<<EOF
        DELETE FROM album
        WHERE idAlbum = :idAlbum
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':idAlbum' => $idAlbum]);
    }

    public function searchAlbums($query) {
        $stmt = $this->pdo->prepare("SELECT * FROM ALBUM WHERE nomAlbum LIKE ?");
        $stmt->execute(["%$query%"]);
        return $stmt->fetchAll();
    }

    public function getAlbums(): array {
        $query = <<<EOF
            SELECT *
            FROM ALBUM
            ORDER BY nomAlbum
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
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

    public function getAlbumById(int $idAlbum) {
        $query = <<<EOF
            SELECT * FROM ALBUM
            WHERE idAlbum = :idAlbum
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':idAlbum' => $idAlbum]);
        return $stmt->fetchAll();
    }

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
}

?>
