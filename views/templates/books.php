<?php
//public book listing
?>
<section class="catalog">
    <div class="container">
        <div class="catalog__head">
            <h1 class="catalog__title">Nos livres à l'échange</h1>

            <form class="search" action="index.php" method="get">
                <input type="hidden" name="action" value="books">
                <span class="search__icon" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <circle cx="11" cy="11" r="7"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
                <input class="search__input" type="search" name="search" placeholder="Rechercher un livre" value="<?= htmlspecialchars($search) ?>" aria-label="Rechercher un livre">
            </form>
        </div>

        <?php if (empty($books)) { ?>
            <p class="catalog__empty">Aucun livre ne correspond à votre recherche.</p>
        <?php } else { ?>
            <ul class="book-grid">
                <?php foreach ($books as $book) { ?>
                    <li class="book-card">
                        <a class="book-card__link" href="#">
                            <img class="book-card__cover" src="./img/<?= htmlspecialchars($book->getCover()) ?>" alt="Couverture de <?= htmlspecialchars($book->getTitle()) ?>" width="200" height="200">
                            <?php if (!$book->getIsAvailable()) { ?>
                                <span class="book-card__badge">non dispo.</span>
                            <?php } ?>
                            <div class="book-card__body">
                                <h2 class="book-card__title"><?= htmlspecialchars($book->getTitle()) ?></h2>
                                <p class="book-card__author"><?= htmlspecialchars($book->getAuthor()) ?></p>
                                <p class="book-card__seller">Vendu par : <?= htmlspecialchars($book->getOwnerName()) ?></p>
                            </div>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</section>
