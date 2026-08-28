<?php
//account page, needs $user and $books
$bookCount = count($books);
?>
<section class="account">
    <div class="container">
        <h1 class="account__title">Mon compte</h1>

        <div class="account__cards">
            <div class="card account__profile">
                <?php if ($user->getAvatar()) { ?>
                    <img class="profile__avatar profile__avatar--img" src="./img/<?= htmlspecialchars($user->getAvatar()) ?>" alt="Avatar de <?= htmlspecialchars($user->getUsername()) ?>">
                <?php } else { ?>
                    <div class="profile__avatar" aria-hidden="true"><?= htmlspecialchars(strtoupper(mb_substr($user->getUsername(), 0, 1))) ?></div>
                <?php } ?>

                <form class="avatar-form" action="index.php?action=uploadAvatar" method="post" enctype="multipart/form-data">
                    <input class="visually-hidden" type="file" id="avatar" name="avatar" accept=".jpg,.jpeg,.png" onchange="this.form.submit()">
                    <label class="profile__edit" for="avatar">modifier</label>
                </form>

                <?php if (Utils::request('error') === 'avatar') { ?>
                    <p class="form__error profile__notice">La photo doit être une image JPG ou PNG de 2 Mo maximum.</p>
                <?php } elseif (Utils::request('saved') === 'avatar') { ?>
                    <p class="form__success profile__notice">Votre photo a été mise à jour.</p>
                <?php } ?>

                <hr class="profile__rule">

                <p class="profile__name"><?= htmlspecialchars($user->getUsername()) ?></p>
                <p class="profile__since">Membre depuis <?= htmlspecialchars(Utils::membershipLabel($user->getCreatedAt())) ?></p>

                <p class="profile__label">Bibliothèque</p>
                <p class="profile__count">
                    <svg viewBox="0 0 11 15" width="11" height="15" fill="currentColor" aria-hidden="true" focusable="false">
                        <path d="M3.275 0.565H1.015C0.454 0.565 0 1.019 0 1.58V13.134C0 13.695 0.454 14.149 1.015 14.149H3.275C3.835 14.149 4.29 13.695 4.29 13.134V1.58C4.29 1.019 3.835 0.565 3.275 0.565ZM0.715 1.58C0.715 1.414 0.849 1.28 1.015 1.28H3.275C3.441 1.28 3.575 1.414 3.575 1.58V13.134C3.575 13.3 3.441 13.434 3.275 13.434H1.015C0.849 13.434 0.715 13.3 0.715 13.134V1.58Z"></path>
                        <path d="M9.466 0.66L7.211 0.503C6.652 0.463 6.167 0.885 6.128 1.444L5.322 12.97C5.283 13.53 5.704 14.015 6.264 14.054L8.518 14.211C9.077 14.25 9.562 13.829 9.601 13.27L10.407 1.743C10.446 1.184 10.025 0.699 9.466 0.66ZM6.841 1.494C6.853 1.329 6.996 1.204 7.161 1.216L9.416 1.373C9.581 1.385 9.706 1.528 9.694 1.694L8.888 13.22C8.876 13.385 8.733 13.51 8.568 13.498L6.313 13.341C6.148 13.329 6.024 13.186 6.035 13.02L6.841 1.494Z"></path>
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
                <?php } elseif (Utils::request('saved') === '1') { ?>
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

            <?php if (Utils::request('saved') === 'book') { ?>
                <p class="form__success lib-table__notice">Le livre a été enregistré.</p>
            <?php } elseif (Utils::request('deleted')) { ?>
                <p class="form__success lib-table__notice">Le livre a été supprimé.</p>
            <?php } ?>

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
                            <td>
                                <div class="lib-table__actions">
                                    <a href="index.php?action=editBook&id=<?= (int) $book->getId() ?>">Éditer</a>
                                    <form class="inline-form" action="index.php?action=deleteBook" method="post" onsubmit="return confirm('Supprimer ce livre ?');">
                                        <input type="hidden" name="id" value="<?= (int) $book->getId() ?>">
                                        <button class="link-button lib-table__delete" type="submit">Supprimer</button>
                                    </form>
                                </div>
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
