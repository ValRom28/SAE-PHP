<div class="genre">
  <?php
  require_once 'Classes/autoloader.php';
  Autoloader::register();
  use Database\Album;
  use Database\Genre;
  $pdo = new \PDO('sqlite:Data/db.sqlite');
  $request2 = new Genre($pdo);
  $request3= new Album($pdo);
  $genres = $request2->getGenresLesPlusPopulaires();
  foreach ($genres as $genre) {
    echo "<h2>".$genre['nomGenre']."</h2>";
    echo "<div class='albumStyle'>";
    $albums = $request3->getAlbumByGenre($genre['idGenre']);
    foreach ($albums as $album) {
      echo "<div class='listeAlbums'><a href='index.php?action=detail-album&album_id=".$album['idAlbum']."'>";
        echo "<img src='Data/images/".$album['imageAlbum']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' />";
        echo "<p>".$album['nomAlbum']."</p>";
        echo "</a></div>";
    }
    echo "</div>";
  }?>
</div>

<h2>Tout les albums</h2>
<div class="albumAccueil">
<?php
$pdo = new \PDO('sqlite:Data/db.sqlite');
$request = new Album($pdo);
$playlist = $request->getAlbums();
foreach ($playlist as $album) {
  echo "<div class='listeAlbums'><a href='index.php?action=detail-album&album_id=".$album['idAlbum']."'>";
  echo "<img src='Data/images/".$album['imageAlbum']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' />";
  echo "<p>".$album['nomAlbum']."</p>";
  echo "</a></div>";
}?>
</div>