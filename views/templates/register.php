<?php
//register page
?>
<section class="auth">
    <div class="auth__form">
        <div class="auth__box">
            <h1 class="auth__title">Inscription</h1>

            <?php if (!empty($errors)) { ?>
                <div class="form__error">
                    <?php foreach ($errors as $err) { ?>
                        <p><?= htmlspecialchars($err) ?></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <form class="form" action="index.php?action=signup" method="post">
                <div class="form__group">
                    <label class="form__label" for="username">Pseudo</label>
                    <input class="form__input" type="text" id="username" name="username" value="<?= htmlspecialchars($username ?? '') ?>" required>
                </div>

                <div class="form__group">
                    <label class="form__label" for="email">Adresse email</label>
                    <input class="form__input" type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
                </div>

                <div class="form__group">
                    <label class="form__label" for="password">Mot de passe</label>
                    <input class="form__input" type="password" id="password" name="password" required>
                </div>

                <button class="btn btn--primary btn--block" type="submit">S'inscrire</button>
            </form>

            <p class="auth__switch">Déjà inscrit ? <a href="index.php?action=login">Connectez-vous</a></p>
        </div>
    </div>

    <div class="auth__media">
        <img src="./img/connexion.jpg" alt="" width="827" height="1012">
    </div>
</section>
