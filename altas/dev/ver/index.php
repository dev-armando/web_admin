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
<h2>
<a class="navbar-brand js-scroll-trigger" href="#page-top">
<img class="rounded-circle" src="../../image/metricIcon512x512.jpg" width="64"> Manager <span class="text-muted small">beta</span>
</a>
</h2>

<a class="btn btn-sm border rounded-pill" href="../"><i class="fas fa-bars"></i> Panel</a>
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
<p>Resumen del proyecto</p>
<h5><?=$row['pdescrip'];?></h5>
<hr>

<p class="small text-muted">Creado el dia <?=$row['pfecha'];?></p>
</div>
</div>

<div class="col-md-7">
Horas
<hr>

<?php
$list = $conn->query("SELECT *, sum(horaspro.totalh) AS totalh FROM proyectos INNER JOIN horaspro ON horaspro.idpro = proyectos.idp INNER JOIN recurso ON horaspro.idrecurso = recurso.id WHERE idp = '".$idp."' GROUP BY recurso.rnombre");
$rfila = $list->fetch();
?>
<div class="">
Valor por hora: $<?=$rfila['rvhora'];?><br>
Total de horas: <?=$rfila['totalh'];?> hs.
<hr>
<?php
$cuenta = $rfila['rvhora']*$rfila['totalh'];
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

<span>  <b>Fecha de las Horas Cargadas:  </b>  <?= $fila['fechah']; ?> hs.</span>
</div>

<div class="d-flex w-100 justify-content-between">

<span>  <b>Fecha Creacion:  </b>  <?= $fila['hdate']; ?> hs.</span>
</div>


<div class="d-flex w-100 justify-content-between">

<span>  <b>Cantidad de Horas:  </b>  <?= $fila['totalh']; ?> hs.</span>
</div>


<br> 
<hr>

<?php
}
?>
</div>
</div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>