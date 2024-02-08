<h2>Albums</h2>
<div class="albumAccueil">
<?php
require_once 'Classes/autoloader.php';
Autoloader::register();
use Database\Request;

$pdo = new \PDO('sqlite:Data/db.sqlite');
$request = new Request($pdo);
$playlist = $request->getAlbums();
foreach ($playlist as $album) {
  echo "<img src=Data/images/".$album['lienImage']." alt=".$album['nomAlbum']." title=".$album['nomAlbum']." />";
}?>
</div>
