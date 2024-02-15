<?php
use Database\Artiste;

$pdo = new \PDO('sqlite:Data/db.sqlite');
$requestArtiste = new Artiste($pdo);

$idArtiste = $_POST['id_artiste'] ?? null;
$artiste = $requestArtiste->getArtisteById($idArtiste);

if ($artiste) {
    $nomArtiste = $artiste[0]['nomArtiste'];
    $lienImage = $artiste[0]['imageArtiste'];
?>

<form action="/index.php?action=modifier_artiste" method="post">
    <fieldset>
        <legend>Modification de l'artiste <?= $nomArtiste ?></legend>
            <div class="modifLabel">
                <input type="hidden" name="idArtiste" value="<?= $idArtiste ?>">
                <label>Nom de l'artiste</label><br>
                <label>Lien de l'image</label><br>
            </div>
            <div class="modifInput">
                <input type="text" name="nouveau_nom" value="<?= $nomArtiste ?>"><br>
                <input type="text" name="nouveau_lien" value="<?= $lienImage ?>"><br>
                <button type="submit">Modifier l'artiste</button>
            </div>
    </fieldset>
</form>
<?php
} else {
    echo "L'artiste que vous essayez de modifier n'existe pas.";
}
?>
