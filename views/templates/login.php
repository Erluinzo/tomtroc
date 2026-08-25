<?php
//login page
?>
<section class="auth">
    <div class="auth__form">
        <div class="auth__box">
            <h1 class="auth__title">Connexion</h1>

            <?php if (!empty($error)) { ?>
                <p class="form__error"><?= htmlspecialchars($error) ?></p>
            <?php } ?>

            <form class="form" action="index.php?action=authenticate" method="post">
                <div class="form__group">
                    <label class="form__label" for="email">Adresse email</label>
                    <input class="form__input" type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
                </div>

                <div class="form__group">
                    <label class="form__label" for="password">Mot de passe</label>
                    <input class="form__input" type="password" id="password" name="password" required>
                </div>

                <button class="btn btn--primary btn--block" type="submit">Se connecter</button>
            </form>

            <p class="auth__switch">Pas de compte ? <a href="index.php?action=register">Inscrivez-vous</a></p>
        </div>
    </div>

    <div class="auth__media">
        <img src="./img/connexion.jpg" alt="" width="827" height="1012">
    </div>
</section>
