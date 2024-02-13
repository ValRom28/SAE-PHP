<?php
use Database\Album;
use Database\Artiste;

$pdo = new \PDO('sqlite:Data/db.sqlite');
$requestAlbum = new Album($pdo);
$requestArtiste = new Artiste($pdo);

$idAlbum = $_POST['id_album'] ?? null;
$album = $requestAlbum->getAlbumById($idAlbum);

if ($album) {
    $nomAlbum = $album[0]['nomAlbum'];
    $anneeSortie = $album[0]['anneeSortie'];
    $description = $album[0]['description'];
    $lienImage = $album[0]['lienImage'];

    // Récupérer tous les artistes disponibles
    $artists = $requestArtiste->getArtistes();
?>

<form action="/index.php?action=modifier_album" method="post">
    <input type="hidden" name="idAlbum" value="<?= $idAlbum ?>">
    <label>Nom de l'album:
        <input type="text" name="nouveau_nom" value="<?= $nomAlbum ?>">
    </label><br>
    <label>Année de sortie:
        <input type="number" name="nouvelle_annee" value="<?= $anneeSortie ?>">
    </label><br>
    <label>Lien de l'image:
        <input type="text" name="nouveau_lien" value="<?= $lienImage ?>">
    </label><br>
    <label>Description
        <input type="textarea" name="nouvelle_description" value="<?= $description ?>">
    </label><br>
    <!-- Liste des artistes associés à l'album -->
    <label>Artiste associé à l'album :</label><br>
    <?php
    foreach ($artists as $artist) {
        echo '<label><input type="radio" name="idArtiste" value="' . $artist['idArtiste'] . '"';
        if ($artist['idArtiste'] == $album[0]['idArtiste']) {
            echo ' checked';
        }
        echo '> ' . $artist['nomArtiste'] . '</label><br>';
    }
    ?>
    <button type="submit">Modifier l'album</button>
</form>
<?php
} else {
    echo "L'album que vous essayez de modifier n'existe pas.";
}
?>
