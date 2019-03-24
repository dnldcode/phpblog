<?php include __DIR__ . '/../header.php'; ?>
    <div class="container">

        <?php if (!empty($error)): ?>
            <div class="row">
                <div class="col">
                    <div class="alert alert-danger" role="alert"><?= $error ?></div>
                </div>
            </div>
        <?php elseif (!empty($message)): ?>
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

        <br/>

        <form action="/settings" method="post" enctype="multipart/form-data" id="refreshForm">
            <div class="row" id="refreshButtonDiv">
                <div class="col">
                    <input type="file" name="attachment" id="my_file" style="display:inline-block"><br/>
                </div>
                <div class="col-5">
                    <button type="submit" class="btn btn-primary">Обновить фотографию</button>
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

        <div id="password">

            <div class="row">
                <div class="col">
                    <pre>Password:</pre>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col" style="padding-top: 7px">**********</div>
                        <div class="col">
                            <button type="button" class="btn btn-link" id="password_change" onclick="password_change()">
                                Изменить
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

        function password_change() {
            document.getElementById("password").innerHTML = "            <form action=\"/settings\" method=\"post\">\n" +
                "                <div class=\"row\">\n" +
                "                    <div class=\"col\">\n" +
                "                        <pre>Старый пароль:</pre>\n" +
                "                    </div>\n" +
                "                    <div class=\"col\">\n" +
                "                        <input type=\"password\" name=\"password\" />\n" +
                "                    </div>\n" +
                "                </div>\n" +
                "                <div class=\"row\">\n" +
                "                    <div class=\"col\">\n" +
                "                        <pre>Новый пароль:</pre>\n" +
                "                    </div>\n" +
                "                    <div class=\"col\">\n" +
                "                        <input type=\"password\" name=\"newPassword\" />\n" +
                "                    </div>\n" +
                "                </div>\n" +
                "                <div class=\"row\">\n" +
                "                    <div class=\"col\">\n" +
                "                        <pre>Повторите пароль:</pre>\n" +
                "                    </div>\n" +
                "                    <div class=\"col\">\n" +
                "                        <input type=\"password\" name=\"newPasswordConfirmed\" />\n" +
                "                    </div>\n" +
                "                </div>\n" +
                "                <div class=\"row\">\n" +
                "                    <div class=\"col\"></div>\n" +
                "                    <div class=\"col\">\n" +
                "                        <div class=\"row\">\n" +
                "                            <div class=\"col-4\">\n" +
                "                                <button type=\"submit\" class=\"btn btn-primary\" name=\"changePassword\">Изменить</button>\n" +
                "                            </div>\n" +
                "                            <div class=\"col\">\n" +
                "                                <button type=\"button\" class=\"btn btn-danger\" onclick='password_cancel()'>Отмена</button>\n" +
                "                            </div>\n" +
                "                        </div>\n" +
                "\n" +
                "                    </div>\n" +
                "                </div>\n" +
                "            </form>";
        };

        function password_cancel() {
            document.getElementById("password").innerHTML = "            <div class=\"row\">\n" +
                "                <div class=\"col\">\n" +
                "                    <pre>Password:</pre>\n" +
                "                </div>\n" +
                "                <div class=\"col\">\n" +
                "                    <div class=\"row\">\n" +
                "                        <div class=\"col\" style=\"padding-top: 7px\">\n" +
                "                            **********\n" +
                "                        </div>\n" +
                "                        <div class=\"col\">\n" +
                "                            <button type=\"button\" class=\"btn btn-link\" id=\"password_change\" onclick=\"password_change()\">Изменить</button>\n" +
                "                        </div>\n" +
                "                    </div>\n" +
                "                </div>\n" +
                "            </div>";
        };

    </script>
<?php include __DIR__ . '/../footer.php'; ?>