</td>

<td width="300px" class="sidebar">
    <div class="sidebarHeader">Меню</div>
    <ul>
        <li><a href="/">Главная страница</a></li>
        <li><a href="#">Обо мне</a></li>
    </ul>
</td>
</tr>
<!-- Comments -->
<tr>
    <td colspan="2">
        <?php if ($user !== null): ?>
            <form action="/articles/<?= $article->getId() ?>/comments" method="post">
                <div class="card">
                    <div class="card-header">
                        Комментарии(<?= count($comments) ?>)
                    </div>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert"><?= $error ?></div>
                    <?php endif; ?>
                    <div class="card-body" style="text-align: center">
                        <textarea name="text" id="text" rows="6" cols="80"></textarea><br><br>
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </div>
                </div>
            </form>
            <?php foreach ($comments as $comment): ?>
                <br><br>
                <div class="card" id="comment<?= $comment->getId() ?>">
                    <div class="card-header">
                        <div style="display: inline-block;">
                            <?= \MyProject\Models\Users\User::getById($comment->getAuthorId())->getNickname() ?></div>
                        <div style="float: right">
                            <?php if ($user->getId() === $comment->getAuthorId() || $user->isAdmin()): ?>

                                <!-- <a href="/comments/<?= $comment->getId() ?>/edit" class="btn btn-primary"
                                   style="color: white"> <span aria-hidden="true">edit</span></a>        -->
                                <button class="btn btn-primary" style="color: white"
                                        onclick="editClick(<?= $comment->getId() ?>)">Редактировать
                                </button>
                            <?php endif; ?>

                            <?php if ($user !== null && $user->isAdmin() || $user->getId() === $comment->getAuthorId()): ?>
                                <a href="/comments/<?= $comment->getId() ?>/delete" class="btn btn-danger"
                                   style="color: white"> <span aria-hidden="true">&times;</span></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text" id="<?= $comment->getId() ?>"><?= $comment->getText(); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <br>
            <div style="text-align: center">
                <h4>Комментарии доступны только авторизированым пользователям</h4><br/><a href="/users/login">Войти</a>
                | <a href="/users/register">Зарегистрироваться</a><br /><br />
            </div>
        <?php endif; ?>
    </td>
</tr>
<!-- /Comments -->
<tr>
    <td class="footer" colspan="2">Все права защищены (c) Мой блог</td>
</tr>
</table>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
      integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</body>
</html>

<script>
    function editClick(str) {
        var element = document.getElementById(str);
        element.hidden = true;
        element.parentElement.innerHTML = "<form action=\"/comments/" + str + "/edit\" method=\"post\">\n" +
            "    <div class=\"card-body\" style=\"text-align: center\">\n" +
            "        <textarea name=\"text\" id=\"text\" rows=\"6\" cols=\"80\">" + element.innerHTML + "</textarea><br><br>\n" +
            "        <button type=\"submit\" class=\"btn btn-primary\" id=\"update\">Обновить</button>\n" +
            "    </div>\n" +
            "</form>\n";
    };
</script>