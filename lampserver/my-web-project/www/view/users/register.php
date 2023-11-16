<?php
// file: view/users/register.php

require_once(__DIR__."/../../core/ViewManager.php");

$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
$user = $view->getVariable("user");
$view->setVariable("title", "Register");
?>
<link rel="stylesheet" href="css/styles.css">


<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5 shadow-lg rounded">
                <div class="card-header bg-dark text-white">
                    <h2 class="text-center"><?= i18n("Register")?></h2>
                </div>
                <div class="card-body">
                    <form action="index.php?controller=users&amp;action=register" method="POST">
                        <div class="mb-3">
                            <?= i18n("Username")?>:
                            <input type="text" class="form-control" name="username" value="<?= $user->getUsername() ?>">
                            <?= isset($errors["username"]) ? '<div class="text-danger">' . i18n($errors["username"]) . '</div>' : '' ?>
                        </div>

                        <div class="mb-3">
                            <?= i18n("Password")?>:
                            <input type="password" class="form-control" name="passwd" value="">
                            <?= isset($errors["passwd"]) ? '<div class="text-danger">' . i18n($errors["passwd"]) . '</div>' : '' ?>
                        </div>

                        <div class="mb-3">
                            <?= i18n("Email")?>:
                            <input type="text" class="form-control" name="email" value="">
                            <?= isset($errors["email"]) ? '<div class="text-danger">' . i18n($errors["email"]) . '</div>' : '' ?>
                        </div>

                        <button type="submit" class="btn btn-dark"><?= i18n("Register")?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



</body>
