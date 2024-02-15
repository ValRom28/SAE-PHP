<?php
namespace Controller;

class DeconnexionControleur extends AbstractController {
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function deconnexion()
    {
        // Démarrer la session
        session_start();

        // Détruire toutes les données de session
        session_destroy();

        // Rediriger l'utilisateur vers la page d'accueil ou une autre page
        header("Location: index.php");
        exit;
    }
}
?>
