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

<?php incluir_file_var('include/menu.php' , array('opcion' => 'project' ) ) ?>

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
<div class="p-4 bg-white">
<?php

$estado = '0';
$fecha = date('d-m-Y');

if(isset($_POST['add'])){
	if(!empty($_POST['nproyecto']) && !empty($_POST['ndescrp']) && !empty($_POST['ncliente']) && !empty($_POST['ngasto']) && !empty($_POST['valorgasto']) && !empty($_POST['hora']) && !empty($_POST['desde']) && !empty($_POST['hasta'])){
		$add = $conn->prepare("INSERT INTO proyectos (nombre_proyecto_id, pdescrip, pcliente, phorapro, pestado, pgasto, vpgasto, pdesde, phasta, pfecha) VALUES (:nombre_proyecto_id, :descrip, :cliente, :horapro, :estado, :gasto, :valor, :desde, :hasta, :fecha)");
		$add->bindValue(':nombre_proyecto_id', $_POST['nproyecto']);
		$add->bindValue(':descrip', $_POST['ndescrp']);
		$add->bindValue(':cliente', $_POST['ncliente']);
		$add->bindValue(':horapro', $_POST['hora']);
		$add->bindValue(':estado', $estado);
		$add->bindValue(':gasto', $_POST['ngasto']);
		$add->bindValue(':valor', $_POST['valorgasto']);
		$add->bindValue(':desde', $_POST['desde']);
		$add->bindValue(':hasta', $_POST['hasta']);
		$add->bindValue(':fecha', $fecha);
		$add->execute();

		//header('location: ../me');
		echo '<div class="mb-3">El proyecto se agrego correctamente</div>';
	} else {
		echo 'Error';
	}
}
?>
<form action="" method="POST">
<div class="form-group">
	<select name="nproyecto" class="form-control">
		<?php
			$project_names = $conn->query("SELECT * FROM nombre_proyecto ORDER BY nombre DESC");
			while ($project_name = $project_names->fetch()) {
		?>
				<option value="<?php echo $project_name['id'] ?>"><?php echo $project_name['nombre'] ?></option>
		<?php
			}
		?>
	</select>
</div>
<div class="form-group"><textarea name="ndescrp" class="form-control" rows="6" placeholder="Descripci&oacute;n (max 260 car)" maxlength="260"></textarea></div>

<div class="form-row">
<div class="form-group col-md-8">
<select name="ncliente" class="form-control">
<option>Cliente</option>
<?php
$list = $conn->query("SELECT * FROM clientes");
while ($row = $list->fetch()) {
?>
<option value="<?=$row['crazonsocial'];?>"><?=$row['crazonsocial'];?></option>
<?php } ?>
</select>
</div>

<div class="form-group col-md-4"><input type="text" name="hora" class="form-control" placeholder="Horas estimadas" maxlength="4"></div>
</div>

<div class="form-row">
<div class="form-group col-md-8">
<select name="ngasto" class="form-control">
<option>Lista de gastos</option>
<?php
$list = $conn->query("SELECT * FROM gastos");
while ($row = $list->fetch()) {
?>
<option value="<?=$row['tipogasto'];?>"><?=$row['tipogasto'];?></option>
<?php } ?>
</select>
</div>

<div class="form-group col-md-4"><input type="text" name="valorgasto" class="form-control" placeholder="Valor estimativo" maxlength="4"></div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
<label for="inicio">Inicia</label>
<input type="date" name="desde" id="inicio" class="form-control">
</div>
<div class="form-group col-md-6">
<label for="finaliza">Finaliza</label>
<input type="date" name="hasta" id="finaliza" class="form-control">
</div>
</div>
<button name="add" class="btn btn-primary btn-sm">Crear Proyecto</button>
</form>
</div>
</div>

<div class="col-md-6">
<div class="p-4 bg-white">
<h5>Últimos nombres de proyectos agregados</h5>
<hr>
<?php
$rlast = $conn->query("SELECT * FROM proyectos ORDER BY idp DESC");
while ($last = $rlast->fetch()) {
?>
<p>
<?=$last['pnombre'];?> <span class="text-muted" style="float: right;"><?=$last['pcliente'];?></span><br>
<a href="../../ressource/?@=<?=$last['idp'];?>" title="Editar">Asignar recurso</a>
</p>
<?php } ?>
</div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>