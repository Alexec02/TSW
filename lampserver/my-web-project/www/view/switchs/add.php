<?php
//file: view/posts/add.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$switch = $view->getVariable("switch");
$errors = $view->getVariable("errors");

$view->setVariable("title", "Edit Switch");

?>
<link rel="stylesheet" href= "css/styles.css">
<style>
        body {
            background-image: url('images/fondo5.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #fff;
        }
    </style>
<h1 class="text-dark" style="text-shadow: 0px 2px 2px rgba(0, 0, 0, 0.5);"><?= i18n("Create switch")?></h1>
<form action="index.php?controller=switchs&amp;action=add" method="POST">
    <div class="form-container">
        <h5 class="form-group mb-3 text-dark">
            <label for="nombre" class="form-label"><?= i18n("Name") ?>:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" value="<?= $switch->getNombre() ?>">
            <?= isset($errors["nombre"]) ? '<div class="text-danger">' . i18n($errors["nombre"]) . '</div>' : '' ?>
    </h5>

        <h5 class="form-group mb-3  text-dark">
            <label for="descripcion" class="form-label"><?= i18n("Description") ?>:</label>
            <input type="text" class="form-control" name="descripcion" id="descripcion" value="<?= $switch->getDescripcion() ?>">
            <?= isset($errors["descripcion"]) ? '<div class="text-danger">' . i18n($errors["descripcion"]) . '</div>' : '' ?>
    </h5>

        <div class="form-group">
            <input type="submit" class="btn btn-dark" name="submit" value="<?= i18n("Submit") ?>">
        </div>
    </div>
</form>
