<?php
use Database\Artiste;

$pdo = new \PDO('sqlite:Data/db.sqlite');
$requestArtiste = new Artiste($pdo);
$artistes = $requestArtiste->getArtistes();
?>

<h1>Gestion des Artistes</h1>

<!-- Formulaire pour créer un nouvel artiste -->
<form action="/index.php?action=creer_artiste" method="post">
    <fieldset>
        <legend>Créer un nouvel artiste</legend>
        <div class="modifLabel">
            <label for="nom_artiste">Nom de l'artiste </label><br>
            <label for="lien_image">Lien de l'image de l'artiste </label><br>
        </div>
        <div class="modifInput">
            <input type="text" id="nom_artiste" name="nom_artiste" required placeholder="Exemple : U2"><br>
            <input type="text" id="lien_image" name="lien_image"><br>
            <button type="submit">Créer l'artiste</buttonx>
        </div>
    </fieldset>
</form>

<!-- Formulaire pour modifier un artiste existant -->
<form action="/index.php?action=page_modifier_artiste" method="post">
    <fieldset>
        <legend>Choisir l'artiste à modifier </legend>
        <select id="id_artiste" name="id_artiste">
            <?php foreach ($artistes as $artiste) { ?>
                <option value="<?= $artiste['idArtiste'] ?>"><?= $artiste['nomArtiste'] ?></option>
            <?php } ?>
        </select>
        <button type="submit">Modifier l'artiste sélectionné</button>
    </fieldset>
</form>

<!-- Formulaire pour supprimer un artiste existant -->
<form action="/index.php?action=supprimer_artiste" method="post">
    <fieldset>
        <legend>Choisir l'artiste à supprimer </legend>
        <select id="id_artiste" name="id_artiste">
            <?php foreach ($artistes as $artiste) { ?>
                <option value="<?= $artiste['idArtiste'] ?>"><?= $artiste['nomArtiste'] ?></option>
            <?php } ?>
        </select>
        <button type="submit">Supprimer l'artiste sélectionné</button>
    </fieldset>
</form>
