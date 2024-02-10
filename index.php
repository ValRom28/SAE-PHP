<?php
use Controller\SearchController;
use Controller\ConnexionControleur;
use Controller\DeconnexionControleur;
use Controller\InscriptionController;
use View\Template;

require 'Classes/Autoloader.php'; 
Autoloader::register();

// Récupérer l'action à effectuer
$action = $_GET['action'] ?? '';
$template = new Template('templates');

switch ($action) {
    case 'search':
        $query = $_GET['search'] ?? '';
        $searchController = new SearchController();
        $content = $searchController->search($query);
        break;
        
    case 'login':
        $content = (new ConnexionControleur())->pageConnexion();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Si des données POST sont soumises, traiter la connexion
            $mailUtilisateur = $_POST['email'] ?? '';
            $mdpUtilisateur = $_POST['password'] ?? '';
            $content = (new ConnexionControleur())->connexion($mailUtilisateur, $mdpUtilisateur);
        } else {
            // Sinon, afficher simplement le formulaire de connexion
            $content = (new ConnexionControleur())->pageConnexion();
            }
        break;
    case 'logout':
        $content= (new DeconnexionControleur())->deconnexion();
        break;

    case 'register':
        $content = (new InscriptionController())->pageInscription();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Si des données POST sont soumises, traiter l'inscription
            $pseudoUtilisateur = $_POST['speudo'] ?? '';
            $mailUtilisateur = $_POST['email'] ?? '';
            $mdpUtilisateur = $_POST['password'] ?? '';
            $content = (new InscriptionController())->inscription($pseudoUtilisateur, $mailUtilisateur, $mdpUtilisateur);
        } else {
            // Sinon, afficher simplement le formulaire d'inscription
            $content = (new InscriptionController())->pageInscription();
        }
        break;

    default:
        // Récupérer les vues
        ob_start();
        include 'templates/Component/main.php';
        $content = ob_get_clean();
        break;
    }
    
ob_start();
include 'templates/Component/header.php';
$header = ob_get_clean();
ob_start();
include 'templates/Component/aside.php';
$aside = ob_get_clean();
    
$template->setLayout('accueil');
$template->setContent($content);
$template->setAside($aside);
$template->setHeader($header);

// Afficher le template
echo $template->compile();
?>
