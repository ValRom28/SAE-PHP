<h2>Albums</h2>
<div class="albumAccueil">
<?php
require_once 'Classes/autoloader.php';
Autoloader::register();
require_once 'Classes/Database/request.php';

$playlist = getAlbums(1);
foreach ($playlist as $album) {
  echo "<img src=templates/static/images/".$album['lienImage']." alt=".$album['nomAlbum']." title=".$album['nomAlbum']." />";
}?>
</div>
