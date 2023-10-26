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
		$stmt = $this->db->query("SELECT * FROM switch, users WHERE users.username = switch.alias");
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
		$stmt = $this->db->prepare("SELECT * FROM switch WHERE public_id=? AND private_id=?");
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
	* Loads a Post from the database given its id
	*
	* It includes all the comments
	*
	* @throws PDOException if a database error occurs
	* @return Post The Post instances (without comments). NULL
	* if the Post is not found
	*/
	public function findByIdWithComments($publicid, $privateid){
		$stmt = $this->db->prepare("SELECT
			P.public_id as 'switch.publicid',
			P.private_id as 'switch.privateid',
			P.alias as 'switch.alias',
			P.tiempo_modificacion as 'switch.ultima_modificacion',

			FROM switch P LEFT OUTER JOIN users U
			ON P.alias = U.username
			WHERE
			P.publicid=? AND P.privateid=?");

			$stmt->execute(array($publicid, $privateid));
			$post_wt_comments= $stmt->fetchAll(PDO::FETCH_ASSOC);

			/*if (sizeof($post_wt_comments) > 0) {
				$post = new Post($post_wt_comments[0]["post.id"],
				$post_wt_comments[0]["post.title"],
				$post_wt_comments[0]["post.content"],
				new User($post_wt_comments[0]["post.author"]));
				$comments_array = array();
				if ($post_wt_comments[0]["comment.id"]!=null) {
					foreach ($post_wt_comments as $comment){
						$comment = new Comment( $comment["comment.id"],
						$comment["comment.content"],
						new User($comment["comment.author"]),
						$post);
						array_push($comments_array, $comment);
					}
				}
				$post->setComments($comments_array);

				return $post;
			}else {
				return NULL;
			}*/
		}

		/**
		* Saves a Post into the database
		*
		* @param Post $post The post to be saved
		* @throws PDOException if a database error occurs
		* @return int The mew post id
		*/
		public function save(Post $switch) {
			$stmt = $this->db->prepare("INSERT INTO switch(alias, nombre) values (?,?,?)");
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
			$stmt = $this->db->prepare("UPDATE posts set nombre=?, estado=? where publicid=? and privateid=?");
			$stmt->execute(array($switch->getNombre(), $switch->getEstado(), $switch->getPublicId(),$switch->getPrivateId()));
		}

		/**
		* Deletes a Post into the database
		*
		* @param Post $post The post to be deleted
		* @throws PDOException if a database error occurs
		* @return void
		*/
		public function delete(Switchs $switch) {
			$stmt = $this->db->prepare("DELETE from switch WHERE publicid=? and privateid=?");
			$stmt->execute(array($switch->getPublicId(),$switch->getPrivateId()));
		}

	}
