<div class="genre">
  <?php
  use Database\Album;
  use Database\Genre;
  require_once 'Classes/autoloader.php';
  Autoloader::register();

  $pdo = new \PDO('sqlite:Data/db.sqlite');
  $request2 = new Genre($pdo);
  $request3= new Album($pdo);
  $genres = $request2->getGenresLesPlusPopulaires();
  foreach ($genres as $genre) {
    echo "<div class='blocGenre'>";
    echo "<h2>".$genre['nomGenre']."</h2>";
    echo "<form action='/index.php?action=search&genre=".$genre['idGenre']."' method=post class=toutVoir><button type=submit>Tout afficher</button></form>";
    echo "</div>";
    echo "<div class='albumStyle'>";
    $albums = $request3->getAlbumByGenre($genre['idGenre']);
    foreach ($albums as $album) {
      echo "<div class='listeAlbums'><a href='index.php?action=detail-album&album_id=".$album['idAlbum']."'>";
      if (filter_var($album['imageAlbum'], FILTER_VALIDATE_URL)) {
        echo "<img src='".$album['imageAlbum']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' />";
      } else {
        echo "<img src='Data/images/".$album['imageAlbum']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' />";
      }
      echo "<p>".$album['nomAlbum']."</p>";
      echo "</a></div>";
    }
    echo "</div>";
  }?>
</div>

<div class="blocGenre">
  <h2>Tout les albums</h2>
  <form action='/index.php?action=search' method=post class=toutVoir><button type=submit>Tout afficher</button></form>
</div>
<div class="albumAccueil">
<?php
$pdo = new \PDO('sqlite:Data/db.sqlite');
$request = new Album($pdo);
$playlist = $request->getAlbums();
foreach ($playlist as $album) {
  echo "<div class='listeAlbums'><a href='index.php?action=detail-album&album_id=".$album['idAlbum']."'>";
  if (filter_var($album['imageAlbum'], FILTER_VALIDATE_URL)) {
    echo "<img src='".$album['imageAlbum']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' />";
  } else {
    echo "<img src='Data/images/".$album['imageAlbum']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' />";
  }
  echo "<p>".$album['nomAlbum']."</p>";
  echo "</a></div>";
}?>
</div>