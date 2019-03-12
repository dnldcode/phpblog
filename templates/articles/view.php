<?php include __DIR__ . '/../header.php'; ?>
    <h2><?= $article->getName() ?></h2>
    <p><?= $article->getText() ?></p>
    <p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
    <?php if ($user !== null && $user->isAdmin()): ?>
    <a href="/articles/<?= $article->getId() ?>/edit" class="btn btn-primary" style="color: white">Редактировать статью</a>
    <?php endif; ?>
<?php include __DIR__ . '/../comments/comments.php'; ?>