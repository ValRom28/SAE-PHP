<?php
namespace Controller;
use Database\Album;

class SearchController extends AbstractController {
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function search($search,$genre,$artiste) {
        $request = new Album($this->pdo);
        $results1 = $request->searchAlbums($search);
        if($genre != 0){
            $results2 = $request->getAllAlbumByGenre($genre);
        }
        else{
            $results2 = $request->searchAlbums($search);
        }
        if($artiste != 0){
            $results3 = $request->getAlbumsByArtiste($artiste);
        }
        else{
            $results3 =  $request->searchAlbums($search);
        }
        // une liste avec que les albums qui sont dans les 3 listes que si il y a des albums dans les 3 listes
        $results = array();
        foreach($results1 as $result1){
            foreach($results2 as $result2){
                foreach($results3 as $result3){
                    if($result1['idAlbum'] == $result2['idAlbum'] && $result2['idAlbum'] == $result3['idAlbum']){
                        array_push($results,$result1);
                    }
                }
            }
        }
        ob_start();
        include 'templates/Component/search_results.php';
        $content = ob_get_clean();

        return $content;
    }
}
?>
