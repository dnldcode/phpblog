<?php include __DIR__ . '/../header.php'; ?>
<?php if (count($articles) === 0): ?>
    <div style="text-align: center">
        <br/>
        <h3>На данный момент нет ни одной статьи</h3>
    </div>
<?php else: ?>
    <?php foreach ($articles as $article): ?>
        <h2><a href="articles/<?= $article->getId() ?>"><?= $article->getName() ?></a></h2>
        <p><?= $article->getText() ?></p>
        <hr>
    <?php endforeach; ?>
<?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>
