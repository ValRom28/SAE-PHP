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
$pdo = new \PDO('sqlite:Data/db.sqlite');
$content = '';

switch ($action) {
    case 'search':
        $search = $_GET['search'] ?? '';
        $genre = $_GET['genre'] ?? 0;
        $artiste = $_GET['artiste'] ?? 0;
        
        $searchController = new SearchController($pdo);
        $content = $searchController->search($search, $genre, $artiste);
        break;
        
    case 'login':
        $content = (new ConnexionControleur($pdo))->pageConnexion();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Si des données POST sont soumises, traiter la connexion
            $mailUtilisateur = $_POST['email'] ?? '';
            $mdpUtilisateur = $_POST['password'] ?? '';
            $content = (new ConnexionControleur($pdo))->connexion($mailUtilisateur, $mdpUtilisateur);
        } else {
            // Sinon, afficher simplement le formulaire de connexion
            $content = (new ConnexionControleur($pdo))->pageConnexion();
            }
        break;
        
    case 'logout':
        $content= (new DeconnexionControleur($pdo))->deconnexion();
        break;

    case 'register':
        $content = (new InscriptionController($pdo))->pageInscription();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Si des données POST sont soumises, traiter l'inscription
            $pseudoUtilisateur = $_POST['pseudoUtilisateur'] ?? '';
            $mailUtilisateur = $_POST['email'] ?? '';
            $mdpUtilisateur = $_POST['password'] ?? '';
            $content = (new InscriptionController($pdo))->inscription($pseudoUtilisateur, $mailUtilisateur, $mdpUtilisateur);
        } else {
            // Sinon, afficher simplement le formulaire d'inscription
            $content = (new InscriptionController($pdo))->pageInscription();
        }
        break;

    case 'detail-album':
        $albumId = $_GET['album_id'] ?? null;
        if ($albumId) {
            $content = (new DetailController($pdo))->showDetailAlbum($albumId);
        } else {
            $content = "Aucun identifiant d'album spécifié.";
        }
        break;
        
    case 'detail-artiste':
        $artisteId = $_GET['artiste_id'] ?? null;
        if ($artisteId) {
            $content = (new DetailController($pdo))->showDetailArtiste($artisteId);
        } else {
            $content = "Aucun identifiant d'artiste spécifié.";
        }
        break;

    case 'ajouter_playlist':
        $controller = new PlaylistController($pdo);
        $controller->addToPlaylist();
        break;

    case 'supprimer_playlist':
        $controller = new PlaylistController($pdo);
        $controller->deleteOfPlaylist();
        break;
            
    case 'noter_album':
        $controller = (new PlaylistController($pdo))->noterAlbum();
        $controller->noterPlaylist();
        break;

    case 'admin':
        $content = (new AdminController($pdo))->pageAdmin();
        break;
    
    case 'gestion_album':
        $content = (new AdminController($pdo))->pageGestionAlbum();
        break;
        
    case 'gestion_artiste':
        $content = (new AdminController($pdo))->pageGestionArtiste();
        break;

    case 'page_modifier_album':
        $controller = new AdminController($pdo);
        $content = $controller->afficherFormulaireModifierAlbum();
        break;
            
    case 'supprimer_album':
        $controller = new AdminController($pdo);
        $controller->deleteAlbum();
        break;
    
    case 'modifier_album':
        $controller = new AdminController($pdo);
        $controller->modifierAlbum();
        break;

    case 'creer_album':
        $controller = new AdminController($pdo);
        $controller->creerAlbum();
        break;

    case 'page_modifier_artiste':
        $controller = new AdminController($pdo);
        $content = $controller->afficherFormulaireModifierArtiste();
        break;

    case 'supprimer_artiste':
        $controller = new AdminController($pdo);
        $controller->deleteArtiste();
        break;

    case 'modifier_artiste':
        $controller = new AdminController($pdo);
        $controller->modifierArtiste();
        break;

    case 'creer_artiste':
        $controller = new AdminController($pdo);
        $controller->creerArtiste();
        break;

    default:
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
