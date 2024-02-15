<?php
namespace Controller;
use Database\Album;
use Database\Artiste;

class AdminController extends AbstractController {
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

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

    public function pageGestionArtiste() {
        ob_start();
        include 'templates/Component/gestion_artiste.php';
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
            $request = new Album($this->pdo);
            $request->deleteAlbum($idAlbum);
        }
        header('Location: /index.php?action=gestion_album');
    }

    public function modifierAlbum() {
        $idAlbum = $_POST['idAlbum'] ?? null;
        if ($idAlbum) {
            $request = new Album($this->pdo);
            $request->updateAlbum($idAlbum, $_POST['nouveau_nom'], $_POST['nouveau_lien'], $_POST['nouvelle_annee'], $_POST['idArtiste'], $_POST['nouvelle_description']);
        }
        header('Location: /index.php?action=gestion_album');
    }

    public function creerAlbum() {
        $request = new Album($this->pdo);
        $request->createAlbum($_POST['nom_album'], $_POST['lien_image'], $_POST['annee_sortie'], $_POST['id_artiste'], $_POST['description']);
        header('Location: /index.php?action=gestion_album');
    }
    
    public function deleteArtiste() {
        $idArtiste = $_POST['id_artiste'] ?? null;
        if ($idArtiste) {
            $request = new Artiste($this->pdo);
            $possedeAlbum = $request->possedeAlbum($idArtiste);
            if (!$possedeAlbum) {
                $request->deleteArtiste($idArtiste);
            }
        }
        header('Location: /index.php?action=gestion_artiste');
    }

    public function modifierArtiste() {
        $idArtiste = $_POST['idArtiste'] ?? null;
        if ($idArtiste) {
            $request = new Artiste($this->pdo);
            $request->updateArtiste($idArtiste, $_POST['nouveau_nom'], $_POST['nouveau_lien']);
        }
        header('Location: /index.php?action=gestion_artiste');
    }

    public function creerArtiste() {
        $request = new Artiste($this->pdo);
        $request->createArtiste($_POST['nom_artiste'], $_POST['lien_image']);
        header('Location: /index.php?action=gestion_artiste');
    }
}
