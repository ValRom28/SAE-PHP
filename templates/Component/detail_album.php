<?php
use Database\Request;

session_start();
echo "<link rel='stylesheet' href='templates/static/css/detail.css'><div>";
if($album) {
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
        $idUtilisateur = $_SESSION['idUtilisateur'];
        $albumId = $album[0]['idAlbum'];
        $pdo = new \PDO('sqlite:Data/db.sqlite');
        $request = new Request($pdo);
        if ($request->isAlbumInPlaylist($albumId, $idUtilisateur)) {
            echo "<form action='/index.php?action=supprimer_playlist' method='post'>";
            echo "<h2>".$album[0]['nomAlbum']."</h2>";
            echo "<input type='hidden' name='album_id' value='".$albumId."'>";
            echo "<button type='submit' class='favImg'><img src='templates/static/images/favFull.png'></button>";
            echo "</form>";
        } else {
            echo "<form action='/index.php?action=ajouter_playlist' method='post' class='favForm'>";
            echo "<h2>".$album[0]['nomAlbum']."</h2>";
            echo "<input type='hidden' name='album_id' value='".$albumId."'>";
            echo "<button type='submit' class='favImg'><img src='templates/static/images/favEmpty.png'></button>";
            echo "</form>";
        }
    
    }
    else{
        echo "<h2>".$album[0]['nomAlbum']."</h2>";
    }
    echo "<p>".$album[0]['descriptionAlbum']."</p>";
    echo "<p>Année de sortie: ".$album[0]['anneeSortie']."</p></div>";
    echo "<img src='Data/images/".$album[0]['lienImage']."' alt='".$album[0]['nomAlbum']."' class='imgGroupe'/>";
} else {
    echo "<p>L'album demandé n'existe pas.</p>";
}
?>
