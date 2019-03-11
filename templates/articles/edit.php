<?php include __DIR__ . '/../header.php'; ?>
    <h1>Редактирование статьи</h1>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert"><?= $error ?></div>
<?php endif; ?>
    <form action="/articles/<?= $article->getId() ?>/edit" method="post">
        <label for="name">Название статьи</label><br>
        <input type="text" name="name" id="name" value="<?= $_POST['name'] ?? $article->getName() ?>" size="50"><br>

        <label for="text">Текст статьи</label><br>
        <textarea name="text" id="text" rows="10" cols="80"><?= $_POST['text'] ?? $article->getText() ?></textarea><br><br>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
<?php include __DIR__ . '/../footer.php'; ?>