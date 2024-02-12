<?php
use Database\Request;

session_start();

if($album) {
    echo "<h2>Détails de l'album</h2>";
    echo "<h3>".$album[0]['nomAlbum']."</h3>";
    echo "<img src='Data/images/".$album[0]['lienImage']."' alt='".$album[0]['nomAlbum']."' />";
    echo "<p>Année de sortie: ".$album[0]['anneeSortie']."</p>";
    
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
        $idUtilisateur = $_SESSION['idUtilisateur'];
        $albumId = $album[0]['idAlbum'];
        $pdo = new \PDO('sqlite:Data/db.sqlite');
        $request = new Request($pdo);

        if ($request->isAlbumInPlaylist($albumId, $idUtilisateur)) {
            echo "<form action='/index.php?action=supprimer_playlist' method='post'>";
            echo "<input type='hidden' name='album_id' value='".$albumId."'>";
            echo "<button type='submit'>Supprimer de la playlist</button>";
            echo "</form>";
        } else {
            echo "<form action='/index.php?action=ajouter_playlist' method='post'>";
            echo "<input type='hidden' name='album_id' value='".$albumId."'>";
            echo "<button type='submit'>Ajouter à la playlist</button>";
            echo "</form>";
        }

        echo "<form action='ajouter_note.php' method='post'>";
        echo "<input type='hidden' name='album_id' value='".$albumId."'>";
        echo "<input type='number' name='note' min='1' max='5' required>";
        echo "<button type='submit'>Ajouter une note</button>";
        echo "</form>";
    } else {
        echo "<p>Connectez-vous pour ajouter cet album à votre playlist ou pour ajouter une note.</p>";
    }
} else {
    echo "<p>L'album demandé n'existe pas.</p>";
}
?>
