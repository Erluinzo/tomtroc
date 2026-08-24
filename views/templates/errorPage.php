<?php
//error page, needs $errorMessage
?>
<section class="error">
    <h1 class="error__title">Oups</h1>
    <p class="error__message"><?= htmlspecialchars($errorMessage) ?></p>
    <a class="error__link" href="index.php?action=home">Retour à l'accueil</a>
</section>
