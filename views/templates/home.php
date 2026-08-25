<?php
//home page
?>
<section class="hero">
    <div class="container hero__inner">
        <div class="hero__text">
            <h1 class="hero__title">Rejoignez nos lecteurs passionnés</h1>
            <p class="hero__desc">Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.</p>
            <a class="btn btn--primary" href="#">Découvrir</a>
        </div>

        <figure class="hero__media">
            <img src="./img/hero.jpg" alt="Un lecteur installé au milieu de piles de livres" width="404" height="539">
            <figcaption class="hero__credit">Hamza</figcaption>
        </figure>
    </div>
</section>

<section class="latest">
    <div class="container">
        <h2 class="section-title">Les derniers livres ajoutés</h2>

        <ul class="book-grid">
            <?php foreach ($books as $book) { ?>
                <li class="book-card">
                    <a class="book-card__link" href="#">
                        <img class="book-card__cover" src="./img/<?= htmlspecialchars($book->getCover()) ?>" alt="Couverture de <?= htmlspecialchars($book->getTitle()) ?>" width="200" height="200">
                        <div class="book-card__body">
                            <h3 class="book-card__title"><?= htmlspecialchars($book->getTitle()) ?></h3>
                            <p class="book-card__author"><?= htmlspecialchars($book->getAuthor()) ?></p>
                            <p class="book-card__seller">Vendu par : <?= htmlspecialchars($book->getOwnerName()) ?></p>
                        </div>
                    </a>
                </li>
            <?php } ?>
        </ul>

        <div class="latest__cta">
            <a class="btn btn--primary" href="#">Voir tous les livres</a>
        </div>
    </div>
</section>
