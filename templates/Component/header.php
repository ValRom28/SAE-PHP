<link rel= stylesheet href="templates/static/css/header.css">

<form action="/index.php" method="get" class="recherche" id="recherche">
    <input type="hidden" name="action" value="search">
    <input type="text" name="search" placeholder="Rechercher un album" class="text-field">
    <button type="submit" class="full-rounded">Rechercher</button>
</form>

<div class="buttonsConnexion">
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifiez si l'utilisateur est connecté
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // L'utilisateur est connecté, affichez le bouton de déconnexion
    echo '<form action="/index.php?action=logout" method="post"><button type="submit" class="déconnexion">Déconnexion</button></form>';
} else {
    // L'utilisateur n'est pas connecté, affichez le bouton de connexion
    echo '<form action="/index.php?action=login" method="post"><button action="/index.php?action=login" type="submit" class="connexion">Connexion</button></form>';
    echo '<form action="/index.php?action=register" method="post"><button type="submit" class="inscription">Inscription</button></form>';
}
?>
</div>