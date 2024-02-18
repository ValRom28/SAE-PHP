<?php
namespace Controller;
use Database\Album;

/**
 * Classe pour le contrôleur de la recherche
 * 
 */
class SearchController extends AbstractController {
    private $pdo;

    /**
     * Constructeur de la classe
     * 
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Affiche la page de recherche
     * 
     * @param string $search
     * @param int $genre
     * @param int $artiste
     * @return string
     */
    public function search($search, $genre, $artiste) {
        $request = new Album($this->pdo);
        $results1 = $request->searchAlbums($search);
        if($genre != 0){
            $results2 = $request->getAlbumByGenre($genre);
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
