<?php
namespace Database;
class Genre{
    private $pdo;
    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;
    }
    public function afficherGenres(){
        $stmt = $this->pdo->prepare("SELECT * FROM genre");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getGenresLesPlusPopulaires(){
        $stmt = $this->pdo->prepare("SELECT genre.idGenre, genre.nomGenre, COUNT(album.idAlbum) as nbAlbums FROM GENRE NATURAL JOIN POSSEDE NATURAL JOIN ALBUM GROUP BY genre.idGenre ORDER BY nbAlbums DESC LIMIT 3");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}