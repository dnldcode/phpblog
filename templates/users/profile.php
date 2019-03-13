<?php include __DIR__ . '/../header.php'; ?>
    <div>
        <h1><?= $profile->getNickname() ?></h1>
        <hr>

        <div class="container">
            <div class="row">
                <div class="col"><pre>Email:</pre></div>
                <div class="col"><?= $profile->getEmail() ?></div>
            </div>

            <div class="row">
                <div class="col"><pre>Registration date:</pre></div>
                <div class="col"><?= $profile->getRegistrationDate() ?></div>
            </div>
        </div>
        <p></p>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>