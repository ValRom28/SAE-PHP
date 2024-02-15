<?php
namespace Controller;
use Database\Utilisateur;

class InscriptionController extends AbstractController {
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function pageInscription() {
        // Obtenir le contenu de la vue
        ob_start();
        include 'templates/Component/inscription.php';
        $content = ob_get_clean();

        // Retourner le contenu de la vue
        return $content;
    }

    public function inscription($pseudoUtilisateur, $mailUtilisateur, $mdpUtilisateur) {
        $request = new Utilisateur($this->pdo);
        if ($pseudoUtilisateur != '' | $mailUtilisateur != '' | $mdpUtilisateur != '') {
            $user = $request->inscription($pseudoUtilisateur, $mailUtilisateur, $mdpUtilisateur);
            header("Location: index.php?action=login");
            exit();
        } else {
            header("Location: index.php?action=register");
        }
    }
}