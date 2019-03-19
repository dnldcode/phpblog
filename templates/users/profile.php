<?php include __DIR__ . '/../header.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <img id="photo" type="image"
                       src="<?= 'http://blog.test/' . ($user->getPhoto() ?? 'uploads/default.png') ?>" height="150px"/>
            </div>
            <div class="col" style="margin-top: 7.5%"><h1><?= $profile->getNickname() ?></h1></div>
        </div>

        <hr>

        <div class="row">
            <div class="col">
                <pre>Email:</pre>
            </div>
            <div class="col"><?= $profile->getEmail() ?></div>
        </div>

        <div class="row">
            <div class="col">
                <pre>Registration date:</pre>
            </div>
            <div class="col"><?= $profile->getRegistrationDate() ?></div>
        </div>
    </div>
    <p></p>
<?php include __DIR__ . '/../footer.php'; ?>