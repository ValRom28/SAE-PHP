<?php
namespace Controller;

use Database\Album;
use Database\Artiste;
use View\Template;

class DetailController {
    public function showDetailAlbum($albumId) {
        // Récupérer les détails de l'album depuis la base de données en fonction de son identifiant
        $pdo = new \PDO('sqlite:Data/db.sqlite');
        $request = new Album($pdo);
        $album = $request->getAlbumById($albumId);
        $genres = $request->getGenresOfAlbum($albumId);

        // Obtenir le contenu de la vue
        ob_start();
        include 'templates/Component/detail_album.php';
        $content = ob_get_clean();

        // Retourner le contenu de la vue
        return $content;
    }

    public function showDetailArtiste($artisteId) {
        // Récupérer les détails de l'artiste depuis la base de données en fonction de son identifiant
        $pdo = new \PDO('sqlite:Data/db.sqlite');
        $request = new Artiste($pdo);
        $artiste = $request->getArtisteById($artisteId);
        $albums = $request->getAlbumsOfArtiste($artisteId);
        // Obtenir le contenu de la vue
        ob_start();
        include 'templates/Component/detail_artiste.php';
        $content = ob_get_clean();

        // Retourner le contenu de la vue
        return $content;
    }
}
?>
