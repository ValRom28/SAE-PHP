<h2>Albums</h2>
<div class="albumAccueil">
<?php
require_once 'Classes/autoloader.php';
Autoloader::register();
use Database\Album;

$pdo = new \PDO('sqlite:Data/db.sqlite');
$request = new Album($pdo);
$playlist = $request->getAlbums();
foreach ($playlist as $album) {
  echo "<div class='listeAlbums'><a href='index.php?action=detail&album_id=".$album['idAlbum']."'>";
  echo "<img src='Data/images/".$album['lienImage']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' />";
  echo "<p>".$album['nomAlbum']."</p>";
  echo "</a></div>";
}?>
</div>
