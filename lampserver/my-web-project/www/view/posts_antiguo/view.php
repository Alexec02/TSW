<?php
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$switch = $view->getVariable("switch");
$currentuser = $view->getVariable("currentusername");
$errors = $view->getVariable("errors");

$view->setVariable("title", "View Switch");

?><h1><?= i18n("Switch").": ".htmlentities($switch->getTitle()) ?></h1>
<em><?= sprintf(i18n("by %s"),$switch->getAlias()->getUsername()) ?></em>
<p>
	<?= htmlentities($switch->getName()) ?>
</p>

