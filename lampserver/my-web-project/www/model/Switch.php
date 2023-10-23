<?php
// file: model/Switch.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Post
*
* Represents a Post in the blog. A Post was written by an
* specific User (author) and contains a list of Comments
*
* @author lipido <lipido@gmail.com>
*/
class Post {

	/**
	* The public id of this switch
	* @var string
	*/
	private $publicid;

	/**
	* The private id of this switch
	* @var string
	*/
	private $privateid;

	/**
	* The author of this switch
	* @var string
	*/
	private $alias;

	/**
	* The name of this switch
	* @var User
	*/
	private $nombre;
	
	private $estado;
	
	private $ultima_modificacion;


	/**
	* The constructor
	*
	* @param string $id The id of the post
	* @param string $title The id of the post
	* @param string $content The content of the post
	* @param User $author The author of the post
	* @param mixed $comments The list of comments
	*/
	public function __construct($publicid=NULL, $privateid=NULL, $nombre=NULL, $estado=NULL, $ultima_modificacion=NULL, User $alias=NULL) {
		$this->publicid = $publicid;
		$this->privateid = $privateid;
		$this->nombre = $nombre;
		$this->alias = $alias;
		$this->estado = $estado;
		$this->ultima_modificacion=$ultima_modificacion;
	}

	/**
	* Gets the id of this post
	*
	* @return string The id of this post
	*/
	public function getPublicId() {
		return $this->publicid;
	}
	
	public function getPrivateId() {
		return $this->publicid;
	}
	/**
	* Gets the title of this post
	*
	* @return string The title of this post
	*/
	public function getNombre() {
		return $this->nombre;
	}

	/**
	* Sets the title of this post
	*
	* @param string $title the title of this post
	* @return void
	*/
	public function setNombre($name) {
		$this->nombre = $name;
	}


	/**
	* Gets the author of this post
	*
	* @return User The author of this post
	*/
	public function getAlias() {
		return $this->alias;
	}

	/**
	* Sets the author of this post
	*
	* @param User $author the author of this post
	* @return void
	*/
	public function setAlias(User $alias) {
		$this->alias = $alias;
	}
	
	public function getEstado() {
		return $this->estado;
	}
	public function setEstado(int $estado) {
		$this->estado = $estado;
	}
	public function getUltimaModificacion(){
		return $this->ultima_modificacion;
	}
	public function setUltimaModificacion(Timestamp $ultima_modificacion) {
		$this->ultima_modificacion = $ultima_modificacion;
	}

	/**
	* Checks if the current instance is valid
	* for being updated in the database.
	*
	* @throws ValidationException if the instance is
	* not valid
	*
	* @return void
	*/
	public function checkIsValidForCreate() {
		$errors = array();
		/*if (strlen(trim($this->title)) == 0 ) {
			$errors["title"] = "title is mandatory";
		}
		if (strlen(trim($this->content)) == 0 ) {
			$errors["content"] = "content is mandatory";
		}*/
		if ($this->alias == NULL ) {
			$errors["alias"] = "alias is mandatory";
		}

		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "switch is not valid");
		}
	}

	/**
	* Checks if the current instance is valid
	* for being updated in the database.
	*
	* @throws ValidationException if the instance is
	* not valid
	*
	* @return void
	*/
	public function checkIsValidForUpdate() {
		$errors = array();

		if (!isset($this->publicid)) {
			$errors["publicid"] = "publicid is mandatory";
		}
		if (!isset($this->privateid)) {
			$errors["privateid"] = "privateid is mandatory";
		}


		try{
			$this->checkIsValidForCreate();
		}catch(ValidationException $ex) {
			foreach ($ex->getErrors() as $key=>$error) {
				$errors[$key] = $error;
			}
		}
		if (sizeof($errors) > 0) {
			throw new ValidationException($errors, "switch is not valid");
		}
	}
}
