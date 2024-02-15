<?php
namespace Database;

class DansPlaylist extends AbstractTable {
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function deleteOfPlaylist(int $idUtilisateur, int $albumId) {
        if (!$this->hasNote($idUtilisateur, $albumId)) {
            $stmt = $this->pdo->prepare("DELETE FROM DANS_PLAYLIST WHERE idUtilisateur = ? AND idAlbum = ? AND note IS NOT NULL");
            $stmt->execute([$idUtilisateur, $albumId]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE DANS_PLAYLIST SET inPlaylist = ? WHERE idUtilisateur = ? AND idAlbum = ?");
            $stmt->execute([0, $idUtilisateur, $albumId]);
        }
    }
    
    public function isAlbumInDansPlaylist(int $idAlbum, int $idUtilisateur) {
        $stmt = $this->pdo->prepare("SELECT * FROM DANS_PLAYLIST WHERE idAlbum = ? AND idUtilisateur = ?");
        $stmt->execute([$idAlbum, $idUtilisateur]);
        return $stmt->fetch();
    }
    
    public function addToPlaylist(int $idUtilisateur, int $albumId) {
        if (!$this->isAlbumInDansPlaylist($albumId, $idUtilisateur)) {
            $stmt = $this->pdo->prepare("INSERT INTO DANS_PLAYLIST (idUtilisateur, idAlbum, note, inPlaylist) VALUES (?, ?, ?, ?)");
            $stmt->execute([$idUtilisateur, $albumId, null, 1]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE DANS_PLAYLIST SET inPlaylist = ? WHERE idUtilisateur = ? AND idAlbum = ?");
            $stmt->execute([1, $idUtilisateur, $albumId]);
        }
    }

    public function noterAlbum(int $idUtilisateur, int $albumId, int $note) {
        if (!$this->isAlbumInDansPlaylist($albumId, $idUtilisateur)) {
            $stmt = $this->pdo->prepare("INSERT INTO DANS_PLAYLIST (idUtilisateur, idAlbum, note, inPlaylist) VALUES (?, ?, ?, ?)");
            $stmt->execute([$idUtilisateur, $albumId, $note, 0]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE DANS_PLAYLIST SET note = ? WHERE idUtilisateur = ? AND idAlbum = ?");
            $stmt->execute([$note, $idUtilisateur, $albumId]);
        }
    }

    public function hasNote(int $idUtilisateur, int $albumId) {
        $stmt = $this->pdo->prepare("SELECT * FROM DANS_PLAYLIST WHERE idUtilisateur = ? AND idAlbum = ? AND note IS NOT NULL");
        $stmt->execute([$idUtilisateur, $albumId]);
        return $stmt->fetch();
    }

    public function getNote(int $idUtilisateur, int $albumId) {
        $stmt = $this->pdo->prepare("SELECT note FROM DANS_PLAYLIST WHERE idUtilisateur = ? AND idAlbum = ?");
        $stmt->execute([$idUtilisateur, $albumId]);
        return $stmt->fetch();
    }

    public function getMoyenne(int $albumId) {
        $stmt = $this->pdo->prepare("SELECT AVG(note) as moyenne FROM DANS_PLAYLIST WHERE idAlbum = ?");
        $stmt->execute([$albumId]);
        return $stmt->fetchColumn();
    }

    public function getNbNotes(int $albumId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(note) FROM DANS_PLAYLIST WHERE idAlbum = ?");
        $stmt->execute([$albumId]);
        return $stmt->fetchColumn();
    }
}

?>