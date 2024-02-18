<?php
namespace Database;

/**
 * Classe pour la table Genre
 * 
 */
class Genre extends AbstractTable {
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
     * Vérifie si un genre existe
     * 
     * @param string $nomGenre
     * @return array
     */
    public function getGenresLesPlusPopulaires(){
        $stmt = $this->pdo->prepare("SELECT genre.idGenre, genre.nomGenre, COUNT(album.idAlbum) as nbAlbums FROM GENRE NATURAL JOIN POSSEDE NATURAL JOIN ALBUM GROUP BY genre.idGenre ORDER BY nbAlbums DESC LIMIT 3");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Récupère tous les genres
     * 
     * @return array
     */
    public function getGenres(){
        $stmt = $this->pdo->prepare("SELECT idGenre, nomGenre FROM GENRE ORDER BY nomGenre ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}