<?php
// file: view/users/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Login");
$errors = $view->getVariable("errors");

?>
<link rel="stylesheet" href="css/styles.css">

<body class="bg-primary">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5 shadow-2">
                <div class="card-header bg-dark text-white">
                    <h2 class="text-center"><?= i18n("Login") ?></h2>
                </div>

                <div class="card-body">
                    <?= isset($errors["general"]) ? '<div class="alert alert-danger">' . $errors["general"] . '</div>' : '' ?>

                    <form action="index.php?controller=users&amp;action=login" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label"><?= i18n("Username") ?>:</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="passwd" class="form-label"><?= i18n("Password") ?>:</label>
                            <input type="password" class="form-control" id="passwd" name="passwd">
                        </div>
                        <button type="submit" class="btn btn-dark"><?= i18n("Login") ?></button>
                    </form>
                </div>
            </div>

            <p class="mt-3"><?= i18n("Not a user?")?> <a href="index.php?controller=users&amp;action=register"><?= i18n("Register here!")?></a></p>
        </div>
    </div>
</div>



</body>


