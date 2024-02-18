<?php
namespace Controller;
use Database\DansPlaylist;

/**
 * Classe pour le contrôleur de la playlist
 * 
 */
class PlaylistController extends AbstractController {
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
     * Ajoute un album à la playlist
     * 
     */
    public function addToPlaylist() {
        session_start();
        $idUtilisateur = $_SESSION['idUtilisateur'] ?? null;

        $albumId = $_POST['album_id'] ?? null;

        if ($idUtilisateur && $albumId) {
            $request = new DansPlaylist($this->pdo);
            $request->addToPlaylist($idUtilisateur, $albumId);
            
            header("Location: /index.php?action=detail-album&album_id=$albumId");
            exit();
        } else {
            echo "L'utilisateur ou l'album à ajouter à la playlist n'est pas spécifié.";
        }
    }

    /**
     * Supprime un album de la playlist
     * 
     */
    public function deleteOfPlaylist() {
        session_start();
        $idUtilisateur = $_SESSION['idUtilisateur'] ?? null;
        $albumId = $_POST['album_id'] ?? null;

        if ($idUtilisateur && $albumId) {
            $request = new DansPlaylist($this->pdo);
            $request->deleteOfPlaylist($idUtilisateur, $albumId);

            header("Location: /index.php?action=detail-album&album_id=$albumId");
            exit();
        } else {
            echo "L'utilisateur ou l'album à supprimer à la playlist n'est pas spécifié.";
        }
    }

    /**
     * Note un album
     * 
     */
    public function noterAlbum() {
        session_start();
        $idUtilisateur = $_SESSION['idUtilisateur'] ?? null;
        $albumId = $_POST['album_id'] ?? null;
        $note = $_POST['note'] ?? null;
        $request = new DansPlaylist($this->pdo);

        if ($idUtilisateur && $albumId && $note) {
            $request->noterAlbum($idUtilisateur, $albumId, $note);
            header("Location: /index.php?action=detail-album&album_id=$albumId");
            exit();
        } else {
            echo "L'utilisateur, l'album ou la note à ajouter n'est pas spécifié.";
        }
    }
}
