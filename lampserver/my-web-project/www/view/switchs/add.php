<?php
//file: view/posts/add.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$switch = $view->getVariable("switch");
$errors = $view->getVariable("errors");

$view->setVariable("title", "Edit Switch");

?>
<link rel="stylesheet" href="css/nuevoSwitch.css" type="text/css">

<h1><?= i18n("Create switch")?></h1>
<form action="index.php?controller=switchs&amp;action=add" method="POST">
    <div class="form-container">
        <div class="form-group">
            <label for="nombre"><?= i18n("Name") ?>:</label>
            <input type="text" name="nombre" id="nombre" value="<?= $switch->getNombre() ?>">
            <?= isset($errors["nombre"]) ? i18n($errors["nombre"]) : "" ?>
        </div>

        <div class="form-group">
            <label for="descripcion"><?= i18n("Description") ?>:</label>
            <input type="text" name="descripcion" id="descripcion" value="<?= $switch->getDescripcion() ?>">
            <?= isset($errors["descripcion"]) ? i18n($errors["descripcion"]) : "" ?>
        </div>

        <div class="form-group">
            <input type="submit" name="submit" value="<?= i18n("Submit") ?>">
        </div>
    </div>
</form>
