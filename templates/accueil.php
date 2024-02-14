<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= stylesheet href="templates/static/css/accueil.css">
    <link rel= stylesheet href="templates/static/css/connexion.css">
    <link rel= stylesheet href="templates/static/css/header.css">
    <link rel="stylesheet" href="./templates/static/css/modif.css">
    <title>Sound Iut'o</title>
</head>
<body>
    <aside>
        <?php echo $aside ?? null ?>
    </aside>    
    <main>
        <header>
            <?php echo $header ?? null ?>
        </header>  
        <section class="main">
            <?php echo $content ?? null ?>
        </section>
    </main>
</body>
</html>