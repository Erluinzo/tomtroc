<?php
//main layout, needs $title and $content
$currentAction = $_GET['action'] ?? 'home';

//count of unread messages for the badge
$unreadMessages = isset($_SESSION['user'])
    ? (new MessageManager())->countUnread((int) $_SESSION['user']['id'])
    : 0;
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
                    <li><a href="index.php"<?= $currentAction === 'home' ? ' aria-current="page"' : '' ?>>Accueil</a></li>
                    <li><a href="index.php?action=books"<?= $currentAction === 'books' ? ' aria-current="page"' : '' ?>>Nos livres à l'échange</a></li>
                </ul>
            </nav>

            <nav class="nav nav--user" aria-label="Navigation du compte">
                <ul>
                    <li><a href="index.php?action=messaging"<?= $currentAction === 'messaging' ? ' aria-current="page"' : '' ?>>Messagerie<?php if ($unreadMessages > 0) { ?> <span class="badge"><?= $unreadMessages ?></span><?php } ?></a></li>
                    <li><a href="index.php?action=account"<?= $currentAction === 'account' ? ' aria-current="page"' : '' ?>>Mon compte</a></li>
                    <?php if (isset($_SESSION['user'])) { ?>
                        <li><a href="index.php?action=logout">Déconnexion</a></li>
                    <?php } else { ?>
                        <li><a href="index.php?action=login"<?= in_array($currentAction, ['login', 'register'], true) ? ' aria-current="page"' : '' ?>>Connexion</a></li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        <?= $content ?>
    </main>

    <footer class="footer">
        <div class="container footer__bar">
            <a class="footer__link" href="#">Politique de confidentialité</a>
            <a class="footer__link" href="#">Mentions légales</a>
            <span class="footer__copy">Tom Troc&copy;</span>
            <a class="footer__logo" href="index.php" aria-label="Tom Troc, accueil">TT</a>
        </div>
    </footer>
</body>
</html>
