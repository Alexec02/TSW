<?php
//file: view/posts/add.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$switch = $view->getVariable("switch");
$errors = $view->getVariable("errors");

$view->setVariable("title", "Edit Switch");

?>
<link rel="stylesheet" type="text/css" href="nuevoSwitch.css">

<h1><?= i18n("Create switch")?></h1>
<form action="index.php?controller=switchs&amp;action=add" method="POST">
	<?= i18n("Name") ?>: <input type="text" name="nombre"
	value="<?= $switch->getNombre() ?>">
	<?= isset($errors["nombre"])?i18n($errors["nombre"]):"" ?><br>
	<?= i18n("Description") ?>: <input type="text" name="descripcion"
	value="<?= $switch->getDescripcion() ?>">
	<?= isset($errors["descripcion"])?i18n($errors["descripcion"]):"" ?><br>

	<input type="submit" name="submit" value="<?= i18n("Submit") ?>">
	
</form>
