<?php

namespace Database;

class DansPlaylist {
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function addToPlaylist(int $idUtilisateur, int $albumId) {
        $stmt = $this->pdo->prepare("INSERT INTO DANS_PLAYLIST (idUtilisateur, idAlbum, note, inPlaylist) VALUES (?, ?, ?, ?)");
        $stmt->execute([$idUtilisateur, $albumId, null, 1]);
    }

    public function deleteOfPlaylist(int $idUtilisateur, int $albumId) {
        $stmt = $this->pdo->prepare("DELETE FROM DANS_PLAYLIST WHERE idUtilisateur = ? AND idAlbum = ?");
        $stmt->execute([$idUtilisateur, $albumId]);
    }
}

?>