<?php
//add or edit a book; $book is null when adding, set (with values) otherwise
$hasData = isset($book) && $book !== null;
$isEdit = $hasData && $book->getId() > 0;
$title = $hasData ? $book->getTitle() : '';
$author = $hasData ? $book->getAuthor() : '';
$description = $hasData ? ($book->getDescription() ?? '') : '';
$available = $hasData ? $book->getIsAvailable() : 1;
$cover = $hasData ? $book->getCover() : null;
?>
<section class="book-form">
    <div class="container">
        <a class="back-link" href="index.php?action=account">&larr; retour</a>
        <h1 class="book-form__title"><?= $isEdit ? 'Modifier les informations' : 'Ajouter un livre' ?></h1>

        <div class="card book-form__card">
            <?php if (!empty($errors)) { ?>
                <div class="form__error">
                    <?php foreach ($errors as $err) { ?>
                        <p><?= htmlspecialchars($err) ?></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <form class="book-form__grid" action="index.php?action=saveBook" method="post" enctype="multipart/form-data">
                <?php if ($isEdit) { ?>
                    <input type="hidden" name="id" value="<?= (int) $book->getId() ?>">
                <?php } ?>

                <div class="book-form__media">
                    <p class="form__label">Photo</p>
                    <?php if ($cover) { ?>
                        <img class="book-form__cover" id="cover-preview" src="./img/<?= htmlspecialchars($cover) ?>" alt="Couverture de <?= htmlspecialchars($title) ?>">
                    <?php } else { ?>
                        <div class="book-form__cover book-form__cover--empty" id="cover-placeholder">Aucune photo</div>
                    <?php } ?>
                    <input class="visually-hidden" type="file" id="cover" name="cover" accept=".jpg,.jpeg,.png">
                    <label class="book-form__file" for="cover"><?= $cover ? 'Modifier la photo' : 'Ajouter une photo' ?></label>
                    <p class="form__hint book-form__hint">Obligatoire, JPG ou PNG, 2 Mo maximum</p>
                </div>

                <div class="book-form__fields">
                    <div class="form__group">
                        <label class="form__label" for="title">Titre</label>
                        <input class="form__input form__input--filled" type="text" id="title" name="title" value="<?= htmlspecialchars($title) ?>" required>
                    </div>

                    <div class="form__group">
                        <label class="form__label" for="author">Auteur</label>
                        <input class="form__input form__input--filled" type="text" id="author" name="author" value="<?= htmlspecialchars($author) ?>" required>
                    </div>

                    <div class="form__group">
                        <label class="form__label" for="description">Commentaire</label>
                        <textarea class="form__input form__input--filled book-form__textarea" id="description" name="description" rows="8"><?= htmlspecialchars($description) ?></textarea>
                    </div>

                    <div class="form__group">
                        <label class="form__label" for="is_available">Disponibilité</label>
                        <select class="form__input form__input--filled" id="is_available" name="is_available">
                            <option value="1"<?= $available ? ' selected' : '' ?>>disponible</option>
                            <option value="0"<?= $available ? '' : ' selected' ?>>non disponible</option>
                        </select>
                    </div>

                    <button class="btn btn--primary btn--block" type="submit">Valider</button>
                </div>
            </form>
        </div>
    </div>
</section>
