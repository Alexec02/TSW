<?php
//file: view/posts/view.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$switch = $view->getVariable("switch");
$currentuser = $view->getVariable("currentusername");
$errors = $view->getVariable("errors");

$view->setVariable("title", "View Switch");
?>

<link rel="stylesheet" href= "css/styles.css">

<style>
        body {
            background-image: url('images/fondo5.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #fff;
        }
    </style>
<div class="container mt-3 text-dark">
    <h1 style="text-shadow: 0px 2px 2px rgba(0, 0, 0, 0.5);" ><?= i18n("Switch") . ": " . htmlentities($switch->getNombre()) ?></h1>
    <em><?= sprintf(i18n("by %s"), $switch->getAlias()->getUsername()) ?></em>
    <h2 style="text-shadow: 0px 2px 2px rgba(0, 0, 0, 0.5);" ><?= i18n("Description") ?>:</h2>
    <p><?= htmlentities($switch->getDescripcion()) ?></p>

    <?php if ($switch->encendido() == false): ?>
        <div class="d-flex align-items-center">
            <img class="img-thumbnail mr-2" src="images/circuloRojo.png" style="width: 24px; height: 24px;">
            <span><?= i18n("Last modification") ?>: <?= $switch->getEncendidoHasta() ?></span>
        </div>
    <?php else: ?>
        <div class="d-flex align-items-center">
            <img class="img-thumbnail mr-2" src="images/circuloVerde.png" style="width: 24px; height: 24px;">
            <span><?= i18n("Time on") ?>: <?= $switch->tiempoEncendido() ?></span>
        </div>
    <?php endif; ?>

    <?php
    $publicid = isset($_GET["public_id"]) ? $_GET["public_id"] : null;
    $privateid = isset($_GET["private_id"]) ? $_GET["private_id"] : null;
    if ($switch->getPublicId() == $publicid):
        if (!isset($this->currentUser)): ?>
            <form method="POST" action="index.php?controller=subscription&amp;action=add" id="add_subscription_<?= $switch->getPublicId() ?>_<?= $switch->getPrivateId() ?>" style="display: inline">
                <input type="hidden" name="public_id" value="<?= $switch->getPublicId() ?>">
                <input type="hidden" name="private_id" value="<?= $switch->getPrivateId() ?>">
                <button type="submit" class="btn btn-dark"><?= i18n("Subscribe") ?></button>
            </form>
        <?php endif; elseif ($switch->getPrivateId() == $privateid): ?>
            <li class="switch-item" data-state="apagar">
                <?php if ($switch->encendido() == false): ?>
                    <form method="POST" action="index.php?controller=switchs&amp;action=edit" id="edit_switch_<?= $switch->getPublicId() ?>_<?= $switch->getPrivateId() ?>" style="display: inline">
                        <input type="hidden" name="public_id" value="<?= $switch->getPublicId() ?>">
                        <input type="hidden" name="private_id" value="<?= $switch->getPrivateId() ?>">
                        <input type="hidden" name="estado" value=1>
                        <div class="mb-3">
                            <label for="encendido_hasta"><?= i18n("Time on") ?></label>
                            <input type="number" class="form-control" name="encendido_hasta" value="60" min="1" max="120">
                        </div>
                        <button type="submit" class="btn btn-success"><?= i18n("Switch on") ?></button>
                    </form>
                <?php else: ?>
                    <form method="POST" action="index.php?controller=switchs&amp;action=edit" id="edit_switch_<?= $switch->getPublicId() ?>_<?= $switch->getPrivateId() ?>" style="display: inline">
                        <input type="hidden" name="public_id" value="<?= $switch->getPublicId() ?>">
                        <input type="hidden" name="private_id" value="<?= $switch->getPrivateId() ?>">
                        <input type="hidden" name="encendido_hasta" value=0>
                        <input type="hidden" name="estado" value=0>
                        <button type="submit" class="btn btn-danger"><?= i18n("Switch off") ?></button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endif; ?>
</div>
