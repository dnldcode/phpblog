<?php include __DIR__ . '/../header.php'; ?>
    <div style="text-align: center;">
        <h1>Регистрация</h1>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert"><?= $error ?></div>
        <?php endif; ?>

        <form action="/users/register" method="post">
            <div style="text-align: left">
                <div class="form-group">
                    <label for="nickname">Nickname</label>
                    <input type="text" class="form-control" id="nickname" placeholder="Enter nickname" name="nickname"
                           value="<?= $_POST['nickname'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="text" class="form-control" id="email" placeholder="Enter email" name="email"
                           value="<?= $_POST['email'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password"
                           value="<?= $_POST['password'] ?? '' ?>">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>