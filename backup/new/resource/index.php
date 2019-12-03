<?php
session_start();
if($_SESSION['logueado'] != "SI"){
header('location: sign-in');
exit();
}

include '../../crm/connect.php';

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
<link rel="stylesheet" href="../../css/style.css">
<script src="https://kit.fontawesome.com/cbec68f37d.js"></script>
</head>
<body>
<div class="container">
<div class="row">
<div class="col-sm-12 col-md-8 mt-4 mb-4 text-capitalize">
<h2 class="mb-4">
<a class="navbar-brand js-scroll-trigger" href="#page-top">
<img class="rounded-circle" src="../../image/manager512x512.png" width="44"> Manager <span class="text-muted small">beta</span>
</a>
</h2>

<a class="btn btn-sm border rounded-pill" href="../../"><i class="fas fa-bars"></i> Panel</a>
<div class="btn-group">
<div class="dropdown">
<button class="btn btn-light dropdown-toggle btn-sm rounded-pill text-white" style="background-color: #ff9900; border: 1px solid #ff9900;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<i class="far fa-file-alt"></i> Agregar
</button>
<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<a class="dropdown-item" href="../project">Nuevo Proyecto</a>
<a class="dropdown-item" href="../client">Nuevo Cliente</a>
<span class="dropdown-item">Nuevo Recurso</span>
<a class="dropdown-item" href="../expense">Categoria Gastos</a>
</div>
</div>
</div>
<!--a class="btn btn-sm border rounded-pill" href="#"><i class="fas fa-cog"></i> Setting</a-->
<a class="btn btn-sm border rounded-pill" href="../../out"><i class="fas fa-sign-out-alt"></i> LogOut</a>
</div>
<div class="col-sm-12 col-md-4 mt-4 mb-4 text-capitalize">
<div class="text-right">
<span class="btn btn-success btn-sm rounded-pill" style="background-color: #6FCD17; font-weight: bold; border: 1px solid #6FCD17;">
<?php if($row_u['cate'] == '1') { ?>
Admin
<?php } else { ?>
GSP
<?php } ?>
</span>
<span class="btn btn-outline-light text-muted btn-sm rounded-pill" style="background-color: #fff; font-weight: bold; border: 1px solid #fff;">
<?=$user;?>
</span>

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
<div class="col-md-6">
<div class="p-3 bg-white">
<h4>Nuevo Recurso</h4>
<p class="mt-4">
<?php
$fecha = date('d-m-Y');
if(isset($_POST['add'])){
	if(!empty($_POST['rnombre']) && !empty($_POST['rusuario']) && !empty($_POST['rpass']) && !empty($_POST['rmail']) && !empty($_POST['rvalor'])){
		$add = $conn->prepare("INSERT INTO recurso (rnombre, rvhora, rcorreo, rusuario, rpass, rfecha) VALUES (:nombre, :vhora, :correo, :usuario, :pass, :fecha)");
		$add->bindValue(':nombre', $_POST['rnombre']);
		$add->bindValue(':pass', md5($_POST['rpass']));
		$add->bindValue(':vhora', $_POST['rvalor']);
		$add->bindValue(':correo', $_POST['rmail']);
		$add->bindValue(':usuario', strtolower($_POST['rusuario']));
		$add->bindValue(':fecha', $fecha);
		$add->execute();

		echo '<div class="mb-3">El usuario se agreg&oacute; correctamente</div>';
	} else {
		echo 'Error';
	}
}
?>
<form action="" method="POST">
<div class="form-group"><input type="text" name="rnombre" class="form-control" placeholder="Nombre y Apellido (max 40 car)"></div>
<div class="form-group"><input type="text" name="rusuario" class="form-control" placeholder="Nombre de Usuario (max 40 car)"></div>
<div class="form-group"><input type="password" name="rpass" class="form-control" placeholder="Contrase&ntilde;a"></div>
<div class="form-group"><input type="text" name="rmail" class="form-control" placeholder="Email"></div>
<div class="form-group"><input type="text" name="rvalor" class="form-control" placeholder="Velor por hora"></div>
<button name="add" class="btn btn-primary btn-sm">Agregar Recurso</button>
</form>
</p>
</div>
</div>

<div class="col-md-6">
<div class="p-3 bg-white">
<h5>Recursos</h5>
<hr>
<?php
$rlast = $conn->query("SELECT * FROM recurso ORDER BY id DESC");
while ($last = $rlast->fetch()) {
?>
<p>
<?=$last['rnombre'];?> <span class="text-muted">(<?=$last['rusuario'];?>)<br>
<?=$last['rcorreo'];?></span>
</p>
<?php } ?>
</div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>