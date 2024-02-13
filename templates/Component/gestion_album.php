<?php
use Database\Album;
use Database\Artiste;

$pdo = new \PDO('sqlite:Data/db.sqlite');
$requestAlbum = new Album($pdo);
$requestArtiste = new Artiste($pdo);
$albums = $requestAlbum->getAlbums();
$artistes = $requestArtiste->getArtistes();
?>

<h1>Gestion des Albums</h1>

<!-- Formulaire pour créer un nouvel album -->
<h2>Créer un nouvel album</h2>
<form action="/index.php?action=creer_album" method="post">
    <fieldset>
        <legend>Créer un nouvel album</legend>
        <label for="nom_album">Nom de l'album :</label>
        <input type="text" id="nom_album" name="nom_album" required><br>
        <label for="lien_image">Lien de l'image de l'album :</label>
        <input type="text" id="lien_image" name="lien_image" required><br>
        <label for="annee_sortie">Année de sortie :</label>
        <input type="number" id="annee_sortie" name="annee_sortie" required><br>
        <label for="id_artiste">Artiste :</label>
        <select id="id_artiste" name="id_artiste" required>
            <?php foreach ($artistes as $artiste) { ?>
                <option value="<?= $artiste['idArtiste'] ?>"><?= $artiste['nomArtiste'] ?></option>
            <?php } ?>
        </select><br>
        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea>
    </fieldset>
    <button type="submit">Créer l'album</button>
</form>

<!-- Formulaire pour modifier un album existant -->
<h2>Modifier un album existant</h2>
<form action="/index.php?action=page_modifier_album" method="post">
    <fieldset>
        <legend>Choisir l'album à modifier :</legend>
        <select id="id_album" name="id_album">
            <?php foreach ($albums as $album) { ?>
                <option value="<?= $album['idAlbum'] ?>"><?= $album['nomAlbum'] ?></option>
            <?php } ?>
        </select>
    </fieldset>
    <button type="submit">Modifier l'album sélectionné</button>
</form>

<!-- Formulaire pour supprimer un album existant -->
<h2>Supprimer un album existant</h2>
<form action="/index.php?action=supprimer_album" method="post">
    <fieldset>
        <legend>Choisir l'album à supprimer :</legend>
        <select id="id_album" name="id_album">
            <?php foreach ($albums as $album) { ?>
                <option value="<?= $album['idAlbum'] ?>"><?= $album['nomAlbum'] ?></option>
            <?php } ?>
        </select>
    </fieldset>
    <button type="submit">Supprimer l'album sélectionné</button>
</form>
