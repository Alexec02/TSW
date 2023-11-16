<?php
// file: view/posts/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$switchs = $view->getVariable("switchs");
$subscriptions = $view->getVariable("subscriptions");
$currentuser = $view->getVariable("currentusername");

$view->setVariable("nombre", "Switchs");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Title</title>
    <!-- Incluimos los archivos CSS y JS de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-image: url('images/fondo5.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="switch-container rounded">
                <h2 class="text-dark" style="text-shadow: 0px 2px 2px rgba(0, 0, 0, 0.5);">
                    <?=i18n("My Switchs")?> <a href="index.php?controller=switchs&amp;action=add&amp;"<?= i18n("Edit") ?>><button class="btn btn-dark"> +</button></a></h2>

                    
                    <div class="switch-list-container">
                        <?php foreach ($switchs as $switch): ?>
                            <?php if (isset($currentuser) && $currentuser == $switch->getAlias()->getUsername()): ?>
                                <div class="switch-item-container border p-3 mb-4 bg-light shadow rounded switch-item-container" data-state="apagado">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <!-- First Column: Name, Circle Image, and Time On -->
                                            <h4 class="text-dark"><?= $switch->getNombre() ?></h4>
                                            <span class="text-dark">
                                                <?php if ($switch->encendido() == false): ?>
                                                    <img class="small-image" src="images/circuloRojo.png">
                                                <?php else: ?>
                                                    <img class="small-image" src="images/circuloVerde.png">
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Second Column: Buttons (Switch On/Off, Delete) -->
                                            <form method="POST" action="index.php?controller=switchs&amp;action=edit"
                                                id="edit_switch_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>"
                                                class="d-flex align-items-center">
                                                <input type="hidden" name="public_id" value="<?= $switch->getPublicId() ?>">
                                                <input type="hidden" name="private_id" value="<?= $switch->getPrivateId() ?>">
                                                <?php if($switch->encendido()==false): ?>
                                                    <input type="hidden" name="estado" value=1>
                                                    <span class="text-dark"><?=i18n("Time on ")?></span>
                                                    <input type="number" name="encendido_hasta" value=60 min=1 max=120 class="timeon form-control mx-2">
                                                    <button class="btn btn-success" onclick="document.getElementById('edit_switch_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>').submit()"><?=i18n("Switch on")?></button>
                                                <?php else: ?>
                                                    <input type="hidden" name="encendido_hasta" value=0>
                                                    <input type="hidden" name="estado" value=0>
                                                    <button class="btn btn-danger" onclick="document.getElementById('edit_switch_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>').submit()"><?=i18n("Switch off")?></button>
                                                <?php endif; ?>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <!-- Third Row: Public ID and Private ID -->
                                            <form method="POST" action="index.php?controller=switchs&amp;action=delete"
                                                id="delete_switch_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>"
                                                class="d-flex align-items-center">
                                                <input type="hidden" name="public_id" value="<?= $switch->getPublicId() ?>">
                                                <input type="hidden" name="private_id" value="<?= $switch->getPrivateId() ?>">
                                                <a href="#"
                                                    onclick="
                                                    if (confirm('<?= i18n("are you sure?")?>')) {
                                                        document.getElementById('delete_switch_<?= $switch->getPublicId() ?>_<?=$switch->getPrivateId()?>').submit()
                                                    }"
                                                    class="btn btn-danger"><?= i18n("Delete") ?> </a>
                                                <span class="ml-2 text-dark"><?=i18n("Public ID: ")?><a href="http://localhost/index.php?controller=switchs&action=view&public_id=<?=$switch->getPublicId()?>"><?= $switch->getPublicId() ?></a></span>
                                                <span class="ml-2 text-dark"><?=i18n("Private ID: ")?><a href="http://localhost/index.php?controller=switchs&action=view&private_id=<?=$switch->getPrivateId()?>"><?= $switch->getPrivateId() ?></a></span>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="subscription-container rounded">
                    <h2 class="text-dark" style="text-shadow: 0px 2px 2px rgba(0, 0, 0, 0.5);">
                        <?=i18n("My Subscriptions")?></h2>
                    
                    <div class="switch-list-container">
                        <?php foreach ($subscriptions as $subscription): ?>
                            <?php if (isset($currentuser) && $currentuser == $subscription->getAlias()->getUsername()): ?>
                                <div class="switch-item-container border p-2 mb-3 bg-light shadow-2 rounded subscription-item-container" data-state="apagado">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4 class="text-dark"><?= $subscription->getSwitchs()->getNombre()?></h4>
                                            <?php if($subscription->getSwitchs()->encendido()==false): ?>
                                                <img class="small-image" src="images/circuloRojo.png">
                                            <?php else: ?>
                                                <img class="small-image" src="images/circuloVerde.png">
                                            <?php endif;?>
                                        </div>
                                        <div class="col-6">
                                            <span class="text-dark"><?= i18n("Author") ?>: <?= $subscription->getSwitchs()->getAlias()->getUsername()?></span>
                                            <?php if($subscription->getSwitchs()->encendido()==false): ?>
                                                <span class="text-dark"><?= i18n("Last modification") ?>: <?= $subscription->getSwitchs()->getEncendidoHasta()?></span>
                                            <?php else: ?>
                                                <span class="text-dark"><?= i18n("Time on") ?>: <?= $subscription->getSwitchs()->tiempoEncendido()?></span>
                                            <?php endif;?>
                                            <form
                                                method="POST"
                                                action="index.php?controller=subscription&amp;action=delete"
                                                id="delete_subscription_<?= $subscription->getSwitchs()->getPublicId() ?>"
                                                style="display: inline">
                                                <input type="hidden" name="public_id" value="<?= $subscription->getSwitchs()->getPublicId() ?>">
                                                <a href="#"
                                                onclick="
                                                if (confirm('<?= i18n("are you sure?")?>')) {
                                                    document.getElementById('delete_subscription_<?= $subscription->getSwitchs()->getPublicId() ?>').submit()
                                                }"
                                                class="btn btn-danger mt-2"><?= i18n("Delete") ?></a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
