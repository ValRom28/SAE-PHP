<?php
namespace Database;

class Album extends AbstractTable {
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

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

    public function getAlbumsByArtiste($idArtiste) {
        $stmt = $this->pdo->prepare("SELECT * FROM ALBUM WHERE idArtiste = ?");
        $stmt->execute([$idArtiste]);
        return $stmt->fetchAll();
    }

    public function getAlbumByGenre($idGenre) {
        $stmt = $this->pdo->prepare("SELECT * FROM ALBUM WHERE idAlbum IN (SELECT idAlbum FROM POSSEDE WHERE idGenre = ? LIMIT 6)");
        $stmt->execute([$idGenre]);
        return $stmt->fetchAll();
    }

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
            JOIN ARTISTE ON ALBUM.idArtiste = ARTISTE.idArtiste
            WHERE idAlbum = :idAlbum
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':idAlbum' => $idAlbum]);
        return $stmt->fetch();
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

    public function getGenresOfAlbum(int $idAlbum) {
        $query = <<<EOF
            SELECT nomGenre
            FROM GENRE
            JOIN POSSEDE ON GENRE.idGenre = POSSEDE.idGenre
            WHERE idAlbum = :idAlbum
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':idAlbum' => $idAlbum]);
        return $stmt->fetchAll();
    }
}

?>
