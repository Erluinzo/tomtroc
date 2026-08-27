<?php
//book detail page, needs a $book entity
?>
<nav class="breadcrumb" aria-label="Fil d'Ariane">
    <div class="container">
        <a href="index.php?action=books">Nos livres</a>
        <span class="breadcrumb__sep">&gt;</span>
        <span><?= htmlspecialchars($book->getTitle()) ?></span>
    </div>
</nav>

<section class="book">
    <div class="book__media">
        <img src="./img/<?= htmlspecialchars($book->getCover()) ?>" alt="Couverture de <?= htmlspecialchars($book->getTitle()) ?>">
    </div>

    <div class="book__info">
        <div class="book__info-inner">
            <h1 class="book__title"><?= htmlspecialchars($book->getTitle()) ?></h1>
            <p class="book__author">par <?= htmlspecialchars($book->getAuthor()) ?></p>

            <hr class="book__rule">

            <h2 class="book__label">Description</h2>
            <div class="book__desc">
                <?php if ($book->getDescription()) { ?>
                    <p><?= nl2br(htmlspecialchars($book->getDescription())) ?></p>
                <?php } else { ?>
                    <p>Aucune description pour ce livre.</p>
                <?php } ?>
            </div>

            <h2 class="book__label">Propriétaire</h2>
            <a class="owner" href="#">
                <span class="owner__avatar" aria-hidden="true"><?= htmlspecialchars(strtoupper(mb_substr($book->getOwnerName(), 0, 1))) ?></span>
                <span class="owner__name"><?= htmlspecialchars($book->getOwnerName()) ?></span>
            </a>

            <a class="btn btn--primary btn--block book__cta" href="index.php?action=startConversation&user=<?= (int) $book->getUserId() ?>">Envoyer un message</a>
        </div>
    </div>
</section>
