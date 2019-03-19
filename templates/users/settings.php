<?php include __DIR__ . '/../header.php'; ?>
    <div class="container">

        <?php if (!empty($error)): ?>
            <div class="row">
                <div class="col">
                    <div class="alert alert-danger" role="alert"><?= $error ?></div>
                </div>
            </div>
        <?php elseif(!empty($message)): ?>
            <div class="row">
                <div class="col">
                    <div class="alert alert-success" role="alert"><?= $message ?></div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-3">
                <input id="photo" type="image"
                       src="<?= 'http://blog.test/' . ($user->getPhoto() ?? 'uploads/default.png') ?>" height="150px"/>
            </div>
            <div class="col" style="margin-top: 7.5%"><h1><?= $user->getNickname() ?></h1></div>
        </div>

        <br />

        <form action="/settings" method="post" enctype="multipart/form-data" id="refreshForm">
            <div class="row" id="refreshButtonDiv">
                <div class="col">
                    <input type="file" name="attachment" id="my_file" style="display:inline-block"><br/>
                </div>
                <div class="col-5">
                    <button type="submit" class="btn btn-primary" id="test">Обновить фотографию</button>
                </div>
            </div>
        </form>


        <hr>

        <div class="row">
            <div class="col">
                <pre>Email:</pre>
            </div>
            <div class="col"><?= $user->getEmail() ?></div>
        </div>

        <div class="row">
            <div class="col">
                <pre>Registration date:</pre>
            </div>
            <div class="col"><?= $user->getRegistrationDate() ?></div>
        </div>
        <p></p>
    </div>

    <style>
        #photo:hover {
            filter: grayscale(0.5);
            transition: grayscale 0.3s;
        }
    </style>

    <script>
        var input = document.getElementById("my_file");
        document.getElementById("photo").onclick = function () {
            input.click();
        };
        input.onchange = function () {
            document.getElementById("test").classList.remove("disabled");
        };
    </script>
<?php include __DIR__ . '/../footer.php'; ?>