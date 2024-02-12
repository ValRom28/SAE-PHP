<?php
namespace Controller;
use Database\Request;

class SearchController {
    public function search($query) {
        $pdo = new \PDO('sqlite:Data/db.sqlite');
        $request = new Request($pdo);
        $results = $request->searchAlbums($query);

        ob_start();
        include 'templates/Component/search_results.php';
        $content = ob_get_clean();

        return $content;
    }
}
?>
