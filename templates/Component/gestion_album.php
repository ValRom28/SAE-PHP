<?php
use Database\Album;
$pdo = new \PDO('sqlite:Data/db.sqlite');
$request = new Album($pdo);
$albums = $request->getAlbums();
?>

<h1>Gestion des Albums</h1>

<!-- Formulaire pour modifier un album existant -->
<h2>Modifier un album existant</h2>
<form action="/index.php?action=page_modifier_album" method="post">
    <fieldset>
        <legend>Choisir l'album à modifier :</legend>
        <?php foreach ($albums as $album) { ?>
            <label>
                <input type="radio" name="id_album" value="<?= $album['idAlbum'] ?>">
                <?= $album['nomAlbum'] ?>
            </label><br>
        <?php } ?>
    </fieldset>
    <button type="submit">Modifier l'album sélectionné</button>
</form>

<!-- Formulaire pour supprimer un album existant -->
<h2>Supprimer un album existant</h2>
<form action="/index.php?action=supprimer_album" method="post">
    <fieldset>
        <legend>Choisir l'album à supprimer :</legend>
        <?php foreach ($albums as $album) { ?>
            <label>
                <input type="radio" name="id_album" value="<?= $album['idAlbum'] ?>">
                <?= $album['nomAlbum'] ?>
            </label><br>
        <?php } ?>
    </fieldset>
    <button type="submit">Supprimer l'album sélectionné</button>
</form>
