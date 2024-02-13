<?php
use Database\Artiste;

$pdo = new \PDO('sqlite:Data/db.sqlite');
$requestArtiste = new Artiste($pdo);

$idArtiste = $_POST['id_artiste'] ?? null;
$artiste = $requestArtiste->getArtisteById($idArtiste);

if ($artiste) {
    $nomArtiste = $artiste[0]['nomArtiste'];
    $lienImage = $artiste[0]['lienImage'];
?>

<form action="/index.php?action=modifier_artiste" method="post">
    <input type="hidden" name="idArtiste" value="<?= $idArtiste ?>">
    <label>Nom de l'artiste:
        <input type="text" name="nouveau_nom" value="<?= $nomArtiste ?>">
    </label><br>
    <label>Lien de l'image:
        <input type="text" name="nouveau_lien" value="<?= $lienImage ?>">
    </label><br>
    <button type="submit">Modifier l'artiste</button>
</form>
<?php
} else {
    echo "L'artiste que vous essayez de modifier n'existe pas.";
}
?>
