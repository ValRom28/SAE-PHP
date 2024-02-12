<form action="/index.php" method="get">
    <input type="hidden" name="action" value="search">
    <input type="text" name="search" placeholder="Rechercher un album..." class="text-field">
    <button type="submit" class="full-rounded">
        <span>Rechercher</span>
        <div class="border full-rounded"></div>
    </button>
</form>

<?php
// Démarrez la session (si ce n'est pas déjà fait)
session_start();

// Vérifiez si l'utilisateur est connecté
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // L'utilisateur est connecté, affichez le bouton de déconnexion
    echo '
        <form action="/index.php?action=logout" method="post">
            <button type="submit" class="déconnexion">
                <span>Déconnexion</span>
                <div class="border full-rounded"></div>
            </button>
        </form>
    ';
} else {
    // L'utilisateur n'est pas connecté, affichez le bouton de connexion
    echo '
        <form action="/index.php?action=login" method="post">
            <button action="/index.php?action=login" type="submit" class="connexion">
                <span>Connexion</span>
                <div class="border full-rounded"></div>
            </button>
        </form>
    ';
}
?>

<form action="/index.php?action=register" method="post">
    <button type="submit" class="inscription">
        <span>Inscription</span>
        <div class="border full-rounded"></div>
    </button>
</form>
