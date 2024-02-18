<?php
namespace Database;

/**
 * Classe abstraite pour les tables
 * 
 */
abstract class AbstractTable {
    private $pdo;

    /**
     * Constructeur de la classe abstraite
     * 
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }
}

?>
