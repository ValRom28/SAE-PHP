<?php
session_start();

echo "<link rel='stylesheet' href='templates/static/css/detail.css'><div>";

if ($albums) {
    if ($artiste) {
        echo "<h2>".$artiste['nomArtiste']."</h2>";
        echo "<h3>Albums</h3>";
        foreach($albums as $album) {
            echo "<div class='listeAlbums'><a href='index.php?action=detail-album&album_id=".$album['idAlbum']."'>";
            if (filter_var($album['imageAlbum'], FILTER_VALIDATE_URL)) {
                echo "<img src='".$album['imageAlbum']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' class='imgGroupe'/>";
            } else {
                echo "<img src='Data/images/".$album['imageAlbum']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' class='imgGroupe'/>";
            }
            echo "<p>".$album['nomAlbum']."</p>";
            echo "</a></div>";
        }
        echo "</div>";
        if (filter_var($artiste['imageArtiste'], FILTER_VALIDATE_URL)) {
            echo "<img src='".$artiste['imageArtiste']."' alt='".$artiste['nomArtiste']."' title='".$artiste['nomArtiste']."' class='imgGroupe'/>";
        } else {
            echo "<img src='Data/images/".$artiste['imageArtiste']."' alt='".$artiste['nomArtiste']."' title='".$artiste['nomArtiste']."' class='imgGroupe'/>";
        }
    } else {
        echo "<p>L'artiste demandé n'existe pas.</p>";
    }
} else {
    echo "<p>L'artiste demandé n'a pas d'album.</p>";
}
echo "</div>";
?>
