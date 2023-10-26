<?php
//file: view/posts/add.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$switch = $view->getVariable("switch");
$errors = $view->getVariable("errors");

$view->setVariable("title", "Edit Switch");

?><h1><?= i18n("Create switch")?></h1>
<form action="index.php?controller=switchs&amp;action=add" method="POST">
	<?= i18n("nombre") ?>: <input type="text" name="nombre"
	value="<?= $switch->getNombre() ?>">
	<?= isset($errors["nombre"])?i18n($errors["nombre"]):"" ?><br>

	<input type="submit" name="submit" value="submit">
</form>
