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
}