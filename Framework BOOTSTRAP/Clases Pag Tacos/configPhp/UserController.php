<?php 
	include_once "config.php";
	include_once "ConectionController.php";

	if ( isset($_POST) && isset($_POST['action']) ) {

		$userController = new UserController();

		switch ( $_POST['action'] ) {
			case 'store':

				$name = strip_tags($_POST['name']);
				$email = strip_tags($_POST['email']);
				$password = strip_tags($_POST['password']);

				$userController->update($name,$email,$password);

				break;

			case 'update':

				$name = strip_tags($_POST['name']);
				$email = strip_tags($_POST['email']);
				$password = strip_tags($_POST['password']);
				$id = strip_tags($_POST['id']);

				$userController->update($name,$email,$password,$id);

				break;
		}
	}

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

		function store($name, $email, $password) {
			$conn = connect();
			if ( !$conn->connect_error ) {

				if ( $name!="" && $email!="" && $password!="" ) {

					$query = "insert into user (name,email,password) values (?,?,?)";
					$prepared_query = $conn->prepare($query);
					$prepared_query->bind_param('sss',$name,$email,$password);
					if ( $prepared_query->execute() ) { 
						$_SESSION['status'] = "success";
						$_SESSION['message'] = "El registro se ha guardado";

						header("Location:" . $_SERVER['HTTP_REFERER']); 
					} else {
						$_SESSION['status'] = "error";
						$_SESSION['message'] = "El registro no se ha guardado";

						header("Location:" . $_SERVER['HTTP_REFERER']);
					}
				} else { 
					$_SESSION['status'] = "error";
					$_SESSION['message'] = "Revise la informacion enviada";

					header("Location:" . $_SERVER['HTTP_REFERER']); 
				}
			} else { 
				$_SESSION['status'] = "error";
				$_SESSION['message'] = "Error durante la conexion";

				header("Location:" . $_SERVER['HTTP_REFERER']); 
			}
		}

		function update($name, $email, $password, $id) {
			$conn = connect();
			if ( !$conn->connect_error ) {

				if ( $name!="" && $email!="" && $password!="" && $id!="" ) {

					$query = "update user set name = ?, email = ?, password = ? where id = ?";

					$prepared_query = $conn->prepare($query);
					$prepared_query->bind_param('sssi',$name, $email, $password, $id);

					if ( $prepared_query->execute() ) { 
						$_SESSION['status'] = "success";
						$_SESSION['message'] = "El registro se ha actualizado";

						header("Location:" . $_SERVER['HTTP_REFERER']); 
					} else {
						$_SESSION['status'] = "error";
						$_SESSION['message'] = "El registro no se ha actualizado";

						header("Location:" . $_SERVER['HTTP_REFERER']);
					}
				} else { 
					$_SESSION['status'] = "error";
					$_SESSION['message'] = "Revise la informacion enviada";

					header("Location:" . $_SERVER['HTTP_REFERER']); 
				}
			} else { 
				$_SESSION['status'] = "error";
				$_SESSION['message'] = "Error durante la conexion";

				header("Location:" . $_SERVER['HTTP_REFERER']); 
			}
		}
	}
?>