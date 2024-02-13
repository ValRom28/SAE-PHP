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

    public function afficherFormulaireModifierAlbum() {
        ob_start();
        include 'templates/Component/modifier_album.php';
        $content = ob_get_clean();

        return $content;
    }
    
    public function afficherFormulaireModifierArtiste() {
        ob_start();
        include 'templates/Component/modifier_artiste.php';
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

    public function modifierAlbum() {
        $idAlbum = $_POST['idAlbum'] ?? null;
        if ($idAlbum) {
            $pdo = new \PDO('sqlite:Data/db.sqlite');
            $request = new Album($pdo);
            $request->updateAlbum($idAlbum, $_POST['nouveau_nom'], $_POST['nouveau_lien'], $_POST['nouvelle_annee'], $_POST['idArtiste'], $_POST['nouvelle_description']);
        }
        header('Location: /index.php?action=gestion_album');
    }

    public function creerAlbum() {
        $pdo = new \PDO('sqlite:Data/db.sqlite');
        $request = new Album($pdo);
        $request->createAlbum($_POST['nom_album'], $_POST['lien_image'], $_POST['annee_sortie'], $_POST['id_artiste'], $_POST['description']);
        header('Location: /index.php?action=gestion_album');
    }
    
    public function deleteArtiste() {
        $idArtiste = $_POST['id_artiste'] ?? null;
        if ($idArtiste) {
            $pdo = new \PDO('sqlite:Data/db.sqlite');
            $request = new Album($pdo);
            $request->deleteArtiste($idArtiste);
        }
        header('Location: /index.php?action=gestion_artiste');
    }

    public function modifierArtiste() {
        $idArtiste = $_POST['idArtiste'] ?? null;
        if ($idArtiste) {
            $pdo = new \PDO('sqlite:Data/db.sqlite');
            $request = new Album($pdo);
            $request->updateArtiste($idArtiste, $_POST['nouveau_nom_artiste'], $_POST['nouveau_lien_image_artiste'], $_POST['nouvelle_description_artiste']);
        }
        header('Location: /index.php?action=gestion_artiste');
    }

    public function creerArtiste() {
        $pdo = new \PDO('sqlite:Data/db.sqlite');
        $request = new Album($pdo);
        $request->createArtiste($_POST['nom_artiste'], $_POST['lien_image_artiste'], $_POST['description_artiste']);
        header('Location: /index.php?action=gestion_artiste');
    }
}
