<?php
use Database\Album;
use Database\Artiste;
use Database\Genre;

$pdo = new \PDO('sqlite:Data/db.sqlite');
$requestAlbum = new Album($pdo);
$requestArtiste = new Artiste($pdo);
$requestGenre = new Genre($pdo);

$idAlbum = $_POST['id_album'] ?? null;
$album = $requestAlbum->getAlbumById($idAlbum);
$genres = $requestGenre->getGenres();

if ($album) {
    $nomAlbum = $album['nomAlbum'];
    $anneeSortie = $album['anneeSortie'];
    $description = $album['description'];
    $lienImage = $album['imageAlbum'];
    $genresAlbum = $requestAlbum->getGenresOfAlbum($idAlbum) ?? [];

    $artists = $requestArtiste->getArtistes();
} else {
    echo "L'album que vous essayez de modifier n'existe pas.";
}
?>

<form action="/index.php?action=modifier_album" method="post">
    <fieldset>
        <legend>Modification de l'album : <?= $nomAlbum ?></legend>
        <div class="modifLabel">
            <input type="hidden" name="idAlbum" value="<?= $idAlbum ?>">
            <label>Nom de l'album</label><br>
            <label>Année de sortie</label><br>
            <label>Lien de l'image</label><br>
            <label>Artiste associé à l'album </label><br>
            <label>Description</label><br>
            <label>Genres</label><br>
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
            <!-- Liste dépliable des cases à cocher pour les genres -->
            <div class="dropdown-container">
                <div class="dropdown">
                    <input type="button" id="dropdown-button" value="Liste des genres  ▼"></input>
                    <div class="dropdown-content" id="dropdownContent">
                        <?php
                        foreach ($genres as $genre) {
                            $nomGenre = $genre['nomGenre'];
                            if ($genresAlbum != null && in_array($genre, $genresAlbum)) {
                                echo "<input type='checkbox' name='genres[]' value='" . $genre['idGenre'] . "' checked>" . $genre['nomGenre'] . "<br>";
                            } else {
                                echo "<input type='checkbox' name='genres[]' value='" . $genre['idGenre'] . "'>" . $genre['nomGenre'] . "<br>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <button type="submit">Modifier l'album</button>
        </div>
    </fieldset>
</form>
<script src="templates/static/js/dropdown.js"></script>
