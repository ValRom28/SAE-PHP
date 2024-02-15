<form action="/index.php" method="get" class="recherche" id="recherche">
    <input type="hidden" name="action" value="search">
    <input type="text" name="search" placeholder="Rechercher un album" class="text-field">
    <select name="genre" class="full-rounded">
        <option value="0">Tous les genres</option>
        <?php
        use Database\Genre;
        $pdo = new \PDO('sqlite:Data/db.sqlite');
        $request = new Genre($pdo);
        $genres = $request->afficherGenres();
        foreach ($genres as $genre) {
            echo '<option value="' . $genre['idGenre'] . '">' . $genre['nomGenre'] . '</option>';
        }
        ?>
    </select>
    <select name="artiste" class="full-rounded">
        <option value="0">Tous les artistes</option>
        <?php
        use Database\Artiste;
        $request = new Artiste($pdo);
        $artistes = $request->getArtistes();
        foreach ($artistes as $artiste) {
            echo '<option value="' . $artiste['idArtiste'] . '">' . $artiste['nomArtiste'] . '</option>';
        }
        ?>
    </select>
    <button type="submit" class="full-rounded">Rechercher</button>
</form>

<div class="buttonsConnexion">
    <a href="/">
        <button>Accueil</button>
    </a>
<?php
use Database\Utilisateur;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifiez si l'utilisateur est connecté
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // L'utilisateur est connecté, affichez le bouton de déconnexion
    echo '<form action="/index.php?action=logout" method="post"><button type="submit" class="déconnexion">Déconnexion</button></form>';
    $pdo = new \PDO('sqlite:Data/db.sqlite');
    
    $request = new Utilisateur($pdo);
    if($request->isAdmin($_SESSION['idUtilisateur'])){
        echo '<form action="/index.php?action=admin" method="post"><button type="submit" class="admin">Admin</button></form>';
    }
} else {
    // L'utilisateur n'est pas connecté, affichez le bouton de connexion
    echo '<form action="/index.php?action=login" method="post"><button action="/index.php?action=login" type="submit" class="connexion">Connexion</button></form>';
    echo '<form action="/index.php?action=register" method="post"><button type="submit" class="inscription">Inscription</button></form>';
}

?>
</div>