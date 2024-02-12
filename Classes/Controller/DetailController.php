<?php
namespace Controller;

use Database\Request;
use View\Template;

class DetailController {
    public function show($albumId) {
        // Récupérer les détails de l'album depuis la base de données en fonction de son identifiant
        $pdo = new \PDO('sqlite:Data/db.sqlite');
        $request = new Request($pdo);
        $album = $request->getAlbumById($albumId);

        // Obtenir le contenu de la vue
        ob_start();
        include 'templates/Component/detail_album.php';
        $content = ob_get_clean();

        // Retourner le contenu de la vue
        return $content;
    }
}
?>
