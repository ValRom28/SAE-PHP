<?php
use Controller\SearchController;
use Controller\ConnexionControleur;
use Controller\DeconnexionControleur;
use Controller\InscriptionController;
use Controller\DetailController;
use Controller\PlaylistController;
use Controller\AdminController;
use View\Template;

require 'Classes/autoloader.php'; 
Autoloader::register();

// Récupérer l'action à effectuer
$action = $_GET['action'] ?? '';
$template = new Template('templates');

switch ($action) {
    case 'search':
        $query = $_GET['search'] ?? '';
        if ($query == "rickroll") {
            $content = "<iframe width=\"560\" height=
            \"315\" src=\"https://www.youtube.com/embed/dQw4w9WgXcQ\" 
            frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; 
            encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>";
        } else {
            $searchController = new SearchController();
            $content = $searchController->search($query);
        }
        break;
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
            $pseudoUtilisateur = $_POST['pseudoUtilisateur'] ?? '';
            $mailUtilisateur = $_POST['email'] ?? '';
            $mdpUtilisateur = $_POST['password'] ?? '';
            $content = (new InscriptionController())->inscription($pseudoUtilisateur, $mailUtilisateur, $mdpUtilisateur);
        } else {
            // Sinon, afficher simplement le formulaire d'inscription
            $content = (new InscriptionController())->pageInscription();
        }
        break;

    case 'detail':
        $albumId = $_GET['album_id'] ?? null;
        if ($albumId) {
            $content = (new DetailController())->show($albumId);
        } else {
            $content = "Aucun identifiant d'album spécifié.";
        }
        break;        

    case 'ajouter_playlist':
        $controller = new PlaylistController();
        $controller->addToPlaylist();
        break;

    case 'supprimer_playlist':
        $controller = new PlaylistController();
        $controller->deleteOfPlaylist();
        break;
            
    case 'noter_playlist':
        $controller = new PlaylistController();
        $controller->noterPlaylist();
        break;

    case 'admin':
        $content = (new AdminController())->pageAdmin();
        break;
    
    case 'gestion_album':
        $content = (new AdminController())->pageGestionAlbum();
        break;
    
    case 'supprimer_album':
        $controller = new AdminController();
        $controller->deleteAlbum();
        break;

    case 'page_modifier_album':
        $controller = new AdminController();
        $content = $controller->afficherFormulaireModifierAlbum();
        break;
    
    case 'modifier_album':
        $controller = new AdminController();
        $controller->modifierAlbum();
        break;

    case 'creer_album':
        $controller = new AdminController();
        $controller->creerAlbum();
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
