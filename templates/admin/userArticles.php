<?php include __DIR__ . '/adminHeader.php' ?>

<script>
    var temp = document.getElementsByClassName("nav-link");
    temp.item(0).classList.add("active");
</script>

<div class="row">
    <div class="col">
        <h1><?= $profile->getNickname() ?>'s articles: </h1>
    </div>
</div>

<br/>
<br/>

<table class="table table-sm">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">Название</th>
        <th scope="col">Описание</th>
        <th scope="col">Автор</th>
        <th scope="col">Дата</th>
        <th scope="col">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($articles as $article): ?>
        <tr>
            <th scope="row"><?= $article->getId() ?></th>
            <td>
                <a href="/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a>
                <?php if (!$article->isPublished()): ?>
                    <pre>(не опубликована)</pre>
                <?php endif; ?>
            </td>
            <td><?= $article->getShortText() ?></td>
            <td><a href="/user/id<?= $article->getAuthorId() ?>"><?= $article->getAuthor()->getNickname() ?></a></td>
            <td><?= $article->getDate() ?></td>
            <td><a href="/articles/<?= $article->getId() ?>/edit" class="btn btn-primary"
                   style="color: white">Редактировать</a>
                <?php if (!$article->isPublished()): ?>
                <a href="/articles/<?= $article->getId() ?>/publish" class="btn btn-primary"
                   style="color: white">Опубликовать</a></td>
            <?php else: ?>
                <a href="/articles/<?= $article->getId() ?>/hide" class="btn btn-primary"
                   style="color: white">Скрыть</a></td>
            <?php endif; ?>
            </td>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/adminFooter.php' ?>
