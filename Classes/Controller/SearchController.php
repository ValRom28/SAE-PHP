<?php
namespace Controller;
use Database\Request;

class SearchController {
    public function search($query) {
        // Votre logique de recherche
        $pdo = new \PDO('sqlite:Data/db.sqlite');
        $request = new Request($pdo);
        $results = $request->searchAlbums($query);
        
        // Obtenir le contenu de la vue
        ob_start();
        include 'templates/Component/search_results.php';
        $content = ob_get_clean();

        // Retourner le contenu de la vue
        return $content;
    }
}
?>
