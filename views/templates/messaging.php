<?php
//messaging page, needs $conversations, $active, $messages, $currentUserId

//render an avatar as a picture when available, otherwise the first letter
$renderAvatar = function (?string $avatar, string $name, string $class): void {
    if ($avatar) {
        echo '<img class="' . $class . ' ' . $class . '--img" src="./img/' . htmlspecialchars($avatar) . '" alt="">';
    } else {
        echo '<span class="' . $class . '" aria-hidden="true">' . htmlspecialchars(strtoupper(mb_substr($name, 0, 1))) . '</span>';
    }
};
?>
<section class="messaging">
    <aside class="messaging__sidebar">
        <h1 class="messaging__title">Messagerie</h1>

        <ul class="conv-list">
            <?php foreach ($conversations as $conv) { ?>
                <li class="conv-item<?= ($active && $active->getId() === $conv->getId()) ? ' conv-item--active' : '' ?>">
                    <a class="conv-item__link" href="index.php?action=messaging&id=<?= (int) $conv->getId() ?>">
                        <?php $renderAvatar($conv->getOtherAvatar(), $conv->getOtherUsername(), 'conv-item__avatar'); ?>
                        <span class="conv-item__body">
                            <span class="conv-item__top">
                                <span class="conv-item__name"><?= htmlspecialchars($conv->getOtherUsername()) ?></span>
                                <?php if ($conv->getLastMessageAt()) { ?>
                                    <span class="conv-item__time"><?= htmlspecialchars(Utils::shortTime($conv->getLastMessageAt())) ?></span>
                                <?php } ?>
                            </span>
                            <span class="conv-item__preview"><?= htmlspecialchars($conv->getLastMessage() ?? 'Aucun message') ?></span>
                        </span>
                    </a>
                </li>
            <?php } ?>

            <?php if (empty($conversations)) { ?>
                <li class="conv-empty">Aucune conversation pour le moment.</li>
            <?php } ?>
        </ul>
    </aside>

    <div class="messaging__thread">
        <?php if ($active) { ?>
            <div class="thread__head">
                <?php $renderAvatar($active->getOtherAvatar(), $active->getOtherUsername(), 'thread__avatar'); ?>
                <span class="thread__name"><?= htmlspecialchars($active->getOtherUsername()) ?></span>
            </div>

            <div class="thread__messages">
                <?php foreach ($messages as $msg) {
                    $mine = $msg->getSenderId() === $currentUserId;
                    $stamp = date('d.m H:i', strtotime($msg->getCreatedAt())); ?>
                    <div class="msg <?= $mine ? 'msg--mine' : 'msg--other' ?>">
                        <div class="msg__meta">
                            <?php if (!$mine) {
                                $renderAvatar($active->getOtherAvatar(), $active->getOtherUsername(), 'msg__avatar');
                            } ?>
                            <span class="msg__time"><?= htmlspecialchars($stamp) ?></span>
                        </div>
                        <div class="msg__bubble"><?= nl2br(htmlspecialchars($msg->getContent())) ?></div>
                    </div>
                <?php } ?>
            </div>

            <form class="thread__form" action="index.php?action=sendMessage" method="post">
                <input type="hidden" name="conversation_id" value="<?= (int) $active->getId() ?>">
                <input class="thread__input" type="text" name="content" placeholder="Tapez votre message ici" autocomplete="off" required>
                <button class="btn btn--primary" type="submit">Envoyer</button>
            </form>
        <?php } else { ?>
            <div class="thread__empty">
                <p>Sélectionnez une conversation pour afficher les messages.</p>
            </div>
        <?php } ?>
    </div>
</section>
