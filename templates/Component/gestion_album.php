<h1>Gestion des Albums</h1>

    <!-- Formulaire de création d'un nouvel album -->
<h2>Créer un nouvel album</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <input type="text" name="nomAlbum" placeholder="Nom de l'album" required>
    <input type="text" name="lienImage" placeholder="Lien de l'image" required>
    <input type="text" name="anneeSortie" placeholder="Année de sortie" required>
    <input type="text" name="idArtiste" placeholder="ID de l'artiste" required>
    <textarea name="description" placeholder="Description de l'album"></textarea>
    <button type="submit" name="create">Créer</button>
</form>

    <!-- Formulaire de mise à jour d'un album -->
<h2>Modifier un album</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <input type="text" name="idAlbum" placeholder="ID de l'album à mettre à jour" required>
    <input type="text" name="nomAlbum" placeholder="Nouveau nom de l'album">
    <input type="text" name="lienImage" placeholder="Nouveau lien de l'image">
    <input type="text" name="anneeSortie" placeholder="Nouvelle année de sortie">
    <input type="text" name="idArtiste" placeholder="Nouvel ID de l'artiste">
    <textarea name="description" placeholder="Nouvelle description de l'album"></textarea>
    <button type="submit" name="update">Mettre à jour</button>
</form>

    <!-- Formulaire de suppression d'un album -->
<h2>Supprimer un album</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <input type="text" name="idAlbum" placeholder="ID de l'album à supprimer" required>
    <button type="submit" name="delete">Supprimer</button>
</form>