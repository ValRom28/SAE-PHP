<a href="/" class="retourAccueil">
    <button><img src="templates/static/images/icon.png" alt="accueil"></button>
</a>
<h1>Votre Playlist</h1>
<div class='albumsPlaylist'>
    <?php
    require_once 'Classes/autoloader.php';
    Autoloader::register();
    use Database\Album;

    $idUtilisateur = $_SESSION['idUtilisateur'] ?? null;
    if ($idUtilisateur) {
        $pdo = new \PDO('sqlite:Data/db.sqlite');
        $request = new Album($pdo);
        
        $playlist = $request->getAlbumOfPlaylist($idUtilisateur);
        foreach ($playlist as $album) {
            echo "<a href='index.php?action=detail-album&album_id=".$album['idAlbum']."'>";
            if (filter_var($album['imageAlbum'], FILTER_VALIDATE_URL)) {
                echo "<img src='".$album['imageAlbum']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' />";
            } else {
                echo "<img src='Data/images/".$album['imageAlbum']."' alt='".$album['nomAlbum']."' title='".$album['nomAlbum']."' />";
            }
            echo "</a>";
        }
    } else {
        echo '<p>Connectez-vous pour avoir accès à votre playlist.</p>';
    }
    ?>
</div>
