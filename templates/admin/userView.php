<?php include __DIR__ . '/adminHeader.php' ?>

<script>
    var temp = document.getElementsByClassName("nav-link");
    temp.item(2).classList.add("active");
</script>

<div class="container">
    <div class="row">
        <div class="col">
        <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" role="alert"><?= $error ?></div>
        <?php elseif(!empty($message)): ?>
                    <div class="alert alert-success" role="alert"><?= $message ?></div>
        <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <img id="photo" type="image"
                 src="<?= 'http://blog.test/' . ($profile->getPhoto() ?? 'uploads/default.png') ?>" height="150px"/>
        </div>
        <div class="col" style="margin-top: 3.5%"><h1><?= $profile->getNickname() ?></h1></div>
    </div>

    <hr>

    <form method="post">
        <div class="row">
            <div class="col">
                <pre>Email:</pre>
            </div>

            <div class="col">
                <input name="email" type="text" value="<?= $profile->getEmail() ?>"/>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <pre>Registration date:</pre>
            </div>
            <div class="col">
                <input disabled type="text" value="<?= $profile->getRegistrationDate() ?>"/>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <pre>Is confirmed:</pre>
            </div>
            <div class="col">
                <select name="activated" class="custom-select custom-select-sm col-6" value="user"
                        id="activation_select">
                    <option>1</option>
                    <option>0</option>
                </select>
                <script type="text/javascript">
                    var activation = <?php echo json_encode($profile->isActivated()); ?>;
                    document.getElementById('activation_select').value = activation;
                </script>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <pre>Role:</pre>
            </div>
            <div class="col">
                <select name="role" class="custom-select custom-select-sm col-6" value="user" id="admin_select">
                    <option>admin</option>
                    <option>user</option>
                </select>
                <script type="text/javascript">
                    var role = <?php echo json_encode($profile->getRole()); ?>;

                    document.getElementById('admin_select').value = role;
                </script>
            </div>
        </div>

        <br/>

        <div style="text-align: center">
            <button type="submit" class="btn btn-primary">Редактировать пользователя</button>

        </div>
    </form>

</div>


<?php include __DIR__ . '/adminFooter.php' ?>
