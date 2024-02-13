<?php
namespace Controller;
use Database\Album;

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

    public function deleteAlbum() {
        $idAlbum = $_POST['id_album'] ?? null;
        if ($idAlbum) {
            $pdo = new \PDO('sqlite:Data/db.sqlite');
            $request = new Album($pdo);
            $request->deleteAlbum($idAlbum);
        }
        header('Location: /index.php?action=gestion_album');
    }

    public function afficherFormulaireModifierAlbum() {
        ob_start();
        include 'templates/Component/modifier_album.php';
        $content = ob_get_clean();

        return $content;
    }

    public function modifierAlbum() {
        $idAlbum = $_POST['idAlbum'] ?? null;
        if ($idAlbum) {
            $pdo = new \PDO('sqlite:Data/db.sqlite');
            $request = new Album($pdo);
            $request->updateAlbum($idAlbum, $_POST['nouveau_nom'], $_POST['nouveau_lien'], $_POST['nouvelle_annee'], $_POST['idArtiste'], $_POST['nouvelle_description']);
        }
        header('Location: /index.php?action=gestion_album');
    }
}