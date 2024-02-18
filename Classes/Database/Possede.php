<?php
namespace Database;

/**
 * Classe pour la table Possede
 * 
 */
class Possede extends AbstractTable {
    private $pdo;
    
    /**
     * Constructeur de la classe
     * 
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;
    }

    /**
     * Vérifie si un album possède un genre
     * 
     * @param int $idAlbum
     * @param int $idGenre
     * @return array
     */
    public function estGenre($idAlbum, $idGenre){
        $stmt = $this->pdo->prepare("INSERT INTO POSSEDE (idAlbum, idGenre) VALUES (:idAlbum, :idGenre)");
        $stmt->execute(['idAlbum' => $idAlbum, 'idGenre' => $idGenre]);
    }

    /**
     * Met à jour un album possède un genre
     * 
     * @param int $idAlbum
     * @param int $idGenre
     * @return array
     */
    public function updatePossede($idAlbum, $idGenre){
        $stmt = $this->pdo->prepare("UPDATE POSSEDE SET idGenre = :idGenre WHERE idAlbum = :idAlbum");
        $stmt->execute(['idAlbum' => $idAlbum, 'idGenre' => $idGenre]);
    }

    /**
     * Insère un album possède un genre
     * 
     * @param int $idAlbum
     * @param int $idGenre
     * @return array
     */
    public function insertPossede($idAlbum, $idGenre){
        $stmt = $this->pdo->prepare("INSERT INTO POSSEDE (idAlbum, idGenre) VALUES (:idAlbum, :idGenre)");
        $stmt->execute(['idAlbum' => $idAlbum, 'idGenre' => $idGenre]);
    }

    /**
     * Supprime un album possède un genre
     * 
     * @param int $idAlbum
     * @return array
     */
    public function deletePossede($idAlbum){
        $stmt = $this->pdo->prepare("DELETE FROM POSSEDE WHERE idAlbum = :idAlbum");
        $stmt->execute(['idAlbum' => $idAlbum]);
    }

    /**
     * Vérifie si un album possède un genre
     * 
     * @param int $idAlbum
     * @param int $idGenre
     * @return array
     */
    public function possedeGenre($idAlbum, $idGenre){
        $stmt = $this->pdo->prepare("SELECT * FROM POSSEDE WHERE idAlbum = :idAlbum AND idGenre = :idGenre");
        $stmt->execute(['idAlbum' => $idAlbum, 'idGenre' => $idGenre]);
        return $stmt->fetch();
    }
}
?>