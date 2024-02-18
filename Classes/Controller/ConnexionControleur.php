<?php
namespace Controller;
use Database\Utilisateur;

/**
 * Classe pour le contrôleur de la connexion
 * 
 */
class ConnexionControleur extends AbstractController {
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
     * Affiche la page de connexion
     * 
     * @return string
     */
    public function pageConnexion() {
        ob_start();
        include 'templates/Component/connexion.php';
        $content = ob_get_clean();

        return $content;
    }
    
    /**
     * Connecte l'utilisateur
     * 
     * @param string $mailUtilisateur
     * @param string $mdpUtilisateur
     * @return string
     */
    public function connexion($mailUtilisateur, $mdpUtilisateur) {
        $request = new Utilisateur($this->pdo);
        $user = $request->connexion($mailUtilisateur, $mdpUtilisateur);
        
        if ($user) {
            session_start();

            $_SESSION['loggedin'] = true;
            $_SESSION['idUtilisateur'] = $user['idUtilisateur'];
            
            header("Location: index.php");
            exit();
        } else {
            ob_start();
            include 'templates/Component/connexion.php';
            $content = ob_get_clean();

            return $content;
        }
    }
}

?>
