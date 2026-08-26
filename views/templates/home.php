<?php
//home page
?>
<section class="hero">
    <div class="container hero__inner">
        <div class="hero__text">
            <h1 class="hero__title">Rejoignez nos lecteurs passionnés</h1>
            <p class="hero__desc">Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.</p>
            <a class="btn btn--primary" href="index.php?action=books">Découvrir</a>
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
                    <a class="book-card__link" href="index.php?action=book&id=<?= (int) $book->getId() ?>">
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
            <a class="btn btn--primary" href="index.php?action=books">Voir tous les livres</a>
        </div>
    </div>
</section>

<section class="how">
    <div class="container">
        <h2 class="section-title">Comment ça marche ?</h2>
        <p class="how__intro">Échanger des livres avec TomTroc c'est simple et amusant ! Suivez ces étapes pour commencer :</p>

        <ul class="steps">
            <li class="step">Inscrivez-vous gratuitement sur notre plateforme.</li>
            <li class="step">Ajoutez les livres que vous souhaitez échanger à votre profil.</li>
            <li class="step">Parcourez les livres disponibles chez d'autres membres.</li>
            <li class="step">Proposez un échange et discutez avec d'autres passionnés de lecture.</li>
        </ul>

        <div class="how__cta">
            <a class="btn btn--outline" href="index.php?action=books">Voir tous les livres</a>
        </div>
    </div>
</section>

<div class="banner"></div>

<section class="values">
    <div class="container">
        <div class="values__inner">
            <h2 class="values__title">Nos valeurs</h2>

            <div class="values__text">
                <p>Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.</p>
                <p>Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé.</p>
                <p>Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.</p>
            </div>

            <p class="values__team">L'équipe Tom Troc</p>
            <img class="values__heart" src="./img/heart.svg" alt="" width="100" height="88">
        </div>
    </div>
</section>
