<?php
//file: view/layouts/default.php

$view = ViewManager::getInstance();
$currentuser = $view->getVariable("currentusername");

?><!DOCTYPE html>
<html>
<head>
	<title><?= $view->getVariable("title", "no title") ?></title>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<!-- enable ji18n() javascript function to translate inside your scripts -->
	<script src="index.php?controller=language&amp;action=i18njs">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	</script>
	<link rel="stylesheet" href= "css/styles.css">
	<?= $view->getFragment("css") ?>
	<?= $view->getFragment("javascript") ?>
</head>
<body>
<!-- header -->
<header class="bg-dark text-light p-3">
	<div class="container">
		<div class="d-flex justify-content-between align-items-center">
			<h1 class="text-light">IAmON</h1>

			<nav id="menu">
				<ul class="list-unstyled mb-0">
					<?php if (isset($currentuser)): ?>
						<li class="d-inline me-3"><?= sprintf(i18n("Hello %s"), $currentuser) ?></li>
						<li class="d-inline">
							<a href="index.php?controller=users&amp;action=logout" class="text-light">(Logout)</a>
						</li>
					<?php else: ?>
						<li class="d-inline">
							<a href="index.php?controller=users&amp;action=login" class="text-light"><?= i18n("Login") ?></a>
						</li>
					<?php endif ?>
				</ul>
			</nav>
		</div>
	</div>
</header>


	<main class="container mt-3">
		<div id="flash">
			<?= $view->popFlash() ?>
		</div>

		<?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
	</main>

<!-- footer -->
<footer class="bg-dark text-light p-3">
	<div class="container">
		<div class="d-flex justify-content-between align-items-center">
			<div>
				<?php include(__DIR__."/language_select_element.php"); ?>
			</div>
			
		</div>
	</div>
</footer>


</body>
</html>