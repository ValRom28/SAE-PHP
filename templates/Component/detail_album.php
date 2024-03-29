<?php
use Database\Album;
use Database\DansPlaylist;
use Database\Musique;

session_start();
echo "<link rel='stylesheet' href='templates/static/css/detail.css'><div>";
if($album) {
    $pdo = new \PDO('sqlite:Data/db.sqlite');
    $albumId = $album['idAlbum'];
    $requestAlbum = new Album($pdo);
    $requestPlaylist = new DansPlaylist($pdo);
    $requestMusique = new Musique($pdo);
    $musiques = $requestMusique->getMusiques($albumId);
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
        $idUtilisateur = $_SESSION['idUtilisateur'];
        
        if ($requestAlbum->isAlbumInPlaylist($albumId, $idUtilisateur)) {
            echo "<form action='/index.php?action=supprimer_playlist' method='post'class='favForm'>";
            echo "<h2>".$album['nomAlbum']."</h2>";
            echo "<input type='hidden' name='album_id' value='".$albumId."'>";
            echo "<button type='submit' class='favImg'><img src='templates/static/images/favFull.png'></button>";
            echo "</form>";
            if ($album['description'] != null) {
                echo "<p>Description: ".$album['description']."</p>";
            }
            echo "<p>Année de sortie: ".$album['anneeSortie']."</p>";
            echo "<p>Artiste: ";
            echo "<a href='index.php?action=detail-artiste&artiste_id=".$album['idArtiste']."'>".$album['nomArtiste']."</a>";
            echo "<p>Genres: ";
            foreach($genres as $genre) {
                echo $genre['nomGenre']." ";
            }
            echo "</p>";
            if ($musiques) {
                echo "<p>Musiques: </p>";
                echo "<ul class='musiques'>";
                foreach($musiques as $musique) {
                    echo "<li>".$musique['titreMusique']."</li>";
                }
                echo "</ul>";
            }
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
            echo "<h2>".$album['nomAlbum']."</h2>";
            echo "<input type='hidden' name='album_id' value='".$albumId."'>";
            echo "<button type='submit' class='favImg'><img src='templates/static/images/favEmpty.png'></button>";
            echo "</form>";
            if ($album['description'] != null) {
                echo "<p>Description: ".$album['description']."</p>";
            }
            echo "<p>Année de sortie: ".$album['anneeSortie']."</p>";
            echo "<p>Artiste: ";
            echo "<a href='index.php?action=detail-artiste&artiste_id=".$album['idArtiste']."'>".$album['nomArtiste']."</a>";
            echo "<p>Genres: ";
            foreach($genres as $genre) {
                echo $genre['nomGenre']." ";
            }
            echo "</p>";
            if ($musiques) {
                echo "<p>Musiques: </p>";
                echo "<ul class='musiques'>";
                foreach($musiques as $musique) {
                    echo "<li>".$musique['titreMusique']."</li>";
                }
                echo "</ul>";
            }
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
        echo "<h2>".$album['nomAlbum']."</h2>";
        if ($album['description'] != null) {
            echo "<p>Description: ".$album['description']."</p>";
        }
        echo "<p>Année de sortie: ".$album['anneeSortie']."</p>";
        echo "<p>Artiste: ";
        echo "<a href='index.php?action=detail-artiste&artiste_id=".$album['idArtiste']."'>".$album['nomArtiste']."</a>";
        echo "<p>Genres: ";
        foreach($genres as $genre) {
            echo $genre['nomGenre']." ";
        }
        echo "</p>";
        if ($musiques) {
            echo "<p>Musiques: </p>";
            echo "<ul class='musiques'>";
            foreach($musiques as $musique) {
                echo "<li>".$musique['titreMusique']."</li>";
            }
            echo "</ul>";
        }
        echo "<div class=\"noteDetail\">";
        echo "<p>Notes moyennes: ".$requestPlaylist->getMoyenne($albumId)."/10</p>";
        echo "<p>Nombre de notes: ".$requestPlaylist->getNbNotes($albumId)."</p></div>";
    }
    echo "</div>";
    echo "</div>";
    if (filter_var($album['imageAlbum'], FILTER_VALIDATE_URL)) {
        echo "<img src='".$album['imageAlbum']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' class='imgGroupe'/>";
    } else {
        echo "<img src='Data/images/".$album['imageAlbum']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' class='imgGroupe'/>";
    }
} else {
    echo "<p>L'album demandé n'existe pas.</p>";
}
?>
