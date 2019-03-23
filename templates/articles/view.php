<?php include __DIR__ . '/../header.php'; ?>
    <h2><?= $article->getName() ?></h2>
<?php if (!$article->isPublished()): ?>
    <pre>(Не опубликована)</pre>
<?php endif; ?>
    <pre><?= $article->getText() ?></pre>
    <p>Автор: <a href="/user/id<?= $article->getAuthorId() ?>"><?= $article->getAuthor()->getNickname() ?></a></p>
<?php if ($user !== null && $user->isAdmin()): ?>
    <a href="/articles/<?= $article->getId() ?>/edit" class="btn btn-primary" style="color: white">Редактировать
        статью</a>
<?php elseif ($user->getId() === $article->getAuthorId()): ?>
    <a href="/articles/<?= $article->getId() ?>/delete" class="btn btn-danger" style="color: white">Удалить
        статью</a>
<?php endif; ?>
<?php include __DIR__ . '/../comments/comments.php'; ?>