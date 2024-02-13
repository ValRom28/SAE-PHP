<?php
namespace Controller;
use Database\Request;

class InscriptionController{

    public function pageInscription() {
        // Obtenir le contenu de la vue
        ob_start();
        include 'templates/Component/inscription.php';
        $content = ob_get_clean();

        // Retourner le contenu de la vue
        return $content;
    }

    public function inscription($pseudoUtilisateur, $mailUtilisateur, $mdpUtilisateur) {
        // Connexion à la base de données
        $pdo = new \PDO('sqlite:Data/db.sqlite');
        $request = new Request($pdo);
        if ($pseudoUtilisateur != '' | $mailUtilisateur != '' | $mdpUtilisateur != '') {
            $user = $request->inscription($pseudoUtilisateur, $mailUtilisateur, $mdpUtilisateur);
            header("Location: index.php?action=login");
            exit();
        } else {
            header("Location: index.php?action=register");
        }
    }
}