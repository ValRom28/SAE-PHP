<?php
namespace Controller;
use Database\Album;
use Database\Artiste;
use Database\Possede;

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
        var_dump($_POST);
        if ($idAlbum) {
            $requestAlbum = new Album($this->pdo);
            $requestPossede = new Possede($this->pdo);
            $requestAlbum->updateAlbum($idAlbum, $_POST['nouveau_nom'], $_POST['nouveau_lien'], $_POST['nouvelle_annee'], $_POST['idArtiste'], $_POST['nouvelle_description']);
            foreach ($requestAlbum->getGenresOfAlbum($idAlbum) as $genre) {
                if ($_POST['genres'] == null || !in_array($genre['nomGenre'], $_POST['genres'])) {
                    $requestPossede->deletePossede($idAlbum, $genre['idGenre']);
                }
            }
            foreach ($_POST['genres'] as $genre) {
                $requestPossede->possedeGenre($idAlbum, $genre);
                if (!$requestPossede->possedeGenre($idAlbum, $genre)) {
                    $requestPossede->insertPossede($idAlbum, $genre);
                }
            }
        }
        header('Location: /index.php?action=gestion_album');
    }

    public function creerAlbum() {
        session_start();
        $requestAlbum = new Album($this->pdo);
        $requestPossede = new Possede($this->pdo);
        if ($_POST['lien_image'] == null) {
            $_POST['lien_image'] = 'default.jpg';
        }
        if ($requestAlbum->getAlbumByName($_POST['nom_album'])) {
            $_SESSION['message'] = "Cet album existe déjà";
        } else {
            $requestAlbum->createAlbum($_POST['nom_album'], $_POST['lien_image'], $_POST['annee_sortie'], $_POST['id_artiste'], $_POST['description']);
            $idAlbum = $requestAlbum->getLastAlbumId();
            foreach ($_POST['genres'] as $idGenre) {
                $requestPossede->insertPossede($idAlbum, $idGenre);
            }
        }
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
        session_start();
        $request = new Artiste($this->pdo);
        if ($_POST['lien_image'] == null) {
            $_POST['lien_image'] = 'default.jpg';
        }
        if ($request->getArtisteByName($_POST['nom_artiste'])) {
            $_SESSION['message'] = "Cet artiste existe déjà";
        } else {
            $request->createArtiste($_POST['nom_artiste'], $_POST['lien_image']);
        }
        header('Location: /index.php?action=gestion_artiste');
    }
}
