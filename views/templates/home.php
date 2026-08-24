<?php
//home page, needs a $user
?>
<section class="home">
    <h1 class="home__title">Bienvenue sur TomTroc</h1>
    <p class="home__text">Premier membre enregistré : <?= htmlspecialchars($user->getUsername()) ?></p>
    <p class="home__text">Membre depuis le <?= htmlspecialchars($user->getCreatedAt()) ?></p>
</section>
