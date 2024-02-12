<h1>Votre Playlist</h1>
<div class='albumsPlaylist'>
    <?php
    require_once 'Classes/autoloader.php';
    Autoloader::register();
    use Database\Request;

    $idUtilisateur = $_SESSION['idUtilisateur'] ?? null;
    $pdo = new \PDO('sqlite:Data/db.sqlite');
    $request = new Request($pdo);
    $playlist = $request->getAlbumOfPlaylist($idUtilisateur);
    foreach ($playlist as $album) {
    echo "<a href='index.php?action=detail&album_id=".$album['idAlbum']."'>";
    echo "<img src='Data/images/".$album['lienImage']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' />";
    echo "</a>";
    }?>
</div>
