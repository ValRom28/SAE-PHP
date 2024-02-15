<?php
use Database\Album;
use Database\DansPlaylist;

session_start();
echo "<link rel='stylesheet' href='templates/static/css/detail.css'><div>";
if($album) {
    $pdo = new \PDO('sqlite:Data/db.sqlite');
    $albumId = $album[0]['idAlbum'];
    $request = new Album($pdo);
    $requestPlaylist = new DansPlaylist($pdo);
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
        $idUtilisateur = $_SESSION['idUtilisateur'];
        
        if ($request->isAlbumInPlaylist($albumId, $idUtilisateur)) {
            echo "<form action='/index.php?action=supprimer_playlist' method='post'class='favForm'>";
            echo "<h2>".$album[0]['nomAlbum']."</h2>";
            echo "<input type='hidden' name='album_id' value='".$albumId."'>";
            echo "<button type='submit' class='favImg'><img src='templates/static/images/favFull.png'></button>";
            echo "</form>";
            if ($album[0]['description'] != null) {
                echo "<p>Description: ".$album[0]['description']."</p>";
            }
            echo "<p>Année de sortie: ".$album[0]['anneeSortie']."</p>";
            echo "<p>Artiste: ";
            echo "<a href='index.php?action=detail-artiste&artiste_id=".$album[0]['idArtiste']."'>".$album[0]['nomArtiste']."</a>";
            echo "<p>Genres: ";
            foreach($genres as $genre) {
                echo $genre['nomGenre']." ";
            }
            echo "</p>";
            echo "<div class=\"noteDetail\">";
            echo "<p>Notes moyennes: ".$requestPlaylist->getMoyenne($albumId)."/10</p>";
            echo "<p>Nombre de notes: ".$requestPlaylist->getNbNotes($albumId)."</p>";
            if ($requestPlaylist->hasNote($idUtilisateur, $albumId)) {
                echo "<p>Ma note: ".$requestPlaylist->getNote($idUtilisateur, $albumId)['note']."</p>";
            }
            echo "<p>Noter: </p>";
            echo "<form action='/index.php?action=noter_album' method='post'>";
            echo "<input type='hidden' name='album_id' value='".$albumId."'>";
            echo "<input type='number' name='note' min='0' max='10'>";
            echo "<button type='submit'>Noter</button>";
            echo "</form>";
        } else {
            echo "<form action='/index.php?action=ajouter_playlist' method='post' class='favForm'>";
            echo "<h2>".$album[0]['nomAlbum']."</h2>";
            echo "<input type='hidden' name='album_id' value='".$albumId."'>";
            echo "<button type='submit' class='favImg'><img src='templates/static/images/favEmpty.png'></button>";
            echo "</form>";
            if ($album[0]['description'] != null) {
                echo "<p>Description: ".$album[0]['description']."</p>";
            }
            echo "<p>Année de sortie: ".$album[0]['anneeSortie']."</p>";
            echo "<p>Artiste: ";
            echo "<a href='index.php?action=detail-artiste&artiste_id=".$album[0]['idArtiste']."'>".$album[0]['nomArtiste']."</a>";
            echo "<p>Genres: ";
            foreach($genres as $genre) {
                echo $genre['nomGenre']." ";
            }
            echo "</p>";
            echo "<div class=\"noteDetail\">";
            echo "<p>Notes moyennes: ".$requestPlaylist->getMoyenne($albumId)."/10</p>";
            echo "<p>Nombre de notes: ".$requestPlaylist->getNbNotes($albumId)."</p>";
            if ($requestPlaylist->hasNote($idUtilisateur, $albumId)) {
                echo "<p>Ma note: ".$requestPlaylist->getNote($idUtilisateur, $albumId)['note']."</p>";
            }
            echo "<p>Noter: </p>";
            echo "<form action='/index.php?action=noter_album' method='post'>";
            echo "<input type='hidden' name='album_id' value='".$albumId."'>";
            echo "<input type='number' name='note' min='0' max='10'>";
            echo "<button type='submit'>Noter</button>";
            echo "</form>";
        }
    
    }
    else{
        echo "<h2>".$album[0]['nomAlbum']."</h2>";
        if ($album[0]['description'] != null) {
            echo "<p>Description: ".$album[0]['description']."</p>";
        }
        echo "<p>Année de sortie: ".$album[0]['anneeSortie']."</p>";
        echo "<p>Artiste: ";
        echo "<a href='index.php?action=detail-artiste&artiste_id=".$album[0]['idArtiste']."'>".$album[0]['nomArtiste']."</a>";
        echo "<p>Genres: ";
        foreach($genres as $genre) {
            echo $genre['nomGenre']." ";
        }
        echo "</p>";
        echo "<div class=\"noteDetail\">";
        echo "<p>Notes moyennes: ".$requestPlaylist->getMoyenne($albumId)."/10</p>";
        echo "<p>Nombre de notes: ".$requestPlaylist->getNbNotes($albumId)."</p></div>";
    }
    echo "</div>";
    echo "</div>";
    echo "<img src='Data/images/".$album[0]['imageAlbum']."' alt='".$album[0]['nomAlbum']."' class='imgGroupe'/>";
} else {
    echo "<p>L'album demandé n'existe pas.</p>";
}
?>
