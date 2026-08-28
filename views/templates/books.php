<?php
//public book listing
?>
<section class="catalog">
    <div class="container">
        <div class="catalog__head">
            <h1 class="catalog__title">Nos livres à l’échange</h1>

            <form class="search" action="index.php" method="get">
                <input type="hidden" name="action" value="books">
                <span class="search__icon" aria-hidden="true">
                    <svg viewBox="0 0 18 17" width="18" height="17" focusable="false">
                        <path fill="currentColor" d="M16 16L16.354 15.646V15.646L16 16ZM13 13L12.646 12.646L12.293 13L12.646 13.354L13 13ZM16.707 16L16.354 15.646L16.354 15.646L16.707 16ZM16.707 15.293L16.354 15.646V15.646L16.707 15.293ZM13.707 12.293L14.061 11.939L13.707 11.586L13.354 11.939L13.707 12.293ZM14.5 8C14.5 11.59 11.59 14.5 8 14.5V15.5C12.142 15.5 15.5 12.142 15.5 8H14.5ZM8 1.5C11.59 1.5 14.5 4.41 14.5 8H15.5C15.5 3.858 12.142 0.5 8 0.5V1.5ZM1.5 8C1.5 4.41 4.41 1.5 8 1.5V0.5C3.858 0.5 0.5 3.858 0.5 8H1.5ZM8 14.5C4.41 14.5 1.5 11.59 1.5 8H0.5C0.5 12.142 3.858 15.5 8 15.5V14.5ZM16.354 15.646L13.354 12.646L12.646 13.354L15.646 16.354L16.354 15.646ZM16.354 15.646L16.354 15.646L15.646 16.354C16.037 16.744 16.67 16.744 17.061 16.354L16.354 15.646ZM16.354 15.646L16.354 15.646L17.061 16.354C17.451 15.963 17.451 15.33 17.061 14.939L16.354 15.646ZM13.354 12.646L16.354 15.646L17.061 14.939L14.061 11.939L13.354 12.646ZM13.354 13.354L14.061 12.646L13.354 11.939L12.646 12.646L13.354 13.354Z"></path>
                    </svg>
                </span>
                <input class="search__input" type="search" name="search" maxlength="100" placeholder="Rechercher un livre" value="<?= htmlspecialchars($search) ?>" aria-label="Rechercher un livre">
            </form>
        </div>

        <?php if (empty($books)) { ?>
            <p class="catalog__empty">Aucun livre ne correspond à votre recherche.</p>
        <?php } else { ?>
            <ul class="book-grid">
                <?php foreach ($books as $book) { ?>
                    <li class="book-card">
                        <a class="book-card__link" href="index.php?action=book&id=<?= (int) $book->getId() ?>">
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
