<?php
namespace Controller;

/**
 * Classe pour le contrôleur de la déconnexion
 * 
 */
class DeconnexionControleur extends AbstractController {
    private $pdo;

    /**
     * Constructeur de la classe
     * 
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Déconnecte l'utilisateur
     * 
     */
    public function deconnexion()
    {
        session_start();

        session_destroy();

        header("Location: index.php");
        exit;
    }
}
?>
