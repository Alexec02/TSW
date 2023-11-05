<?php
// file: model/PostMapper.php
require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Subscription.php");
require_once(__DIR__."/../model/Switchs.php");
/**
* Class PostMapper
*
* Database interface for Post entities
*
* @author lipido <lipido@gmail.com>
*/
class SubscriptionMapper {

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
		$stmt = $this->db->query("SELECT s.public_id, s.private_id, s.nombre, s.estado, tiempo_modificacion, encendido_hasta, descripcion, s.alias, sp.alias as subscriptor FROM switch s, subscription sp WHERE s.public_id=sp.public_id AND s.private_id=sp.private_id");
		$subscription_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$subscriptions = array();

		foreach ($subscription_db as $subscription) {
			$switchs = new Switchs($subscription["public_id"], $subscription["private_id"], $subscription["nombre"], $subscription["descripcion"], $subscription["estado"], $subscription["tiempo_modificacion"], $subscription["encendido_hasta"], new User($subscription["alias"]));
			array_push($subscriptions, new Subscription($switchs, new User($subscription["subscriptor"])));
		}

		return $subscriptions;
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
		$stmt = $this->db->prepare("SELECT s.public_id, s.private_id, s.nombre, s.estado, tiempo_modificacion, encendido_hasta, descripcion, s.alias, sp.alias as subscriptor, u.email FROM switch s, subscription sp, users u WHERE s.public_id=sp.public_id AND s.private_id=sp.private_id AND s.public_id=? AND s.private_id=? and u.username=sp.alias");
		$stmt->execute(array($publicid,$privateid));
		$switch = $stmt->fetch(PDO::FETCH_ASSOC);

		if($switch != null) {
			return new Subscription(new Switchs(
			$switch["public_id"],
			$switch["private_id"],
			$switch["nombre"],
			$switch["descripcion"],
			$switch["estado"],
			$switch["tiempo_modificacion"],
			$switch["encendido_hasta"],
			new User($switch["alias"])), new User($switch["subscriptor"],"",$switch["email"]));
		} else {
			return NULL;
		}
	}

	public function findByIdUser($publicid,$username){
		$stmt = $this->db->prepare("SELECT s.public_id, s.private_id, s.nombre, s.estado, tiempo_modificacion, encendido_hasta, descripcion, s.alias, sp.alias as subscriptor, u.email FROM switch s, subscription sp, users u WHERE s.public_id=sp.public_id AND s.private_id=sp.private_id AND s.public_id=? AND u.username=? and s.alias = u.username and u.username=sp.alias");
		$stmt->execute(array($publicid,$username));
		$switch = $stmt->fetch(PDO::FETCH_ASSOC);

		if($switch != null) {
			return new Subscription(new Switchs(
			$switch["public_id"],
			$switch["private_id"],
			$switch["nombre"],
			$switch["descripcion"],
			$switch["estado"],
			$switch["tiempo_modificacion"],
			$switch["encendido_hasta"],
			new User($switch["alias"])), new User($switch["subscriptor"],"",$switch["email"]));
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
		public function save(Subscription $subscription) {
			$stmt = $this->db->prepare("INSERT INTO subscription(public_id,private_id,alias) values (?,?,?)");
			$stmt->execute(array($subscription->getSwitchs()->getPublicID(),$subscription->getSwitchs()->getPrivateID(),$subscription->getAlias()->getUsername()));
			return $this->db->lastInsertId();
		}

		/**
		* Deletes a Post into the database
		*
		* @param Post $post The post to be deleted
		* @throws PDOException if a database error occurs
		* @return void
		*/
		public function delete(Subscription $subscription) {
			$stmt = $this->db->prepare("DELETE from subscription WHERE public_id=? and private_id=? and alias=?");
			$stmt->execute(array($subscription->getSwitchs()->getPublicID(),$subscription->getSwitchs()->getPrivateID(),$subscription->getAlias()->getUsername()));
		}

	}
