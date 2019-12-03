<?php
session_start();
if($_SESSION['logueado'] != "SI"){
header('location: ../sign-in');
exit();
}

include '../crm/connect.php';

$user = $_SESSION['usuario'];
$userl = $conn->query("SELECT * FROM usuario WHERE nombre = '".$user."'");
$row_u = $userl->fetch();

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

<a class="btn btn-sm border rounded-pill" href="../"><i class="fas fa-bars"></i> Panel</a>
<div class="btn-group">
<div class="dropdown">
<button class="btn btn-light dropdown-toggle btn-sm rounded-pill text-white" style="background-color: #ff9900; border: 1px solid #ff9900;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<i class="far fa-file-alt"></i> Agregar
</button>
<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<a class="dropdown-item" href="../new/project">Nuevo Proyecto</a>
<a class="dropdown-item" href="../new/client">Nuevo Cliente</a>
<a class="dropdown-item" href="../new/resource">Nuevo Recurso</a>
<a class="dropdown-item" href="../new/expense">Categoria Gastos</a>
</div>
</div>
</div>
<!--a class="btn btn-sm border rounded-pill" href="#"><i class="fas fa-cog"></i> Setting</a-->
<a class="btn btn-sm border rounded-pill" href="../out"><i class="fas fa-sign-out-alt"></i> LogOut</a>
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
<div class="col-md-5">
<div class="p-4 bg-white">
<h5><?=$row['pnombre'];?></h5>
<p><?=$row['pdescrip'];?></p>
<hr>
<div class="d-flex w-100 justify-content-between">
<span class="mb-1 text-muted"><?=$row['pcliente'];?></span>
<?php
if($row['pestado'] == '0') {
?>
<span class="text-primary"><a href="#"><i class="fas fa-toggle-on"></i></a></span>
<?php
} else {
?>
<span class="text-muted"><i class="fas fa-toggle-off"></i></span>
<?php
}
?>
</div>
<hr>
<div class="row">
<div class="col-md-6">
Inicio
<p>
<?php
$dfecha = new DateTime($row['pdesde']);
$dfecha_d_m_y = $dfecha->format('d-m-Y');
echo $dfecha_d_m_y;
?>
</p>
</div>
<div class="col-md-6">
Finalizaci&oacute;n
<p>
<?php
$hfecha = new DateTime($row['phasta']);
$hfecha_d_m_y = $hfecha->format('d-m-Y');
echo $hfecha_d_m_y;
?>
</p>
</div>
</div>
<p class="small text-muted">Creado el dia <?=$row['pfecha'];?></p>
</div>
</div>

<div class="col-md-4">
<div class="d-flex w-100 justify-content-between">
Horas estimadas
<span><?=$row['phorapro'];?> hs.</span>
</div>

<div class="d-flex w-100 justify-content-between">
Horas trabajadas
<?php
$total = $conn->query("select sum(horaspro.totalh) AS totalh from horaspro where idpro ='".$idp."'");
$tfila = $total->fetch();
?>
<span><?=$tfila['totalh'];?> hs.</span>
</div>

<div class="d-flex w-100 justify-content-between">
Diferencia
<span>
<?php
$estimada = $row['phorapro'];
$trabajadas = $tfila['totalh'];
$diferencia = $estimada - $trabajadas;

echo '<b>'.$diferencia.' hs.</b>';
?>
</span>
</div>
<hr>
<p>Horas de trabajo</p>
<p>
<?php
$glist = $conn->query("SELECT *, sum(horaspro.totalh) AS totalh FROM proyectos INNER JOIN horaspro ON horaspro.idpro = proyectos.idp INNER JOIN recurso ON horaspro.idrecurso = recurso.id WHERE idp = '".$idp."' GROUP BY recurso.rnombre");
while ($fila = $glist->fetch()) {
?>
<div class="d-flex w-100 justify-content-between">
<?=$fila['rnombre'];?>
<span><?=$fila['totalh'];?> hs.</span>
</div>
<?php
}
?>
</p>
<small><a href="../ressource/?@=<?=$idp;?>">+ Asignar Recurso</a></small>
<!--p>
<form>
<div class="form-group">
<input type="text" class="form-control" placeholder="Nombre del recurso">
<small id="emailHelp" class="form-text text-muted">
Agregar un nuevo recurso.
</small>
</div>
<button type="submit" class="btn btn-primary btn-sm">Submit</button>
</form>
</p-->
</div>

<div class="col-md-3">
Gastos
<hr>
<small><a href="#">+ Asignar Gastos</a></small>
</div>
</div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>