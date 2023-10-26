<?php
//file: view/posts/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$switchs = $view->getVariable("switchs");
$currentuser = $view->getVariable("currentusername");

$view->setVariable("nombre", "Switchs");

?>

<div class="switch-container">
        <h2><?=i18n("Mis Switchs")?> <a href="index.php?controller=switchs&amp;action=add&amp;?>"<?= i18n("Edit") ?>><button class="add-button"> +</button></a></h2>
        
        <ul class="switch-list">
			<?php foreach ($switchs as $switch): ?>
	
				<?php
				//show actions ONLY for the author of the post (if logged)


				if (isset($currentuser) && $currentuser == $switch->getAlias()->getUsername()): ?>

					<li class="switch-item" data-state="apagado">
					<span><?= $switch->getNombre()?> <?php if($switch->getEstado()==0): ?><img class="image" src="images/circuloRojo.png" width=10px height=10px><?php else:?><img class="image" src="images/circuloVerde.png"width=10px height=10px></span><?php endif;?>
					<button class="toggle-button">Encender</button>
					<button class="info-button">i</button>
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
				><?= i18n("Delete") ?></a>

			</form><br>
			<label><?=i18n("ID publica ")?><?=$switch->getPublicId()?><label><br>
			<label><?=i18n(" ID privada ")?><?=$switch->getPrivateId()?><label>
				    	</li>

			&nbsp;


		<?php endif; ?>

<?php endforeach; ?>
</ul>
</div>

<div class="subscription-container">
        <h2><?=i18n("Mis Subscripciones")?></h2>
        
        <ul class="switch-list">
			<?php foreach ($switchs as $switch): ?>
	
				<?php
				//show actions ONLY for the author of the post (if logged)


				if (isset($currentuser) && $currentuser == $switch->getAlias()->getUsername()): ?>

					<li class="switch-item" data-state="apagado">
					<span><?= $switch->getNombre()?><?php if($switch->getEstado()==0): ?><img class="image" src="images/circuloRojo.png" width=10px height=10px><?php else:?><img class="image" src="images/circuloVerde.png"width=10px height=10px></span><?php endif;?>
					<span><?= $switch->getAlias()->getUsername()?></span>
					<span><?= $switch->getUltimaModificacion()?></span
					<button class="info-button">i</button>
				    	</li>

			&nbsp;


		<?php endif; ?>

<?php endforeach; ?>


