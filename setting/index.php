<?php
session_start();
if($_SESSION['logueado'] != "SI"){
header('location: sign-in');
exit();
}

include '../crm/connect.php';

Helpers::validaPermiso('setting');

$user = $_SESSION['usuario'];
// User
$userl = $conn->query("SELECT * FROM usuario WHERE nombre = '".$user."'");
$row_u = $userl->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Manager</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">
<script src="https://kit.fontawesome.com/cbec68f37d.js"></script>
</head>
<body>
<div class="container">
<div class="row">
<div class="col-sm-12 col-md-8 mt-4 mb-4 text-capitalize">
<h2 class="mb-4">
<a class="navbar-brand js-scroll-trigger" href="#page-top">
<img class="rounded-circle" src="../image/manager512x512.png" width="44"> Manager <span class="text-muted small">beta</span>
</a>
</h2>

<?php incluir_file_var('include/menu.php' , array('opcion' => 'setting' ) ) ?>

<!--div class="p-3 mt-2">
<span class="small">data</span>
<span class="h4">dto</span>
<span class="small text-success">Active</span>
<br>
<span class="small">Projects</span>
<span class="h4">125</span>
</div-->
</div>
</div>
</div>
</div>

<div class="container">
<div class="row">
<!--div class="col-sm-3">
<div class="card">
<div class="card-body">
<h4 class="card-title">250</h4>
<p class="card-text">Proyectos</p>
</div>
</div>
</div>

<div class="col-sm-3">
<div class="card">
<div class="card-body">
<h4 class="card-title">400</h4>
<p class="card-text">Usuarios</p>
</div>
</div>
</div>

<div class="col-sm-3">
<div class="card">
<div class="card-body">
<h4 class="card-title">$344140</h4>
<p class="card-text">Ingresos</p>
</div>
</div>
</div>

<div class="col-sm-3">
<div class="card">
<div class="card-body">
<h4 class="card-title">$15340</h4>
<p class="card-text">Gastos</p>
</div>
</div>
</div-->
</div>
</div>

<div class="container">
<div class="row">
<div class="col-sm-12 col-md-8 mt-4 mb-4">
<div class="p-4 bg-white">
<h5>Nuevo usuario</h5>
<p class="mt-4">
<?php
$fecha = date('d-m-Y');
if(isset($_POST['add'])){

	incluir_file_var("modelo/usuarios.php");
	$modelo = new Usuarios($conn); 

	if(!empty($_POST['nombre']) && !empty($_POST['pass']) && !empty($_POST['cate']) ){
		$add = $conn->prepare("INSERT INTO usuario (nombre, pass, cate, email, ufecha) VALUES (:nombre, :pass, :cate, :email, :fecha)");
		$add->bindValue(':nombre', strtolower($_POST['nombre']));
		$add->bindValue(':pass', md5($_POST['pass']));
		$add->bindValue(':cate', $_POST['cate']);
		$add->bindValue(':email', $_POST['mail']);
		$add->bindValue(':fecha', $fecha);
		$add->execute();


		echo '<div class="mb-3">El recurso se agreg&oacute; correctamente</div>';

		$modelo->updateValorHora(strtolower($_POST['nombre']) , $_POST['v_hora']) ;

	} else {
		echo 'Error';
	}
}
?>
<form action="" method="POST">
<div class="form-row">
<div class="form-group col-md-8">
<input type="text" name="nombre" class="form-control" placeholder="Nombre de usuario (max 40 car)" maxlength="40">
</div>

<div class="form-group col-md-4">
<select name="cate" class="form-control">
<option>Categoria</option>
<option value="1">Administrador</option>
<option value="2">GPC</option>
</select>
</div>
</div>

<div class="form-group"><input type="password" name="pass" class="form-control" placeholder="Contrase&ntilde;a"></div>
<div class="form-group"><input type="text" name="mail" class="form-control" placeholder="Email"></div>

<div class="form-group"><input type="text" name="v_hora" class="form-control" placeholder="Valor por Hora"></div>

<button name="add" class="btn btn-primary btn-sm">Agregar</button>
</form>
</p>
</div>
</div>

<div class="col-sm-12 col-md-4 mt-4 mb-4">
<div class="p-4 bg-white">
<p>Lista de usarios</p>
<hr>
<?php
$glist = $conn->query("SELECT * FROM usuario");
while ($fila = $glist->fetch()) {
?>
<?php
if($fila['cate'] == '1') {
?>
<p>
<span class="text-capitalize"><?=$fila['nombre'];?></span> <span class="text-muted">(Admin)</span><br>
<a <?= Helpers::addHrefID( 'editar.php', $fila['id']) ?> ><i class="far fa-edit"></i></a>
<a <?= Helpers::addHrefID( 'consultar.php', $fila['id']) ?> ><i class="fa fa-search"></i></a>

<span class="text-muted"><?=$fila['email'];?></span>

</p>
<?php
} else {
?>
<p>
<span class="text-capitalize"><?=$fila['nombre'];?></span> <span class="text-muted">(GPC)</span><br>
<a <?= Helpers::addHrefID( 'editar.php', $fila['id']) ?> ><i class="far fa-edit"></i></a>
<a <?= Helpers::addHrefID( 'consultar.php', $fila['id']) ?> ><i class="fa fa-search"></i></a>
<span class="text-muted"><?=$fila['email'];?></span>
</p>
<?php
}
}
?>
</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>