<?php
namespace Database;

class Musique extends AbstractTable {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getMusiques($idAlbum) {
        $stmt = $this->pdo->prepare("SELECT * FROM MUSIQUE WHERE idAlbum = :idAlbum");
        $stmt->execute(['idAlbum' => $idAlbum]);
        return $stmt->fetchAll();
    }

    public function getMusique($idMusique) {
        $stmt = $this->pdo->prepare("SELECT * FROM MUSIQUE WHERE idMusique = :idMusique");
        $stmt->execute(['idMusique' => $idMusique]);
        return $stmt->fetch();
    }
}
?>