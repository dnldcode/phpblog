<?php include __DIR__ . '/../header.php'; ?>
<div style="text-align: center;">
    <form action="/users/login" method="post">
        <h1>Вход</h1>
        <br>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert"><?= $error ?></div>
        <?php endif; ?>
        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" placeholder="Введите email" name="email" value="<?= $_POST['email'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label>Пароль</label>
            <input type="password" class="form-control" placeholder="Пароль" name="password" value="<?= $_POST['password'] ?? '' ?>">
        </div>
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
</div>
<?php include __DIR__ . '/../footer.php'; ?>