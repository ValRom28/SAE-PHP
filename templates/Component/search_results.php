<h2>Albums</h2>
<div class="albumAccueil">
<?php foreach ($results as $result) : ?>
    <?php 
    echo "<img src=Data/images/".$result['lienImage']." alt=".$result['nomAlbum']." title=".$result['nomAlbum']." />"; 
    echo "<p>".$result['nomAlbum']."</p>";
    ?>
<?php endforeach; ?>
</div>