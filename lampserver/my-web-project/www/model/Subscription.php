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
class Subscription {

	/**
	* The public id of this switch
	* @var string
	*/
	private $switchs;

	/**
	* The author of this switch
	* @var string
	*/
	private $alias;


	/**
	* The constructor
	*
	* @param string $id The id of the post
	* @param string $title The id of the post
	* @param string $content The content of the post
	* @param User $author The author of the post
	* @param mixed $comments The list of comments
	*/
	public function __construct(Switchs $switch, User $alias=NULL) {
		$this->switchs = $switch;
		$this->alias = $alias;
	}

	/**
	* Gets the id of this post
	*
	* @return string The id of this post
	*/
	public function getSwitchs() {
		return $this->switchs;
	}
	public function setSwitchs(Switchs $switch) {
		$this->switchs=$switch;
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
		
		if (($this->switchs) == NULL ) {
			$errors["switch"] = "switch is mandatory";
		}

		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "subscription is not valid");
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
	/*
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
	}*/
}
