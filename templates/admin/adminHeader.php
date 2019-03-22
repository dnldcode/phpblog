<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Мой блог' ?></title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-2 p-4 left-panel">
            <div class="row">
                <a href="/adminpanel" style="text-decoration: none; color:white"><h2>Admin panel</h2></a>
            </div>
            <div class="row">

                <ul class="nav nav-pills nav-justified flex-column pt-5">
                    <li class="nav-item">
                        <a class="nav-link" href="/adminpanel">Все статьи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/adminpanel/comments">Все комментарии</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/adminpanel/users">Все пользователи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Заявки на публикацию</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-10">
            <div class="top-bar">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <?= $user->getNickname() ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="/">На главную страницу</a>
                        <a class="dropdown-item" href="#">Настройки</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/users/logout">Выйти</a>
                    </div>
                </div>
            </div>

            <hr/>

            <div class="main">