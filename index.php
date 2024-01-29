<?php
use View\Template;

require 'Classes/autoloader.php'; 
Autoloader::register();

$action = $_REQUEST['action'] ?? false;

ob_start();
switch ($action) {
    case 'submit':
        include 'Action/form.php';
        break;

    default:
        include 'Action/form.php';
        break;
}
$content = ob_get_clean();
ob_start();
include 'templates/Component/header.php';
$header = ob_get_clean();
ob_start();
include 'templates/Component/footer.php';
$footer = ob_get_clean();


$template = new Template('templates');
$template->setLayout('accueil');
$template->setHeader($header);
$template->setFooter($footer);
$template->setContent($content);

echo $template->compile();
