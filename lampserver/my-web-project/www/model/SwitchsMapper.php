<?php
// file: model/PostMapper.php
require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Switchs.php");

/**
* Class PostMapper
*
* Database interface for Post entities
*
* @author lipido <lipido@gmail.com>
*/
class SwitchsMapper {

	/**
	* Reference to the PDO connection
	* @var PDO
	*/
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	/**
	* Retrieves all posts
	*
	* Note: Comments are not added to the Post instances
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of Post instances (without comments)
	*/
	public function findAll() {
		$stmt = $this->db->query("SELECT public_id, private_id, nombre, estado, (extract(hour_minute from CURRENT_TIMESTAMP())- extract(hour_minute from tiempo_modificacion)) as tiempo_modificacion, alias FROM switch, users WHERE users.username = switch.alias");
		$switch_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$switchs = array();

		foreach ($switch_db as $switch) {
			$alias = new User($switch["alias"]);
			array_push($switchs, new Switchs($switch["public_id"], $switch["private_id"], $switch["nombre"], $switch["estado"], $switch["tiempo_modificacion"], $alias));
		}

		return $switchs;
	}

	/**
	* Loads a Post from the database given its id
	*
	* Note: Comments are not added to the Post
	*
	* @throws PDOException if a database error occurs
	* @return Post The Post instances (without comments). NULL
	* if the Post is not found
	*/
	public function findById($publicid,$privateid){
		$stmt = $this->db->prepare("SELECT public_id, private_id, nombre, estado, (extract(hour_minute from CURRENT_TIMESTAMP())- extract(hour_minute from tiempo_modificacion)) as tiempo_modificacion, alias FROM switch WHERE public_id=? AND private_id=?");
		$stmt->execute(array($publicid,$privateid));
		$switch = $stmt->fetch(PDO::FETCH_ASSOC);

		if($switch != null) {
			return new Switchs(
			$switch["public_id"],
			$switch["private_id"],
			$switch["nombre"],
			$switch["estado"],
			$switch["tiempo_modificacion"],
			new User($switch["alias"]));
		} else {
			return NULL;
		}
	}

	

		/**
		* Saves a Post into the database
		*
		* @param Post $post The post to be saved
		* @throws PDOException if a database error occurs
		* @return int The mew post id
		*/
		public function save(Switchs $switch) {
			$stmt = $this->db->prepare("INSERT INTO switch(alias, nombre) values (?,?)");
			$stmt->execute(array($switch->getAlias()->getUsername(), $switch->getNombre()));
			return $this->db->lastInsertId();
		}

		/**
		* Updates a Post in the database
		*
		* @param Post $post The post to be updated
		* @throws PDOException if a database error occurs
		* @return void
		*/
		public function update(Switchs $switch) {
			$stmt = $this->db->prepare("UPDATE switch set estado=? where public_id=? and private_id=?");
			$stmt->execute(array($switch->getEstado(), $switch->getPublicId(),$switch->getPrivateId()));
		}

		/**
		* Deletes a Post into the database
		*
		* @param Post $post The post to be deleted
		* @throws PDOException if a database error occurs
		* @return void
		*/
		public function delete(Switchs $switch) {
			$stmt = $this->db->prepare("DELETE from switch WHERE public_id=? and private_id=?");
			$stmt->execute(array($switch->getPublicId(),$switch->getPrivateId()));
		}

	}
