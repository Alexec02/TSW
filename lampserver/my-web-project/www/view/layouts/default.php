<?php
//file: view/layouts/default.php

$view = ViewManager::getInstance();
$currentuser = $view->getVariable("currentusername");

?><!DOCTYPE html>
<html>
<head>
	<title><?= $view->getVariable("title", "no title") ?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" href= "css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<!-- enable ji18n() javascript function to translate inside your scripts -->
	<script src="index.php?controller=language&amp;action=i18njs">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	</script>
	<?= $view->getFragment("css") ?>
	<?= $view->getFragment("javascript") ?>
</head>
<body>
	<!-- header -->
	<header>
		<h1>IAmON</h1>
		<nav id="menu" style="background-color:grey">
			<ul>

				<?php if (isset($currentuser)): ?>
					<li><?= sprintf(i18n("Hello %s"), $currentuser) ?>
						<a 	href="index.php?controller=users&amp;action=logout">(Logout)</a>
					</li>

				<?php else: ?>
					<li><a href="index.php?controller=users&amp;action=login"><?= i18n("Login") ?></a></li>
				<?php endif ?>
			</ul>
		</nav>
	</header>

	<main>
		<div id="flash">
			<?= $view->popFlash() ?>
		</div>

		<?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
	</main>

	<footer>
		<?php
		include(__DIR__."/language_select_element.php");
		?>
	</footer>

</body>
</html>
