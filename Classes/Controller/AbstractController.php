<?php
namespace Controller;

/**
 * Classe abstraite pour les contrôleurs
 * 
 */
abstract class AbstractController {
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
