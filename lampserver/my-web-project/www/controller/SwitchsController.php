<?php
//file: controller/PostController.php

require_once(__DIR__."/../model/Comment.php");
require_once(__DIR__."/../model/Switchs.php");
require_once(__DIR__."/../model/SwitchsMapper.php");
require_once(__DIR__."/../model/User.php");


require_once(__DIR__."/../model/Subscription.php");
require_once(__DIR__."/../model/SubscriptionMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");
include('Mail.php');

/**
* Class PostsController
*
* Controller to make a CRUDL of Posts entities
*
* @author lipido <lipido@gmail.com>
*/
class SwitchsController extends BaseController {

	/**
	* Reference to the PostMapper to interact
	* with the database
	*
	* @var PostMapper
	*/
	
	private $subscriptionMapper;
	private $switchsMapper;

	public function __construct() {
		parent::__construct();

		$this->subscriptionMapper = new SubscriptionMapper();

		$this->switchsMapper = new SwitchsMapper();
	}

	/**
	* Action to list posts
	*
	* Loads all the posts from the database.
	* No HTTP parameters are needed.
	*
	* The views are:
	* <ul>
	* <li>posts/index (via include)</li>
	* </ul>
	*/
	public function index() {

		// obtain the data from the database
		$switchs = $this->switchsMapper->findAll();
		$subscriptions = $this->subscriptionMapper->findAll();
		// put the array containing Post object to the view
		$this->view->setVariable("switchs", $switchs);
		
		$this->view->setVariable("subscriptions", $subscriptions);

		// render the view (/view/posts/index.php)
		$this->view->render("switchs", "index");
	}

	/**
	* Action to view a given post
	*
	* This action should only be called via GET
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the post (via HTTP GET)</li>
	* </ul>
	*
	* The views are:
	* <ul>
	* <li>posts/view: If post is successfully loaded (via include).	Includes these view variables:</li>
	* <ul>
	*	<li>post: The current Post retrieved</li>
	*	<li>comment: The current Comment instance, empty or
	*	being added (but not validated)</li>
	* </ul>
	* </ul>
	*
	* @throws Exception If no such post of the given id is found
	* @return void
	*
	*/
	public function view(){
		// Obtener los valores de public_id y private_id de la URL
		if (!isset($_GET["public_id"]) && !isset($_GET["private_id"])) {
			throw new Exception("public_id or private_id is mandatory");
		}

		$publicid = isset($_GET["public_id"]) ? $_GET["public_id"] : null;
		$privateid = isset($_GET["private_id"]) ? $_GET["private_id"] : null;

		if ($publicid === null && $privateid === null) {
			throw new Exception("public_id or private_id is mandatory");
		}
		$switch = $this->switchsMapper->findById($publicid,$privateid);

		if ($switch == NULL) {
			throw new Exception("no such post with id: ".$publicid.$privateid);
		}

		// put the Post object to the view
		$this->view->setVariable("switch", $switch);

		// check if comment is already on the view (for example as flash variable)
		// if not, put an empty Comment for the view
		//$descripcion = $this->view->getVariable("descripcion");
		//$this->view->setVariable("descripcion", ($descripcion==NULL)?new Comment():$descripcion);

		// render the view (/view/posts/view.php)
		$this->view->render("switchs", "view");

	}

	/**
	* Action to add a new post
	*
	* When called via GET, it shows the add form
	* When called via POST, it adds the post to the
	* database
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>title: Title of the post (via HTTP POST)</li>
	* <li>content: Content of the post (via HTTP POST)</li>
	* </ul>
	*
	* The views are:
	* <ul>
	* <li>posts/add: If this action is reached via HTTP GET (via include)</li>
	* <li>posts/index: If post was successfully added (via redirect)</li>
	* <li>posts/add: If validation fails (via include). Includes these view variables:</li>
	* <ul>
	*	<li>post: The current Post instance, empty or
	*	being added (but not validated)</li>
	*	<li>errors: Array including per-field validation errors</li>
	* </ul>
	* </ul>
	* @throws Exception if no user is in session
	* @return void
	*/
	public function add() {
		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Adding switches requires login");
		}

		$switch = new Switchs();

		if (isset($_POST["submit"])) { // reaching via HTTP Post...

			// populate the Post object with data form the form
			$switch->setNombre($_POST["nombre"]);

			// The user of the Post is the currentUser (user in session)
			$switch->setAlias($this->currentUser);
			
			$switch->setDescripcion($_POST["descripcion"]);

			try {
				// validate Post object
				$switch->checkIsValidForCreate(); // if it fails, ValidationException

				// save the Post object into the database
				$this->switchsMapper->save($switch);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Switch \"%s\" successfully added."),$switch ->getNombre()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=posts&action=index")
				// die();
				$this->view->redirect("switchs", "index");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		// Put the Post object visible to the view
		$this->view->setVariable("switch", $switch);

		// render the view (/view/posts/add.php)
		$this->view->render("switchs", "add");

	}

	/**
	* Action to edit a post
	*
	* When called via GET, it shows an edit form
	* including the current data of the Post.
	* When called via POST, it modifies the post in the
	* database.
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the post (via HTTP POST and GET)</li>
	* <li>title: Title of the post (via HTTP POST)</li>
	* <li>content: Content of the post (via HTTP POST)</li>
	* </ul>
	*
	* The views are:
	* <ul>
	* <li>posts/edit: If this action is reached via HTTP GET (via include)</li>
	* <li>posts/index: If post was successfully edited (via redirect)</li>
	* <li>posts/edit: If validation fails (via include). Includes these view variables:</li>
	* <ul>
	*	<li>post: The current Post instance, empty or being added (but not validated)</li>
	*	<li>errors: Array including per-field validation errors</li>
	* </ul>
	* </ul>
	* @throws Exception if no id was provided
	* @throws Exception if no user is in session
	* @throws Exception if there is not any post with the provided id
	* @throws Exception if the current logged user is not the author of the post
	* @return void
	*/
	public function edit() {
		if (!isset($_POST["public_id"])) {
			throw new Exception("id is mandatory");
		}
		if (!isset($_POST["private_id"])) {
			throw new Exception("id is mandatory");
		}
		/*if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Editing posts requires login");
		}*/


		// Get the Post object from the database
		$publicid = $_REQUEST["public_id"];
		$privateid = $_REQUEST["private_id"];
		$switch = $this->switchsMapper->findById($publicid,$privateid);

		// Does the post exist?
		if ($switch == NULL) {
			throw new Exception("no such switch with id: ".$publicid.$privateid);
		}

		// Check if the Post author is the currentUser (in Session)
		if (isset($this->currentUser)) {
			if ($switch->getAlias() != $this->currentUser) {
				throw new Exception("logged user is not the author of the switch id ".$publicid.$privateid);
			}
		}

		//172.29.64.1
		// reaching via HTTP Post...

			// populate the Post object with data form the form
			$switch->setEncendidoHasta($_POST["encendido_hasta"]);
			
			$switch->setEstado($_POST["estado"]);
			try {
                // validate Post object
                $switch->checkIsValidForUpdate(); // if it fails, ValidationException

                // update the Post object in the database
                $this->switchsMapper->update($switch);

                if ($switch->getEstado() == 1) {
                    $subscriptions = $this->subscriptionMapper->findAllSubscriptions($publicid,$privateid);

                    foreach ($subscriptions as $sub) {

						
                        $recipients = $sub->getAlias()->getEmail();
                        $headers['From'] = 'notifications@iamon.com';
                        $headers['To'] = $recipients;
                        $headers['Subject'] = 'Switch has been switched on!';
                        $body = 'The Switch ' . $sub->getSwitchs()->getNombre() . ' you are subscribed to has been powered on!!';

                        $params['host'] = '172.24.160.1'; // IP de la máquina host cuando se usa Docker (FakeSMTP)
                        $params['port'] = '2525'; // Puerto del FakeSMTP

                        // Crea el objeto de correo utilizando el método Mail::factory
                        $mail_object = Mail::factory('smtp', $params);
                        $mail_object->send($recipients, $headers, $body);
                    }
                }
				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Switch \"%s\" successfully updated."),$switch ->getNombre()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=posts&action=index")
				// die();
				
					//$this->view->redirect("switchs", "view");
				$this->view->redirectToReferer();
				

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
	}

	/**
	* Action to delete a post
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the post (via HTTP POST)</li>
	* </ul>
	*
	* The views are:
	* <ul>
	* <li>posts/index: If post was successfully deleted (via redirect)</li>
	* </ul>
	* @throws Exception if no id was provided
	* @throws Exception if no user is in session
	* @throws Exception if there is not any post with the provided id
	* @throws Exception if the author of the post to be deleted is not the current user
	* @return void
	*/
	public function delete() {
		if (!isset($_POST["public_id"])) {
			throw new Exception("id is mandatory");
		}
		if (!isset($_POST["private_id"])) {
			throw new Exception("id is mandatory");
		}
		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Editing posts requires login");
		}
		
		// Get the Post object from the database
		$publicid = $_REQUEST["public_id"];
		$privateid = $_REQUEST["private_id"];
		$switch = $this->switchsMapper->findById($publicid,$privateid);

		// Does the post exist?
		if ($switch == NULL) {
			throw new Exception("no such post with id: ".$publicid.$privateid);
		}

		// Check if the Post author is the currentUser (in Session)
		if ($switch->getAlias() != $this->currentUser) {
			throw new Exception("Switch author is not the logged user");
		}

		// Delete the Post object from the database
		$this->switchsMapper->delete($switch);

		// POST-CT-GET
		// Everything OK, we will redirect the user to the list of posts
		// We want to see a message after redirection, so we establish
		// a "flash" message (which is simply a Session variable) to be
		// get in the view after redirection.
		$this->view->setFlash(sprintf(i18n("Switch \"%s\" successfully deleted."),$switch ->getNombre()));

		// perform the redirection. More or less:
		// header("Location: index.php?controller=posts&action=index")
		// die();
		$this->view->redirect("switchs", "index");

	}
}