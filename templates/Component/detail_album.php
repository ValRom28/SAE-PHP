<?php
session_start();

if($album) {
    echo "<h2>Détails de l'album</h2>";
    echo "<h3>".$album[0]['nomAlbum']."</h3>";
    echo "<img src='Data/images/".$album[0]['lienImage']."' alt='".$album[0]['nomAlbum']."' />";
    echo "<p>Année de sortie: ".$album[0]['anneeSortie']."</p>";
    
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
        echo "<form action='/index.php?action=ajouter_playlist' method='post'>";
        echo "<input type='hidden' name='album_id' value='".$album[0]['idAlbum']."'>";
        echo "<button type='submit'>Ajouter à la playlist</button>";
        echo "</form>";

        echo "<form action='ajouter_note.php' method='post'>";
        echo "<input type='hidden' name='album_id' value='".$album[0]['idAlbum']."'>";
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
