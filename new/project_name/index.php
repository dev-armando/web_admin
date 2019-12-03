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

<?php incluir_file_var('include/menu.php' , array('opcion' => 'project_name' ) ) ?>


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
<h4>Cargar Proyecto</h4>
<p class="mt-4">
<?php
if(isset($_POST['add'])){
	if(!empty($_POST['project_name'])){
		$add = $conn->prepare("INSERT INTO nombre_proyecto (nombre) VALUES (:nombre)");
		$add->bindValue(':nombre', $_POST['project_name']);
		$add->execute();

		//header('location: ../me');
		echo '<div class="mb-3">Se agrego un nuevo nombre a la lista</div>';
	} else {
		echo 'Error';
	}
}
?>
<form action="" method="POST">
<div class="form-group">
<input type="text" name="project_name" class="form-control" placeholder="Nombre">
</div>
<button name="add" class="btn btn-primary btn-sm">Agregar</button>
</form>
</p>
</div>
</div>

<div class="col-md-6">
<div class="p-3 bg-white">
<h5>Proyectos Cargados</h5>
<hr>
<?php
$rlast = $conn->query("SELECT * FROM nombre_proyecto ORDER BY nombre ASC");
while ($last = $rlast->fetch()) {
?>
<p>
<?=$last['nombre'];?>
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