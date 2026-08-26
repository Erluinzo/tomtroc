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

                <?php if (!empty($errors)) { ?>
                    <div class="form__error">
                        <?php foreach ($errors as $err) { ?>
                            <p><?= htmlspecialchars($err) ?></p>
                        <?php } ?>
                    </div>
                <?php } elseif (Utils::request('saved')) { ?>
                    <p class="form__success">Vos informations ont été mises à jour.</p>
                <?php } ?>

                <form class="form" action="index.php?action=updateAccount" method="post">
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

        <div class="card account__library">
            <div class="account__library-head">
                <a class="btn btn--primary" href="index.php?action=editBook">Ajouter un livre</a>
            </div>

            <table class="lib-table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Description</th>
                        <th>Disponibilité</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book) { ?>
                        <tr>
                            <td>
                                <img class="lib-table__cover" src="./img/<?= htmlspecialchars($book->getCover()) ?>" alt="Couverture de <?= htmlspecialchars($book->getTitle()) ?>" width="60" height="85">
                            </td>
                            <td><?= htmlspecialchars($book->getTitle()) ?></td>
                            <td><?= htmlspecialchars($book->getAuthor()) ?></td>
                            <td>
                                <div class="lib-table__desc"><?= htmlspecialchars($book->getDescription() ?? '') ?></div>
                            </td>
                            <td>
                                <?php if ($book->getIsAvailable()) { ?>
                                    <span class="pill pill--available">disponible</span>
                                <?php } else { ?>
                                    <span class="pill pill--unavailable">non dispo.</span>
                                <?php } ?>
                            </td>
                            <td class="lib-table__actions">
                                <a href="index.php?action=editBook&id=<?= (int) $book->getId() ?>">Éditer</a>
                                <form class="inline-form" action="index.php?action=deleteBook" method="post">
                                    <input type="hidden" name="id" value="<?= (int) $book->getId() ?>">
                                    <button class="link-button lib-table__delete" type="submit">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <?php if (empty($books)) { ?>
                <p class="lib-table__empty">Vous n'avez pas encore de livre dans votre bibliothèque.</p>
            <?php } ?>
        </div>
    </div>
</section>
