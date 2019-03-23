<?php include __DIR__ . '/../header.php'; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert"><?= $error ?></div>
<?php endif; ?>
<h1>Создание новой статьи</h1>
<form action="/articles/add" method="post">
    <pre>Ваша статья будет проверена администратором и после опубликована.</pre>
    <br />
    <label for="name">Название статьи</label><br>
    <input type="text" name="name" id="name" value="<?= $_POST['name'] ?>" size="50"><br>

    <label for="text">Текст статьи</label><br>
    <textarea name="text" id="text" rows="10" cols="80"><?= $_POST['text'] ?></textarea><br><br>
    <button type="submit" class="btn btn-primary">Создать</button>
</form>
<?php include __DIR__ . '/../footer.php'; ?>