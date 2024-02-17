<?php
namespace Database;

class Possede extends AbstractTable {
    private $pdo;
    
    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;
    }

    public function estGenre($idAlbum, $idGenre){
        $stmt = $this->pdo->prepare("INSERT INTO POSSEDE (idAlbum, idGenre) VALUES (:idAlbum, :idGenre)");
        $stmt->execute(['idAlbum' => $idAlbum, 'idGenre' => $idGenre]);
    }

    public function updatePossede($idAlbum, $idGenre){
        $stmt = $this->pdo->prepare("UPDATE POSSEDE SET idGenre = :idGenre WHERE idAlbum = :idAlbum");
        $stmt->execute(['idAlbum' => $idAlbum, 'idGenre' => $idGenre]);
    }

    public function insertPossede($idAlbum, $idGenre){
        $stmt = $this->pdo->prepare("INSERT INTO POSSEDE (idAlbum, idGenre) VALUES (:idAlbum, :idGenre)");
        $stmt->execute(['idAlbum' => $idAlbum, 'idGenre' => $idGenre]);
    }

    public function deletePossede($idAlbum){
        $stmt = $this->pdo->prepare("DELETE FROM POSSEDE WHERE idAlbum = :idAlbum");
        $stmt->execute(['idAlbum' => $idAlbum]);
    }

    public function possedeGenre($idAlbum, $idGenre){
        $stmt = $this->pdo->prepare("SELECT * FROM POSSEDE WHERE idAlbum = :idAlbum AND idGenre = :idGenre");
        $stmt->execute(['idAlbum' => $idAlbum, 'idGenre' => $idGenre]);
        return $stmt->fetch();
    }
}
?>