<?php
namespace Controller;
use Database\Request;
class adminController {
    public function pageAdmin() {
        // Obtenir le contenu de la vue
        ob_start();
        include 'templates/Component/admin.php';
        $content = ob_get_clean();
        // Retourner le contenu de la vue
        return $content;
    }
}