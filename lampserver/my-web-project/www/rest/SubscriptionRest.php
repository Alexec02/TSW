<?php

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Switchs.php");
require_once(__DIR__."/../model/Subscription.php");
require_once(__DIR__."/../model/SubscriptionMapper.php");
require_once(__DIR__."/BaseRest.php");

/**
 * Class SwitchsRest
 *
 * It contains operations for creating, retrieving, updating, and deleting switches.
 *
 * Methods give responses following RESTful standards. Methods of this class
 * are intended to be mapped as callbacks using the URIDispatcher class.
 */
class SubscriptionRest extends BaseRest {
		private $subscriptionMapper;

    public function __construct() {
        parent::__construct();
        $this->subscriptionMapper = new SubscriptionMapper();
    }

    public function getSubscriptions() {
        $currentUser = parent::authenticateUser();
        $subscriptions = $this->subscriptionMapper->findAll();

        $subscriptions_array = array();
        foreach($subscriptions as $subscription) {
					if ($subscription->getAlias() == $currentUser){
            array_push($subscriptions_array, array(
                "public_id" => $subscription->getSwitchs()->getPublicId(),
                //"private_id" => $subscription->getSwitchs()->getPrivateId(),
                "nombre" => $subscription->getSwitchs()->getNombre(),
                "descripcion" => $subscription->getSwitchs()->getDescripcion(),
                "estado" => $subscription->getSwitchs()->getEstado(),
                "tiempo_modificacion" => $subscription->getSwitchs()->getUltimaModificacion(),
                "encendido_hasta" => $subscription->getSwitchs()->getEncendidoHasta(),
                "alias" => $subscription->getSwitchs()->getAlias()->getUsername(),
            ));
					}
        }

        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($subscriptions_array));
    }

    public function createSubscription($data) {
        $currentUser = parent::authenticateUser();
        $subscription = new Subscription();

        /*if (isset($data->nombre) && isset($data->descripcion)) {
            $switch->setNombre($data->nombre);
            $switch->setDescripcion($data->descripcion);
            $switch->setAlias($currentUser);
        }*/
				$subscription->setSwitchs($data->switchs);
				$subscription->setAlias($data->$currentUser);
        try {
            $subscription->checkIsValidForCreate();
            $switchId = $this->subscriptionMapper->save($subscription);//no se yo si el return que hacemos es correcto

            header($_SERVER['SERVER_PROTOCOL'].' 201 Created');
            header('Location: '.$_SERVER['REQUEST_URI']."/".$switchId);//xd
            header('Content-Type: application/json');
            echo(json_encode(array(
							//switchid
                "nombre" => $subscription->getSwitchs()->getNombre(),
                "descripcion" => $subscription->getSwitchs()->getDescripcion(),
                "estado" => $subscription->getSwitchs()->getEstado(),
                "tiempo_modificacion" => $subscription->getSwitchs()->getUltimaModificacion(),
                "encendido_hasta" => $subscription->getSwitchs()->getEncendidoHasta(),
								"switch_alias" => $subscription->getSwitchs()->getAlias()->getUsername(),
                "alias" => $subscription->getAlias()->getUsername(),
            )));
        } catch (ValidationException $e) {
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
            header('Content-Type: application/json');
            echo(json_encode($e->getErrors()));
        }
    }

    public function readSubscription($publicId=NULL, $privateId=NULL) {
        $currentUser = parent::authenticateUser();
        $subscription = $this->subscriptionMapper-> findByIdUser($publicId,$currentUser);
        
        if ($subscription == NULL) {
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
            echo("Switch with public_id ".$publicId." and private_id ".$privateId." not found");
            return;
        }

        $subscription_array = array(
						"public_id" => $subscription->getSwitchs()->getPublicId(),
            "private_id" => $privateId,
            "nombre" => $subscription->getSwitchs()->getNombre(),
            "descripcion" => $subscription->getSwitchs()->getDescripcion(),
            "estado" => $subscription->getSwitchs()->getEstado(),
            "tiempo_modificacion" => $subscription->getSwitchs()->getUltimaModificacion(),
            "encendido_hasta" => $subscription->getSwitchs()->getEncendidoHasta(),
						"switch_alias" => $subscription->getSwitchs()->getAlias()->getUsername(),
            "alias" => $subscription->getAlias()->getUsername(),
        );

        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($subscription_array));
    }

    public function deleteSubscription($publicId) {
        $currentUser = parent::authenticateUser();
        $subscription = $this->subscriptionMapper->findByIdUser($publicId, $currentUser);

        if ($subscription == NULL) {
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
            echo("Switch with public_id ".$publicId." not found");
            return;
        }

        if ($subscription->getAlias() != $currentUser) {
            header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
            echo("You are not the owner of this switch");
            return;
        }

        $this->subscriptionMapper->delete($subscription);

        header($_SERVER['SERVER_PROTOCOL'].' 204 No Content');
    }
}

// URI-MAPPING for this Rest endpoint
$subscriptionRest = new SubscriptionRest();
URIDispatcher::getInstance()
    ->map("GET",    "/subscription", array($subscriptionRest,"getSubscriptions"))
    ->map("GET",    "/subscription/$1", array($subscriptionRest,"readSubscription"))
    ->map("POST",   "/subscription", array($subscriptionRest,"createSubscription"))
    ->map("DELETE", "/subscription/$1", array($subscriptionRest,"deleteSubscription"));
