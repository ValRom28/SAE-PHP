<?php
namespace Controller;

use Database\Album;
use Database\Artiste;
use View\Template;

/**
 * Classe pour le contrôleur des détails
 * 
 */
class DetailController extends AbstractController {
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
     * Affiche la page des détails d'un album
     * 
     * @param int $albumId
     * @return string
     */
    public function showDetailAlbum($albumId) {
        $request = new Album($this->pdo);
        $album = $request->getAlbumById($albumId);
        $genres = $request->getGenresOfAlbum($albumId);

        ob_start();
        include 'templates/Component/detail_album.php';
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Affiche la page des détails d'un artiste
     * 
     * @param int $artisteId
     * @return string
     */
    public function showDetailArtiste($artisteId) {
        $request = new Artiste($this->pdo);
        $artiste = $request->getArtisteById($artisteId);
        $albums = $request->getAlbumsOfArtiste($artisteId);

        ob_start();
        include 'templates/Component/detail_artiste.php';
        $content = ob_get_clean();

        return $content;
    }
}
?>
