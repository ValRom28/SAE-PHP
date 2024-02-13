<?php
namespace Database;

class Request {
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function searchAlbums($query) {
        $stmt = $this->pdo->prepare("SELECT * FROM ALBUM WHERE nomAlbum LIKE ?");
        $stmt->execute(["%$query%"]);
        return $stmt->fetchAll();
    }

    public function getAlbums(): array {
        $query = <<<EOF
            SELECT idAlbum,nomAlbum,lienImage,anneeSortie
            FROM ALBUM
            ORDER BY nomAlbum
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getAlbumOfPlaylist(int $idUtilisateur): array {
        $query = <<<EOF
            SELECT idAlbum,nomAlbum,lienImage,anneeSortie
            FROM ALBUM
            WHERE idAlbum IN (
                SELECT idAlbum
                FROM DANS_PLAYLIST
                WHERE idUtilisateur = :idUtilisateur
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
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':idAlbum' => $idAlbum, ':idUtilisateur' => $idUtilisateur]);
        return $stmt->fetchAll();
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
    public function artiste_exist($nomArtiste) {
        $stmt = $this->pdo->prepare("SELECT * FROM ARTISTE WHERE nomArtiste = ?");
        $stmt->execute([$nomArtiste]);
        return $stmt->fetch();
    }
    public function est_admin($idUtilisateur) {
        $stmt = $this->pdo->prepare("SELECT estAdmin FROM UTILISATEURS WHERE idUtilisateur = ?");
        $stmt->execute([$idUtilisateur]);
        if($stmt->fetch()['estAdmin'] == 1){
            return true;
        }
        return false;
    }
}
