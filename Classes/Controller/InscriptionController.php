<?php
namespace Controller;
use Database\Utilisateur;

/**
 * Classe pour le contrôleur de l'inscription
 * 
 */
class InscriptionController extends AbstractController {
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
     * Affiche la page d'inscription
     * 
     * @return string
     */
    public function pageInscription() {
        ob_start();
        include 'templates/Component/inscription.php';
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Inscrire l'utilisateur
     * 
     * @param string $pseudoUtilisateur
     * @param string $mailUtilisateur
     * @param string $mdpUtilisateur
     */
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