<?php
//account page, needs $user and $books
$bookCount = count($books);
?>
<section class="account">
    <div class="container">
        <h1 class="account__title">Mon compte</h1>

        <div class="account__cards">
            <div class="card account__profile">
                <div class="profile__avatar" aria-hidden="true"><?= htmlspecialchars(strtoupper(mb_substr($user->getUsername(), 0, 1))) ?></div>
                <a class="profile__edit" href="#">modifier</a>

                <hr class="profile__rule">

                <p class="profile__name"><?= htmlspecialchars($user->getUsername()) ?></p>
                <p class="profile__since">Membre depuis <?= htmlspecialchars(Utils::membershipLabel($user->getCreatedAt())) ?></p>

                <p class="profile__label">Bibliothèque</p>
                <p class="profile__count">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <rect x="4" y="4" width="6" height="16" rx="1"></rect>
                        <rect x="14" y="4" width="6" height="16" rx="1"></rect>
                    </svg>
                    <?= $bookCount ?> livre<?= $bookCount > 1 ? 's' : '' ?>
                </p>
            </div>

            <div class="card account__info">
                <h2 class="account__subtitle">Vos informations personnelles</h2>

                <form class="form" action="index.php?action=account" method="post">
                    <div class="form__group">
                        <label class="form__label" for="email">Adresse email</label>
                        <input class="form__input form__input--filled" type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>">
                    </div>

                    <div class="form__group">
                        <label class="form__label" for="password">Mot de passe</label>
                        <input class="form__input form__input--filled" type="password" id="password" name="password" placeholder="••••••••">
                    </div>

                    <div class="form__group">
                        <label class="form__label" for="username">Pseudo</label>
                        <input class="form__input form__input--filled" type="text" id="username" name="username" value="<?= htmlspecialchars($user->getUsername()) ?>">
                    </div>

                    <button class="btn btn--outline" type="submit">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</section>
