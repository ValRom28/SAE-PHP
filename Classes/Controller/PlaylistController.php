<?php
namespace Controller;

use Database\Request;

class PlaylistController
{
    public function addToPlaylist()
    {
        session_start();
        $idUtilisateur = $_SESSION['idUtilisateur'] ?? null;

        $albumId = $_POST['album_id'] ?? null;

        if ($idUtilisateur && $albumId) {
            $pdo = new \PDO('sqlite:Data/db.sqlite');
            $stmt = $pdo->prepare("INSERT INTO DANS_PLAYLIST (idUtilisateur, idAlbum, note) VALUES (?, ?, ?)");
            $stmt->execute([$idUtilisateur, $albumId, 0]);

            header("Location: index.php");
            exit();
        } else {
            echo "L'utilisateur ou l'album à ajouter à la playlist n'est pas spécifié.";
        }
    }

    public function deleteOfPlaylist() {
        session_start();
        $idUtilisateur = $_SESSION['idUtilisateur'] ?? null;

        $albumId = $_POST['album_id'] ?? null;

        if ($idUtilisateur && $albumId) {
            $pdo = new \PDO('sqlite:Data/db.sqlite');
            $stmt = $pdo->prepare("DELETE FROM DANS_PLAYLIST WHERE idUtilisateur = ? AND idAlbum = ?");
            $stmt->execute([$idUtilisateur, $albumId]);

            header("Location: index.php");
            exit();
        } else {
            echo "L'utilisateur ou l'album à supprimer à la playlist n'est pas spécifié.";
        }
    }
}
