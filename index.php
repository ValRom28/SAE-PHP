<?php
use View\Template;

require 'Classes/autoloader.php'; 
Autoloader::register();

$action = $_REQUEST['action'] ?? false;

ob_start();
switch ($action) {
    case 'submit':
        include 'templates/Component/main.php';
        break;

    default:
        include 'templates/Component/main.php';
        break;
}
$content = ob_get_clean();
ob_start();
include 'templates/Component/header.php';
$header = ob_get_clean();
ob_start();
include 'templates/Component/aside.php';
$aside = ob_get_clean();


$template = new Template('templates');
$template->setLayout('accueil');
$template->setHeader($header);
$template->setAside($aside);
$template->setContent($content);

echo $template->compile();
