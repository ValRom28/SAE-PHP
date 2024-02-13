<h2>Résultat de votre recherche</h2>
<div class="albumAccueil">
<?php foreach ($results as $album) : ?>
    <?php 
        echo "<div class='listeAlbums'><a href='index.php?action=detail&album_id=".$album['idAlbum']."'>";
        echo "<img src='Data/images/".$album['lienImage']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' />";
        echo "<p>".$album['nomAlbum']."</p>";
        echo "</a></div>";
    ?>
<?php endforeach; ?>
</div>