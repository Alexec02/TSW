<?php
//file: view/users/register.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
$user = $view->getVariable("user");
$view->setVariable("title", "Register");

?>
<body >
<div class= "title"><?= i18n("Register")?></div>
<link rel="stylesheet" href= "css/login.css">

	<div class = "auth-container" >
<form action="index.php?controller=users&amp;action=register" method="POST">
	<?= i18n("Username")?>: <input type="text" name="username"
	value="<?= $user->getUsername() ?>">
	<?= isset($errors["username"])?i18n($errors["username"]):"" ?><br>

	<?= i18n("Password")?>: <input type="password" name="passwd"
	value="">
	<?= isset($errors["passwd"])?i18n($errors["passwd"]):"" ?><br>

	
	<?= i18n("Email")?>: <input type="text" name="email"
	value="">
	<?= isset($errors["email"])?i18n($errors["email"]):"" ?><br>

	<input type="submit" value="<?= i18n("Register")?>">
</div>
</body>
</form>
