<?php
//main layout, needs $title and $content
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> - TomTroc</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <header class="header">
        <div class="container header__bar">
            <a class="logo" href="index.php" aria-label="Tom Troc, accueil">
                <span class="logo__mark" aria-hidden="true">TT</span>
                <span class="logo__word">Tom Troc</span>
            </a>

            <nav class="nav nav--main" aria-label="Navigation principale">
                <ul>
                    <li><a href="index.php" aria-current="page">Accueil</a></li>
                    <li><a href="#">Nos livres à l'échange</a></li>
                </ul>
            </nav>

            <nav class="nav nav--user" aria-label="Navigation du compte">
                <ul>
                    <li><a href="#">Messagerie <span class="badge">1</span></a></li>
                    <li><a href="#">Mon compte</a></li>
                    <li><a href="#">Connexion</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        <?= $content ?>
    </main>

    <footer class="footer">
        <p class="footer__text">TomTroc</p>
    </footer>
</body>
</html>
