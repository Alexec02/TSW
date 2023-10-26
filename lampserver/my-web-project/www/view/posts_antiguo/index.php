<?php
//file: view/posts/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$switchs = $view->getVariable("switchs");
$currentuser = $view->getVariable("currentusername");

$view->setVariable("nombre", "Switchs");

?>

<div class="switch-container">
        <h2><?=i18n("Mis Switchs")?></h2>
        
        <ul class="switch-list">
			<?php foreach ($switchs as $switch): ?>
	
				<?php
				//show actions ONLY for the author of the post (if logged)


				if (isset($currentuser) && $currentuser == $switch->getAlias()->getUsername()): ?>

					<li class="switch-item" data-state="apagado">
					<span><?= $switch->getNombre()?> <img class="image" src="images/circuloRojo.png"></span>
					<button class="toggle-button">Encender</button>
					<button class="info-button">i</button>
				    	</li>

			&nbsp;


		<?php endif; ?>

<?php endforeach; ?>
</ul>
</div>

