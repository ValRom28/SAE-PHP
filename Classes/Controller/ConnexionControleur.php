<?php
namespace Controller;
use Database\Utilisateur;

class ConnexionControleur {
    public function pageConnexion() {
        // Obtenir le contenu de la vue
        ob_start();
        include 'templates/Component/connexion.php';
        $content = ob_get_clean();

        // Retourner le contenu de la vue
        return $content;
    }
    
    public function connexion($mailUtilisateur, $mdpUtilisateur) {
        // Connexion à la base de données
        $pdo = new \PDO('sqlite:Data/db.sqlite');
        $request = new Utilisateur($pdo);
        $user = $request->connexion($mailUtilisateur, $mdpUtilisateur);
        
        if ($user) {
            // Démarrer la session
            session_start();

            // Définir une variable de session pour indiquer que l'utilisateur est connecté
            $_SESSION['loggedin'] = true;
            $_SESSION['idUtilisateur'] = $user['idUtilisateur'];
            
            // Rediriger vers la page d'accueil
            header("Location: index.php");
            exit(); // Assurez-vous de terminer le script après la redirection
        } else {
            // Obtenir le contenu de la vue
            ob_start();
            include 'templates/Component/connexion.php';
            $content = ob_get_clean();

            // Retourner le contenu de la vue
            return $content;
        }
    }
}

?>
