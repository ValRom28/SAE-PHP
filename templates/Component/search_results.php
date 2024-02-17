<h2>Résultat de votre recherche</h2>
<div class="albumAccueil">
<?php foreach ($results as $album) : ?>
    <?php 
        echo "<div class='listeAlbums'><a href='index.php?action=detail-album&album_id=".$album['idAlbum']."'>";
        if (filter_var($album['imageAlbum'], FILTER_VALIDATE_URL)) {
            echo "<img src='".$album['imageAlbum']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' />";
          } else {
            echo "<img src='Data/images/".$album['imageAlbum']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' />";
          }
        echo "<p>".$album['nomAlbum']."</p>";
        echo "</a></div>";
    ?>
<?php endforeach; ?>
</div>