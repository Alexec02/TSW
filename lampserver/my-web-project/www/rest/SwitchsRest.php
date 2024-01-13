<?php

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Switchs.php");
require_once(__DIR__."/../model/SwitchsMapper.php");
require_once(__DIR__."/BaseRest.php");

/**
 * Class SwitchsRest
 *
 * It contains operations for creating, retrieving, updating, and deleting switches.
 *
 * Methods give responses following RESTful standards. Methods of this class
 * are intended to be mapped as callbacks using the URIDispatcher class.
 */
class SwitchsRest extends BaseRest {
    private $switchsMapper;

    public function __construct() {
        parent::__construct();
        $this->switchsMapper = new SwitchsMapper();
    }

    public function getSwitchs() {
        $currentUser = parent::authenticateUser();
        $switchs = $this->switchsMapper->findAll();

        $switchs_array = array();
        foreach($switchs as $switch) {
					if ($switch->getAlias() == $currentUser){
            array_push($switchs_array, array(
                "public_id" => $switch->getPublicId(),
                "private_id" => $switch->getPrivateId(),
                "nombre" => $switch->getNombre(),
                "descripcion" => $switch->getDescripcion(),
                "estado" => $switch->getEstado(),
                "tiempo_modificacion" => $switch->getUltimaModificacion(),
                "encendido_hasta" => $switch->getEncendidoHasta(),
                "alias" => $switch->getAlias()->getUsername(),
            ));
					}
        }

        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($switchs_array));
    }

    public function createSwitch($data) {
        $currentUser = parent::authenticateUser();
        $switch = new Switchs();

        if (isset($data->nombre) && isset($data->descripcion)) {
            $switch->setNombre($data->nombre);
            $switch->setDescripcion($data->descripcion);
            $switch->setAlias($currentUser);
        }

        try {
            $switch->checkIsValidForCreate();
            $switchId = $this->switchsMapper->save($switch);//no se yo si el return que hacemos es correcto

            header($_SERVER['SERVER_PROTOCOL'].' 201 Created');
            header('Location: '.$_SERVER['REQUEST_URI']."/".$switchId);//xd
            header('Content-Type: application/json');
            echo(json_encode(array(
							//switchid
                "nombre" => $switch->getNombre(),
                "descripcion" => $switch->getDescripcion(),
                "estado" => $switch->getEstado(),
                "tiempo_modificacion" => $switch->getUltimaModificacion(),
                "encendido_hasta" => $switch->getEncendidoHasta(),
                "alias" => $switch->getAlias()->getUsername(),
            )));
        } catch (ValidationException $e) {
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
            header('Content-Type: application/json');
            echo(json_encode($e->getErrors()));
        }
    }

    public function readSwitch($publicid=NULL,$privateid=NULL) {
        $switch = $this->switchsMapper->findById($publicid, $privateid);

        if ($switch == NULL) {
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
            echo("Switch with public_id ".$publicid." and private_id ".$privateid." not found");
            return;
        }

        $switch_array = array(
            "public_id" => $switch->getPublicId(),
            "private_id" => ($privateid!=NULL)?$switch->getPrivateId():NULL,//No se si esto funciona, si no funciona, crear dos opciones de array
            "nombre" => $switch->getNombre(),
            "descripcion" => $switch->getDescripcion(),
            "estado" => $switch->getEstado(),
            "tiempo_modificacion" => $switch->getUltimaModificacion(),
            "encendido_hasta" => $switch->getEncendidoHasta(),
            "alias" => $switch->getAlias()->getUsername(),
        );

        header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        header('Content-Type: application/json');
        echo(json_encode($switch_array));
    }

    public function updateSwitch($private_id, $data) {
        $currentUser = parent::authenticateUser();
        
        $switch = $this->switchsMapper->findById(null, $private_id);

        if ($switch == NULL) {
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
            echo("Switch with private_id ".$private_id." not found");
            return;
        }

        if ($switch->getAlias() != $currentUser) {
            header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
            echo("You are not the owner of this switch");
            return;
        }

        $switch->setNombre($data->nombre);
        $switch->setDescripcion($data->descripcion);

        try {
            $switch->checkIsValidForUpdate();
            $this->switchsMapper->update($switch);

            header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
        } catch (ValidationException $e) {
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
            header('Content-Type: application/json');
            echo(json_encode($e->getErrors()));
        }
    }

    public function deleteSwitch($privateId, $currentUser) {
        $switch = $this->switchsMapper->findById($privateId);

        if ($switch == NULL) {
            header($_SERVER['SERVER_PROTOCOL'].' 400 Bad request');
            echo("Switch with private_id ".$privateId." not found");
            return;
        }

        if ($switch->getAlias() != $currentUser) {
            header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
            echo("You are not the owner of this switch");
            return;
        }

        $this->switchsMapper->delete($switch);

        header($_SERVER['SERVER_PROTOCOL'].' 204 No Content');
    }
}

// URI-MAPPING for this Rest endpoint
$switchsRest = new SwitchsRest();
URIDispatcher::getInstance()
    ->map("GET",    "/switchs", array($switchsRest,"getSwitchs"))
    ->map("GET",    "/switchs/$1/$2", array($switchsRest,"readSwitch"))
    ->map("POST",   "/switchs", array($switchsRest,"createSwitch"))
    ->map("PUT",    "/switchs/$1", array($switchsRest,"updateSwitch"))
    ->map("DELETE", "/switchs/$1", array($switchsRest,"deleteSwitch"));
