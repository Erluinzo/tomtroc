<?php
//public profile of a member, needs $user and $books
$bookCount = count($books);
$isSelf = isset($_SESSION['user']) && (int) $_SESSION['user']['id'] === $user->getId();
?>
<section class="profile-page">
    <div class="container">
        <div class="profile-page__grid">
            <div class="card account__profile">
                <?php if ($user->getAvatar()) { ?>
                    <img class="profile__avatar profile__avatar--img" src="./img/<?= htmlspecialchars($user->getAvatar()) ?>" alt="Avatar de <?= htmlspecialchars($user->getUsername()) ?>">
                <?php } else { ?>
                    <div class="profile__avatar" aria-hidden="true"><?= htmlspecialchars(strtoupper(mb_substr($user->getUsername(), 0, 1))) ?></div>
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

                <?php if (!$isSelf) { ?>
                    <a class="btn btn--outline profile__cta" href="index.php?action=startConversation&user=<?= (int) $user->getId() ?>">Écrire un message</a>
                <?php } ?>
            </div>

            <div class="card account__library profile-page__library">
                <table class="lib-table">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book) { ?>
                            <tr>
                                <td>
                                    <a href="index.php?action=book&id=<?= (int) $book->getId() ?>">
                                        <img class="lib-table__cover" src="./img/<?= htmlspecialchars($book->getCover()) ?>" alt="Couverture de <?= htmlspecialchars($book->getTitle()) ?>" width="60" height="85">
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($book->getTitle()) ?></td>
                                <td><?= htmlspecialchars($book->getAuthor()) ?></td>
                                <td>
                                    <div class="lib-table__desc"><?= htmlspecialchars($book->getDescription() ?? '') ?></div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <?php if (empty($books)) { ?>
                    <p class="lib-table__empty">Ce membre n'a pas encore de livre.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
