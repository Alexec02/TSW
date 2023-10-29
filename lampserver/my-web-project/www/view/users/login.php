<?php
//file: view/users/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Login");
$errors = $view->getVariable("errors");
?>

<body>

<div class="page-container">
<div class= "title"><?= i18n("Login") ?></div>
<?= isset($errors["general"])?$errors["general"]:"" ?>



<div class= "auth-container" >
<form action="index.php?controller=users&amp;action=login" method="POST">
	<?= i18n("Username")?>: <input type="text" name="username">
	<?= i18n("Password")?>: <input type="password" name="passwd">
	<input type="submit" value="<?= i18n("Login") ?>">
</form>
</div>


<p><?= i18n("Not user?")?> <a href="index.php?controller=users&amp;action=register"><?= i18n("Register here!")?></a></p>

</body>
<?php $view->moveToFragment("css");?>
<link rel="stylesheet" href= "css/login.css">
<?php $view->moveToDefaultFragment(); ?>