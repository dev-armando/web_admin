<?php
session_start();
if($_SESSION['logueado'] != "SI"){
header('location: ../sign-in');
exit(); 
}

include '../../crm/connect.php';

$user = $_SESSION['usuario'];
// User
$userl = $conn->query("SELECT * FROM recurso WHERE rusuario = '".$user."'");
$row_u = $userl->fetch();

$userid = $row_u['id'];

$idp = $_GET['@']; 

$pro = $conn->query("SELECT * FROM proyectos WHERE idp = '".$idp."'");
$row = $pro->fetch();

$pro_titulo = $conn->query("SELECT * FROM nombre_proyecto WHERE id = '".$row['nombre_proyecto_id']."'");

$row_2 = $pro_titulo->fetch();



incluir_file_var("modelo/recursos.php");
$modelo = new Recursos($conn); 


$horas_asignadas = $modelo->getHorasAsignadas($userid ,$idp  );
$horas_consumidas = $modelo->getHorasConsumidas($userid ,$idp  );

$menu_adm = isset( $_SESSION['usuario_adm']  ) ? '1' : '0';


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

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">



</head>
<body>
<div class="container">
<div class="row">
<div class="col-sm-12 col-md-8 mt-4 mb-4 text-capitalize">
<h2>
<a class="navbar-brand js-scroll-trigger" href="#page-top">
<img class="rounded-circle" src="../../image/metricIcon512x512.jpg" width="64"> Manager <span class="text-muted small">beta</span>
</a>
</h2>


<?php if ($menu_adm == '1'): ?>


<a   href="../../index.php" class="btn btn-sm border rounded-pill"><i class="fas fa-bars"></i> Panel</a>

<?php incluir_file_var('include/menu.php' , array('auxiliar' => '1'  )  ) ?> 

<?php else: ?>

<a href="../index.php" class="btn btn-sm border rounded-pill"><i class="fas fa-bars"></i> Panel</a>

<?php endif ?>

<a class="btn btn-sm border rounded-pill" href="../../out"><i class="fas fa-sign-out-alt"></i> LogOut</a>
</div>
<div class="col-sm-12 col-md-4 mt-4 mb-4 text-capitalize">
<div class="text-right">
<span class="btn btn-success btn-sm rounded-pill" style="background-color: #6FCD17; font-weight: bold; border: 1px solid #6FCD17;">
Administrador
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
<div class="col-md-5">
<div class="p-4 bg-white">

<h5><?=$row_2['nombre'];?></h5>
<p>Resumen del proyecto</p>
<h5><?=$row['pdescrip'];?></h5>
<hr>


<p>Cliente</p>
<h5><?=$row['pcliente'];?></h5>

<!-- <p class="small text-muted">Creado el dia <?=$row['pfecha'];?></p> -->
</div>
</div>

<div class="col-md-4">
<p>
Asignar horas al proyecto
</p>
<?php

$recurso = $row_u['id'];
$fecha = date('Y-m-d');

if(isset($_POST['add'])){
	if(!empty($_POST['fechah']) && !empty($_POST['horas'])){


		$hora = $modelo->getHoraValorByID($recurso );

		$add = $conn->prepare("INSERT INTO horaspro (idpro, idrecurso, fechah, totalh, hdate, id_usuario_hora) VALUES (:pro, :rec, :fechah, :total, :date, :hora)");
		$add->bindValue(':pro', $idp);
		$add->bindValue(':rec', $recurso);
		$add->bindValue(':fechah', $_POST['fechah']);
		$add->bindValue(':total', $_POST['horas']);
		$add->bindValue(':date', $fecha);
		$add->bindValue(':hora', $hora);
		$add->execute();

		echo '<div class="mb-3">Hora asignada perfectamente</div>';
	} else {
		echo 'Error';
	}
}
?>

<?php if($row['pestado'] != '3' && $row['pestado'] != '2' ):?>
<form action="" method="POST">
<div class="form-row">
<div class="form-group col-md-7">
<input type="date" name="fechah" class="form-control">
</div>
<div class="form-group col-md-5">


<input type="text" name="horas" class="form-control timepicker" placeholder="Asignar horas" maxlength="2"   >



</div>
</div>
<button name="add" class="btn btn-primary btn-sm">Agregar horas</button>
</form>
</div>
<?php endif ?>

<div class="col-md-3">
Horas
<hr>

<?php
$list = $conn->query("SELECT
	*,
	sum( horaspro.totalh ) AS totalh 
FROM
	proyectos
	INNER JOIN horaspro ON horaspro.idpro = proyectos.idp
	INNER JOIN recurso ON horaspro.idrecurso = recurso.id 
	INNER JOIN recurso_hora as rh on horaspro.id_usuario_hora = rh.id
WHERE
	idp = '$idp' 
GROUP BY
	recurso.rnombre");
$rfila = $list->fetch();
?>
<div class="">
Valor por hora: $<?=$rfila['v_hora'];?><br>


Horas Asignadas: <?=$horas_asignadas;?>h<br>

Horas Consumidas: <?= $horas_asignadas - $rfila['totalh'] ?>h<br>

Total de horas: <?=$rfila['totalh'];?> hs.
<hr>
<?php
$cuenta = $rfila['v_hora']*$rfila['totalh'];
// echo 'Total a cobrar $'.$cuenta;
?>
</div>
<hr>
<?php
//$glist = $conn->query("SELECT * FROM proyectos INNER JOIN horaspro ON horaspro.idpro = proyectos.idp 
//INNER JOIN recurso ON horaspro.idrecurso = recurso.id WHERE id = '".$userid."'");
//$glist = $conn->query("SELECT * FROM proyectos INNER JOIN horaspro ON horaspro.idpro = proyectos.idp WHERE idp = '".$idp."'");
$glist = $conn->query("SELECT * FROM horaspro WHERE idrecurso = '".$userid."' AND idpro = '".$idp."' ORDER BY idh DESC");
while ($fila = $glist->fetch()) {
?>
<div class="d-flex w-100 justify-content-between">
<?=$fila['fechah'];?>
<span><?=$fila['totalh'];?> hs.</span>
</div>
<?php
}
?>
</div>
</div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>


<script type="text/javascript">
	
	$('.timepicker').timepicker({
    timeFormat: 'h.m',
    interval: 5,
    minTime: '01:00am',
    maxTime: '12:55pm',
    defaultTime: '23',
    startTime: '00:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
	});
</script>
</body>
</html>