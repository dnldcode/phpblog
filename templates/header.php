<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Мой блог' ?></title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
<table class="layout">
    <tr>
        <td colspan="2" class="header">
            <a href="/">Мой блог</a>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
            <?php if (!empty($user)): ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <?= $user->getNickname() ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="/user/id<?= $user->getId() ?>">Мой профиль</a>
                        <?php if ($user->isAdmin()): ?>
                            <a class="dropdown-item" href="/adminpanel">Админ панель</a>
                        <?php endif; ?>
                        <a class="dropdown-item" href="/myarticles">Мои статьи</a>
                        <a class="dropdown-item" href="/settings">Настройки</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/users/logout">Выйти</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="/users/login">Войти</a> | <a href="/users/register">Зарегистрироваться</a>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td>