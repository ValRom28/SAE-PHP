<?php
namespace Controller;

use Database\Request;

class PlaylistController
{
    public function addToPlaylist()
    {
        // Récupérer l'ID de l'utilisateur à partir de la session
        session_start();
        $idUtilisateur = $_SESSION['idUtilisateur'] ?? null;

        // Récupérer l'ID de l'album à partir des données POST
        $albumId = $_POST['album_id'] ?? null;

        if ($idUtilisateur && $albumId) {
            // Insérer l'enregistrement dans la table de liaison (playlist)
            $pdo = new \PDO('sqlite:Data/db.sqlite');
            $stmt = $pdo->prepare("INSERT INTO DANS_PLAYLIST (idUtilisateur, idAlbum, note) VALUES (?, ?, ?)");
            $stmt->execute([$idUtilisateur, $albumId, 0]);

            // Rediriger l'utilisateur vers une page appropriée après l'ajout
            header("Location: index.php");
            exit();
        } else {
            // Gérer le cas où l'ID de l'utilisateur ou l'ID de l'album n'est pas fourni ou est invalide
            echo "L'utilisateur ou l'album à ajouter à la playlist n'est pas spécifié.";
        }
    }
}
