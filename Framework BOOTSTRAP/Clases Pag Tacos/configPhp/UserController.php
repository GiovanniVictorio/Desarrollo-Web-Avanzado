<?php 
	include_once "config.php";
	include_once "ConectionController.php";

	class UserController {
		function get(){
			$conn = connect();
			if ( !$conn->connect_error ) {
				$query = "SELECT * FROM user";
				$prepared_query = $conn->prepare($query);
				$prepared_query->execute();

				$result = $prepared_query->get_result();
				$users = $result->fetch_all(MYSQLI_ASSOC);

				if ( $users ){
					return $users;
				} else { return Array(); }
			} else { return Array(); }
		}
	}
?>