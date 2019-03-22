<?php include __DIR__ . '/adminHeader.php' ?>

<script>
    var temp = document.getElementsByClassName("nav-link");
    temp.item(0).classList.add("active");
</script>

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
            <td><a href="/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a></td>
            <td><?= $article->getShortText() ?></td>
            <td><a href="/user/id<?= $article->getAuthorId() ?>"><?= $article->getAuthor()->getNickname() ?></a></td>
            <td><?= $article->getDate() ?></td>
            <td><a href="/articles/<?= $article->getId() ?>/edit" class="btn btn-primary"
                   style="color: white">Редактировать статью</a></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/adminFooter.php' ?>
