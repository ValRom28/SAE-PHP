<?php
use Database\Album;
use Database\Artiste;
use Database\Genre;

$pdo = new \PDO('sqlite:Data/db.sqlite');
$requestAlbum = new Album($pdo);
$requestArtiste = new Artiste($pdo);
$requestGenre = new Genre($pdo);
$albums = $requestAlbum->getAllAlbums();
$artistes = $requestArtiste->getArtistes();
$genres = $requestGenre->getGenres();

session_start();
if (isset($_SESSION['message'])) {
    echo '<script>alert("' . $_SESSION['message'] . '")</script>';
    unset($_SESSION['message']); // Effacez le message de la session après l'avoir affiché
}
?>

<h1>Gestion des Albums</h1>

<!-- Formulaire pour créer un nouvel album -->
<form action="/index.php?action=creer_album" method="post">
    <fieldset>
        <legend>Créer un nouvel album</legend>
        <div class="modifLabel">
            <label for="nom_album">Nom de l'album </label><br>
            <label for="lien_image">Lien de l'image de l'album </label><br>
            <label for="annee_sortie">Année de sortie </label><br>
            <label for="id_artiste">Artiste </label><br>
            <label for="description">Description </label><br>
            <label for="genres">Genres</label><br>
        </div>
        <div class="modifInput">
            <input type="text" id="nom_album" name="nom_album"  required placeholder="Exemple : Absolution"><br>
            <input type="text" id="lien_image" name="lien_image" placeholder="Exemple : cover.jpg"><br>
            <input type="number" id="annee_sortie" name="annee_sortie" required placeholder="Exemple : 1978"><br>
            <select id="id_artiste" name="id_artiste" required>
                <?php foreach ($artistes as $artiste) { ?>
                    <option value="<?= $artiste['idArtiste'] ?>"><?= $artiste['nomArtiste'] ?></option>
                <?php } ?>
            </select><br>
            <textarea id="description" name="description" required placeholder="Description de l'album"></textarea><br>
            <div class="dropdown-container">
                <div class="dropdown">
                    <input type="button" id="dropdown-button" value="Liste des genres  ▼"></input>
                    <div class="dropdown-content" id="dropdownContent">
                        <?php
                        foreach ($genres as $genre) {
                            echo "<input type='checkbox' name='genres[]' value='" . $genre['idGenre'] . "'>" . $genre['nomGenre'] . "<br>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <button type="submit">Créer l'album</button>
        </div>
    </fieldset>
</form>

<!-- Formulaire pour modifier un album existant -->
<form action="/index.php?action=page_modifier_album" method="post">
    <fieldset>
        <legend>Choisir l'album à modifier</legend>
        <select id="id_album" name="id_album">
            <?php foreach ($albums as $album) { ?>
                <option value="<?= $album['idAlbum'] ?>"><?= $album['nomAlbum'] ?></option>
            <?php } ?>
        </select><br>
        <button type="submit">Modifier l'album sélectionné</button>
    </fieldset>
</form>

<!-- Formulaire pour supprimer un album existant -->
<form action="/index.php?action=supprimer_album" method="post">
    <fieldset>
        <legend>Choisir l'album à supprimer</legend>
        <select id="id_album" name="id_album">
            <?php foreach ($albums as $album) { ?>
                <option value="<?= $album['idAlbum'] ?>"><?= $album['nomAlbum'] ?></option>
            <?php } ?>
        </select><br>
        <button type="submit">Supprimer l'album sélectionné</button>
    </fieldset>
</form>
<script src="templates/static/js/dropdown.js"></script>