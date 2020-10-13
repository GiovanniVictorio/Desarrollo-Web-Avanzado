<?php
	include "configPhp/UserController.php";
	$userController = new UserController();

	$users = $userController->get();
	#echo json_encode($users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tacos Perrones</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
</head>

<body>
	<!-- Contenido -->
	<div id="wrapper">
		<div class="container">

			<!-- Barra navegacion -->
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
				<a class="navbar-brand" href="#">
					Tacos Prrones
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item active">
							<a class="nav-link" href="#">
								Inicio 
								<span class="sr-only">
									(current)
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Menu</a>
						</li>
					</ul>
					<form class="form-inline my-2 my-lg-0">
						<input class="form-control mr-sm-2" type="search" placeholder="Escriba aquí" aria-label="Search">
						<button class="btn btn-outline-success my-2 my-sm-0" type="submit">
							Buscar
						</button>
					</form>
				</div>
			</nav>

			<!-- Barra Home -->
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active" aria-current="page">Home</li>
				</ol>
			</nav>

			<!-- Notificaciones -->
			<?php if ( isset($_SESSION['status']) && $_SESSION['status']=='success' ): ?>
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong>Correcto!</strong> <?= $_SESSION['message'] ?>.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php unset($_SESSION['status']); ?>
			<?php endif ?>

			<?php if ( isset($_SESSION['status']) && $_SESSION['status']=='error' ): ?>
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong>Error garrafal!</strong> <?= $_SESSION['message'] ?>.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php unset($_SESSION['status']); ?>
			<?php endif ?>

			<!-- Tablas -->
			<div class="row">
				<div class="col-12">
					<div class="card mb-4">
						<!-- Tabla encabezado -->
						<div class="card-header">
							Lista de usuarios registrados

							<button type="button" onclick="add()" data-toggle="modal" data-target="#staticBackdrop" class="btn btn-primary float-right">
								Añadir usuario
							</button>
						</div>
						<!-- Tabla contenido -->
						<div class="card-body">
							<table class="table table-striped">
								<!-- Tabla encabezado del contenido -->
								<thead class="thead-dark">
									<tr>
										<th scope="col">#</th>
										<th scope="col">Nombre</th>
										<th scope="col">Correo electronico</th>
										<th scope="col">Estatus</th>
										<th scope="col"></th>
									</tr>
								</thead>
								<!-- Contenido de la tabla -->
								<tbody>
									<?php if ( isset($users) && count($users) > 0 ): ?>
									<?php foreach ($users as $user): ?>

									<tr>
										<th scope="row">
											<?= $user['id'] ?>
										</th>
										<td>
											<?= $user['name'] ?>
										</td>
										<td>
											<a href="mailto:<?php $user['email'] ?>">
												<?= $user['email'] ?>
											</a>
										</td>
										<td>
											<?php if ($user['status']): ?>
												<span class="badge badge-success">Activo</span>
											<?php else: ?>
												<span class="badge badge-warning">Inactivo</span>
											<?php endif ?>
										</td>
										<td style="float: right;">
											<button type="button" class="btn btn-warning" data-info='<?= json_encode($user) ?>' data-toggle="modal" data-target="#staticBackdrop" onclick="editar(this)" >
												<i class="fa fa-pencil"></i> Editar
											</button>
											<button type="button" onclick="remove(<?= $user['id'] ?>,this)" class="btn btn-warning">
												<i class="fa fa-trash"></i> Eliminar
											</button>
										</td>
									</tr>

								<?php endforeach ?>
								<?php endif ?>
								</tbody>	
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Agregar Usuario</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<form method="POST" id="myForm" action="configPhp/UserController.php" onsubmit="return validateRegister()">
					<div class="modal-body">
						<!-- Nombres -->
						<div class="form-group">
							<label for="exampleInputEmail1">Nombre's</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1">
										<i class="fa fa-user"></i>
									</span>
								</div>
								<input type="text" class="form-control" placeholder="Benito Camelo" aria-label="Username" aria-describedby="basic-addon1" required="" name="name" id="name">
							</div>
							<small id="emailHelp" class="form-text text-muted">No ingresar numeros o caracteres especiales.</small>
						</div>
						<!-- Correo -->
						<div class="form-group">
							<label for="exampleInputEmail1">Correo</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1">
										<i class="fa fa-envelope" aria-hidden="true"></i>
									</span>
								</div>
								<input type="email" class="form-control" placeholder="Benito@example.com" aria-label="Username" aria-describedby="basic-addon1" required="" name="email" id="email">
							</div>
						</div>
						<!-- Contraseña -->
						<div class="form-group">
							<label for="exampleInputEmail1">Contraseña</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1">
										<i class="fa fa-unlock-alt"></i>
									</span>
								</div>
								<input type="password" class="form-control" id="pass1" minlength="4" placeholder="* * * * * *" aria-label="Username" aria-describedby="basic-addon1" required="" name="password">
							</div>
						</div>
						<!-- Confirmar contraseña -->
						<div class="form-group">
							<label for="exampleInputEmail1">Confirmar Contraseña</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1">
										<i class="fa fa-unlock-alt"></i>
									</span>
								</div>
								<input type="password" class="form-control" id="pass2" minlength="4" placeholder="* * * * * *" aria-label="Username" aria-describedby="basic-addon1" required="">
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">
							Cancelar
						</button>
						<button type="submit" class="btn btn-primary" id="btn">
							Guardar
						</button>
						<input type="hidden" name="action" id="action" value="store">
						<input type="hidden" name="id" id="id">
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<!-- Scripts Funciones -->
	<script type="text/javascript" src="recursos/jquery-3.5.1.min.js"></script>
	<script type="text/javascript">

		function validateRegister(){

			if ( $("#pass1").val() == $("#pass2").val() ){
				$("#action").val('store')
				return true;
			} else {
				$("#pass1").addClass('is-invalid')
				$("#pass2").addClass('is-invalid')

				swal("", "!Las contraseñas no coinciden¡", "error");

				return false;
			}
		}

		function remove(id,target){
			swal({
				title: "",
				text: "¿Desea eliminar el usuario?",
				icon: "warning",
				buttons: true,
				dangerMode: true,
				buttons: ["Cancelar", "Eliminar"],
			})
			.then( (willDelete) => {
				if ( willDelete ){

					$.ajax({
						url: 'configPhp/UserController.php',
						type: 'POST',
						dataType: 'json',
						data: { action: 'remove', id:id },
						success: function(json) {

							if ( json.status == 'success' ) {

								swal( json.message, {
									icon: "success",
								});
								$(target).parent().parent().remove();
							} else {

								swal( json.message, {
									icon: "error",
								});
							}
						}, 
						error: function( xhr, status ){

							console.log(xhr)
							console.log(status)
						}
					});
				} else {
					swal("Tus  datos estan guardados!");
				}
			});
		}

		function editar(target){

			$("#btn").text("Guardar")
			$("#staticBackdropLabel").text("Editar Usuario")

			var info = $(target).data('info');

			$("#name").val(info.name)
			$("#email").val(info.email)
			$("#pass1").val(info.password)
			$("#pass2").val(info.password)
			$("#id").val(info.id)

			$("#action").val('update')
		}

		function add(){
			$("#btn").text("Agregar")
			$("#staticBackdropLabel").text("Agregar Usuario")
			$("#action").val('store')
			document.getElementById("myForm").reset();
		}
	</script>
</body>
</html>