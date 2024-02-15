<?php
use Database\Album;
use Database\Artiste;

$pdo = new \PDO('sqlite:Data/db.sqlite');
$requestAlbum = new Album($pdo);
$requestArtiste = new Artiste($pdo);

$idAlbum = $_POST['id_album'] ?? null;
$album = $requestAlbum->getAlbumById($idAlbum);

if ($album) {
    $nomAlbum = $album['nomAlbum'];
    $anneeSortie = $album['anneeSortie'];
    $description = $album['description'];
    $lienImage = $album['imageAlbum'];

    // Récupérer tous les artistes disponibles
    $artists = $requestArtiste->getArtistes();
?>

<form action="/index.php?action=modifier_album" method="post">
    <fieldset>
        <legend>Modification de l'album : <?= $nomAlbum ?></legend>
        <div class="modifLabel">
            <input type="hidden" name="idAlbum" value="<?= $idAlbum ?>">
            <label>Nom de l'album</label><br>
            <label>Année de sortie</label><br>
            <label>Lien de l'image</label><br>
            <!-- Liste des artistes associés à l'album -->
            <label>Artiste associé à l'album </label><br>
            <label>Description</label><br>
        </div>
        <div class="modifInput">
            <input type="text" name="nouveau_nom" value="<?= $nomAlbum ?>"><br>
            <input type="number" name="nouvelle_annee" value="<?= $anneeSortie ?>"><br>
            <input type="text" name="nouveau_lien" value="<?= $lienImage ?>"><br>
            <select name="idArtiste">
                <?php foreach ($artists as $artist) { ?>
                    <option value="<?= $artist['idArtiste'] ?>"><?= $artist['nomArtiste'] ?></option>
                <?php } ?>
            </select><br>
            <textarea type="text" name="nouvelle_description" placeholder="Il n'y a pas encore de description pour ce groupe"><?= $description ?></textarea><br>
            <button type="submit">Modifier l'album</button>
        </div>
</form>
<?php
} else {
    echo "L'album que vous essayez de modifier n'existe pas.";
}
?>
