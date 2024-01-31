<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= stylesheet href="templates/static/css/accueil.css">
    <title>Sound Iut'o</title>
</head>
<body>
    <header>
        <?php echo $header ?? null ?>
    </header>    
    <main>
        <aside>
            <?php echo $aside ?? null ?>
        </aside>
        <?php echo $content ?? null ?>
    </main>
</body>
</html>