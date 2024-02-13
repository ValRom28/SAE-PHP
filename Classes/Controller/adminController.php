<?php
namespace Controller;

class AdminController {
    public function pageAdmin() {
        ob_start();
        include 'templates/Component/admin.php';
        $content = ob_get_clean();

        return $content;
    }

    public function pageGestionAlbum() {
        ob_start();
        include 'templates/Component/gestion_album.php';
        $content = ob_get_clean();

        return $content;
    }
}