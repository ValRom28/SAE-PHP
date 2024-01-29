<?php
require 'Classes/autoloader.php'; 
Autoloader::register(); 
$dataLoader = new DataLoaderJson('Data/model.json');
$questions = new QuestionRepository($dataLoader->getData());

$action = $_REQUEST['action'] ?? false;

ob_start();
switch ($action) {
    case 'submit':
        include 'templates/Recherche.php';
        break;
        
    default:
        include 'templates/Accueil.php';
        break;
}
$content = ob_get_clean();


$template = new Template('templates');
$template->setLayout('main');
$template->setContent($content);

echo $template->compile();
