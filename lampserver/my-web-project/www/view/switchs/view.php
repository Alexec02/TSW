<?php
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$switch = $view->getVariable("switch");
$currentuser = $view->getVariable("currentusername");
$errors = $view->getVariable("errors");

$view->setVariable("title", "View Switch");

?><h1><?= i18n("Switch").": ".htmlentities($switch->getNombre()) ?></h1>
<em><?= sprintf(i18n("by %s"),$switch->getAlias()->getUsername()) ?></em>
<h2><?= i18n("Description") ?>:</h2>
<p>
	<?= htmlentities($switch->getDescripcion()) ?>
</p>
<?php if($switch->encendido()): ?>
<img class="image" src="images/circuloRojo.png" width=10px height=10px><span>
<?= i18n("Last modification") ?>: <?=$switch->getEncendidoHasta()?></span></span>
<?php else:?>
<img class="image" src="images/circuloVerde.png" width=10px heigth=10px><span>
<?= i18n("Time on") ?>: <?=$switch->tiempoEncendido()?></span>
<?php endif;?>
<?php $publicid = isset($_GET["public_id"]) ? $_GET["public_id"] : null;
$privateid = isset($_GET["private_id"]) ? $_GET["private_id"] : null;
if($switch->getPublicId()==$publicid):
	if(!isset($this->currentUser)):?>
<form
				method="POST"
				action="index.php?controller=subscription&amp;action=add"
				id="add_subscription_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>"
				style="display: inline"
				>

				<input type="hidden" name="public_id" value="<?= $switch->getPublicId() ?>">
				<input type="hidden" name="private_id" value="<?= $switch->getPrivateId() ?>">
<button href="#" 
				onclick="document.getElementById('add_subscription_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>').submit()"
				><?= i18n("Subscribe") ?></button>
</form>
<?php endif; elseif($switch->getPrivateId()==$privateid):?>
	<li class="switch-item" data-state="apagado">
					<?php if($switch->getEstado()==0): ?><form
				method="POST"
				action="index.php?controller=switchs&amp;action=edit"
				id="edit_switch_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>"
				style="display: inline"
				>

				<input type="hidden" name="public_id" value="<?= $switch->getPublicId() ?>">
				<input type="hidden" name="private_id" value="<?= $switch->getPrivateId() ?>">
				<input type="hidden" name="estado" value=1>
				<label><?=i18n("Time on ")?></label><input type=number name="encendido_hasta" value=60 min=1 max=120>
				<button class="toggle-button" onclick="document.getElementById('edit_switch_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>').submit()"><?=i18n("Switch on")?></button>

					</form>
					<?php else:?><form
				method="POST"
				action="index.php?controller=switchs&amp;action=edit"
				id="edit_switch_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>"
				style="display: inline"
				>

				<input type="hidden" name="public_id" value="<?= $switch->getPublicId() ?>">
				<input type="hidden" name="private_id" value="<?= $switch->getPrivateId() ?>">
				<input type="hidden" name="estado" value=0>
				<input type="hidden" name="encendido_hasta" value=0>
				<button class="toggle-button" onclick="document.getElementById('edit_switch_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>').submit()"><?=i18n("Switch off")?></button>

					</form></span><?php endif;?>
<?php endif;?>
