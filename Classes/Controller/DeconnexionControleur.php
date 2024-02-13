<?php
namespace Controller;

class DeconnexionControleur
{
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
