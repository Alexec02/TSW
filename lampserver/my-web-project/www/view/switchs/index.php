<?php
//file: view/posts/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$switchs = $view->getVariable("switchs");
$subscriptions = $view->getVariable("subscriptions");
$currentuser = $view->getVariable("currentusername");

$view->setVariable("nombre", "Switchs");

?><link rel="stylesheet" href="css/prueba.css" type="text/css">

<div class="switch-container">
        <h2><?=i18n("My Switchs")?> <a href="index.php?controller=switchs&amp;action=add&amp;?>"<?= i18n("Edit") ?>><button class="add-button"> +</button></a></h2>
        
        <ul class="switch-list">
			<?php foreach ($switchs as $switch): ?>
	
				<?php
				//show actions ONLY for the author of the post (if logged)


				if (isset($currentuser) && $currentuser == $switch->getAlias()->getUsername()): ?>

					<li class="switch-item" data-state="apagado">
					<span><?= $switch->getNombre()?><?php if(!$switch->encendido()): ?><img class="image" src="images/circuloRojo.png"></span> <span><form
				method="POST"
				action="index.php?controller=switchs&amp;action=edit"
				id="edit_switch_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>"
				style="display: inline"
				>

				<input type="hidden" name="public_id" value="<?= $switch->getPublicId() ?>">
				<input type="hidden" name="private_id" value="<?= $switch->getPrivateId() ?>">
				<?=i18n("Time on ")?> <input type="number" name="encendido_hasta" value=60 min=1 max=120 class="timeon"><br>
				<button class="toggle-button" onclick="document.getElementById('edit_switch_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>').submit()"><?=i18n("Switch on")?></button>

					</form>
					<?php else:?><img class="image" src="images/circuloVerde.png"></span> <span><form
				method="POST"
				action="index.php?controller=switchs&amp;action=edit"
				id="edit_switch_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>"
				style="display: inline"
				>

				<input type="hidden" name="public_id" value="<?= $switch->getPublicId() ?>">
				<input type="hidden" name="private_id" value="<?= $switch->getPrivateId() ?>">
				<input type="hidden" name="encendido_hasta" value=0>
				<button class="toggle-button" onclick="document.getElementById('edit_switch_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>').submit()"><?=i18n("Switch off")?></button>

					</form><?php endif;?>
					</span><span>
					<!--<button class="info-button">i</button>-->
					<form
				method="POST"
				action="index.php?controller=switchs&amp;action=delete"
				id="delete_switch_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>"
				style="display: inline"
				>

				<input type="hidden" name="public_id" value="<?= $switch->getPublicId() ?>">
				<input type="hidden" name="private_id" value="<?= $switch->getPrivateId() ?>">

				<a href="#" 
				onclick="
				if (confirm('<?= i18n("are you sure?")?>')) {
					document.getElementById('delete_switch_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>').submit()
				}"
				><?= i18n("Delete") ?> </a>

			</form><br>
			<label><?=i18n("Public ID: ")?><a href=http://localhost/index.php?controller=switchs&action=view&public_id=<?=$switch->getPublicId()?>><?=$switch->getPublicId()?></a><label><br>
			<label><?=i18n("Private ID: ")?><a href=http://localhost/index.php?controller=switchs&action=view&private_id=<?=$switch->getPrivateId()?>><?=$switch->getPrivateId()?></a><label></span>
				    	</li>

			&nbsp;


		<?php endif; ?>

<?php endforeach; ?>
</ul>
</div>

<div class="subscription-container">
        <h2><?=i18n("My Subscriptions")?></h2>
        
        <ul class="switch-list">
			<?php foreach ($subscriptions as $subscription): ?>
	
				<?php
				//show actions ONLY for the author of the post (if logged)


				if (isset($currentuser) && $currentuser == $subscription->getAlias()->getUsername()): ?>

					<li class="switch-item" data-state="apagado">
					<span><?= $subscription->getSwitchs()->getNombre()?>
			</span> <?php
			 if($subscription->getSwitchs()->encendido()): ?><img class="image" src="images/circuloRojo.png"><span><?= i18n("Author") ?>: <?= $subscription->getSwitchs()->getAlias()->getUsername()?></span>
					<span><?= i18n("Last modification") ?>: <?= $subscription->getSwitchs()->getEncendidoHasta()?></span><?php else:?><img class="image" src="images/circuloVerde.png"></span><span><?= i18n("Author") ?>: <?= $subscription->getSwitchs()->getAlias()->getUsername()?></span>
					<span><?= i18n("Time on") ?>: <?= $subscription->getSwitchs()->tiempoEncendido()?></span><?php endif;?>
					
					<form
				method="POST"
				action="index.php?controller=subscription&amp;action=delete"
				id="delete_subscription_<?= $subscription->getSwitchs()->getPublicId() ?>"
				style="display: inline"
				>

				<input type="hidden" name="public_id" value="<?= $subscription->getSwitchs()->getPublicId() ?>">

				<a href="#" 
				onclick="
				if (confirm('<?= i18n("are you sure?")?>')) {
					document.getElementById('delete_subscription_<?= $subscription->getSwitchs()->getPublicId() ?>').submit()
				}"
				><?= i18n("Delete") ?></a>

			</form>
				    	</li>

			&nbsp;


		<?php endif; ?>

<?php endforeach; ?>


