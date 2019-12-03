<?php
session_start();
if($_SESSION['logueado'] != "SI"){
header('location: sign-in');
exit();
}

include 'crm/connect.php';

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
<link rel="stylesheet" href="css/style.css">
<script src="https://kit.fontawesome.com/cbec68f37d.js"></script>
</head>
<body>
<div class="container">
<div class="row">
<div class="col-sm-12 col-md-8 mt-4 mb-4 text-capitalize">
<h2 class="mb-4">
<a class="navbar-brand js-scroll-trigger" href="#page-top">
<img class="rounded-circle" src="image/manager512x512.png" width="44"> Manager <span class="text-muted small">beta</span>
</a>
</h2>

<span class="btn btn-sm border rounded-pill"><i class="fas fa-bars"></i> Panel</span>
<div class="btn-group">
<div class="dropdown">
<button class="btn btn-light dropdown-toggle btn-sm rounded-pill text-white" style="background-color: #ff9900; border: 1px solid #ff9900;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<i class="far fa-file-alt"></i> Agregar
</button>
<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<a class="dropdown-item" href="new/project">Nuevo Proyecto</a>
<a class="dropdown-item" href="new/client">Nuevo Cliente</a>
<a class="dropdown-item" href="new/resource">Nuevo Recurso</a>
<a class="dropdown-item" href="new/expense">Categoria Gastos</a>
</div>
</div>
</div>
<a class="btn btn-sm border rounded-pill" href="setting"><i class="fas fa-cog"></i> Setting</a>
<a class="btn btn-sm border rounded-pill" href="out"><i class="fas fa-sign-out-alt"></i> LogOut</a>
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
<div class="mt-4">
<table class="table bg-white">
<thead class="thead-light">
<tr>
<th scope="col"><i class="far fa-list-alt"></i> Proyecto</th>
<th scope="col"><i class="far fa-building"></i> Cliente</th>
<th scope="col"><i class="far fa-calendar-alt"></i> Inicio</th>
<th scope="col"><i class="far fa-calendar-alt"></i> Finalizaci&oacute;n</th>
<th scope="col"><i class="fas fa-sliders-h"></i> Opciones</th>
</tr>
</thead>
<?php
//$list = $conn->query("SELECT * FROM items INNER JOIN usuario ON usuario.id = items.userid WHERE tareaid = '".$tarea."'");
//$list = $conn->query("SELECT * FROM proyectos INNER JOIN recurso ON recurso.id = proyectos.precurso WHERE pestado = '0' ORDER BY idp DESC");
$list = $conn->query("SELECT * FROM proyectos WHERE pestado = '0' ORDER BY idp DESC");
while ($row = $list->fetch()) {
?>
<tbody>
<tr>
<td><?=$row['pnombre'];?></td>
<td><?=$row['pcliente'];?></td>
<td>
<?php
$dfecha = new DateTime($row['pdesde']);
$dfecha_d_m_y = $dfecha->format('d-m-Y');
echo $dfecha_d_m_y;
?>
</td>
<td>
<?php
$hfecha = new DateTime($row['phasta']);
$hfecha_d_m_y = $hfecha->format('d-m-Y');
echo $hfecha_d_m_y;
?>
</td>
<td>
<!--a href="#" title="Finalizar"><span class="text-primary"><i class="fas fa-toggle-on"></i></span></a-->
<a href="edit?@=<?=$row['idp'];?>" title="Editar"><i class="far fa-edit"></i></a>
</td>
</tr>
</tbody>
<?php } ?>
</table>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>