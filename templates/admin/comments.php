<?php include __DIR__ . '/adminHeader.php' ?>

<script>
    var temp = document.getElementsByClassName("nav-link");
    temp.item(1).classList.add("active");
</script>

<table class="table table-sm">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">Комментарий</th>
        <th scope="col">Автор</th>
        <th scope="col">Дата</th>
        <th scope="col">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($comments as $comment): ?>
        <tr>
            <th scope="row"><?= $comment->getId() ?></th>
            <td><?= $comment->getText() ?></td>
            <td><a href="/user/id<?= $comment->getAuthorId() ?>"><?= $comment->getAuthor()->getNickname() ?></a></td>
            <td><?= $comment->getDate() ?></td>
            <td><a href="/comments/<?= $comment->getId() ?>/delete" class="btn btn-danger"
                   style="color: white">Удалить комментарий</a></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/adminFooter.php' ?>
