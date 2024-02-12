<?php
use Controller\SearchController;
use View\Template;

require 'Classes/Autoloader.php'; 
Autoloader::register();

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
