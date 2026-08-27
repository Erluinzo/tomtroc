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
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <rect x="4" y="4" width="6" height="16" rx="1"></rect>
                        <rect x="14" y="4" width="6" height="16" rx="1"></rect>
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
