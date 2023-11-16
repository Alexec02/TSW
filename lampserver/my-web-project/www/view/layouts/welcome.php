<?php
// file: view/layouts/welcome.php

$view = ViewManager::getInstance();
$flashMessage = $view->popFlash();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $view->getVariable("title", "no title") ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link rel="stylesheet" href= "css/styles.css">
    <?= $view->getFragment("css") ?>
    <?= $view->getFragment("javascript") ?>

   
</head>

<body class="bg-primary" style="background-image: url('images/fondo5.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; ;">


    <header class="bg-dark text-light p-3">
        <div class="container">
            <h1><?= i18n("Welcome to the Blog App!") ?></h1>
        </div>
    </header>
    <main class="container mt-3">
        <!-- flash message -->
        <?php if (!empty($flashMessage)): ?>
            <div id="flash" class="alert alert-info">
                <?= $flashMessage ?>
            </div>
        <?php endif; ?>
        <?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
    </main>
    <footer class="bg-dark text-light p-3">
        <div class="container">
            <?php include(__DIR__."/language_select_element.php"); ?>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>
