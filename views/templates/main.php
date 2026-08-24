<?php
//main layout, needs $title and $content
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> - TomTroc</title>
</head>

<body>
    <header class="header">
        <a class="header__brand" href="index.php">TomTroc</a>
        <nav class="header__nav">
            <a class="header__link" href="index.php">Accueil</a>
        </nav>
    </header>

    <main class="main">
        <?= $content ?>
    </main>

    <footer class="footer">
        <p class="footer__text">TomTroc</p>
    </footer>
</body>
</html>
