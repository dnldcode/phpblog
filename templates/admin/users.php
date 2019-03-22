<?php include __DIR__ . '/adminHeader.php' ?>

<script>
    var temp = document.getElementsByClassName("nav-link");
    temp.item(2).classList.add("active");
</script>

<table class="table table-sm">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">Имя</th>
        <th scope="col">Статьи</th>
        <th scope="col">Email</th>
        <th scope="col">Дата</th>
        <th scope="col">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <th scope="row"><?= $user->getId() ?></th>
            <td><a href="/user/id<?= $user->getId() ?>"><?= $user->getNickname() ?></a></td>
            <td><a href="/adminpanel/users/<?= $user->getId() ?>/articles">Click</a></td>
            <td><?= $user->getEmail() ?></td>
            <td><?= $user->getRegistrationDate() ?></td>
            <td><a href="/adminpanel/users/<?= $user->getId() ?>/edit" class="btn btn-primary disabled"
                   style="color: white">Изменить</a></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/adminFooter.php' ?>
