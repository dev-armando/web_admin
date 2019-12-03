<?php
/*session_start();
if($_SESSION['logueado'] != "SI"){
header('location: sign-in');
exit();
}

// Coneccion - mas adelante esto ira en un archivo llamado connect.php
include 'crm/connect.php';

$user = $_SESSION['usuario'];
// User
$userl = $conn->query("SELECT * FROM usuario WHERE nombre = '".$user."'");
$row_u = $userl->fetch();
*/
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
<h2>
<a class="navbar-brand js-scroll-trigger" href="#page-top">
<img class="rounded-circle" src="../image/metricIcon512x512.jpg" width="64"> Sistema <span class="text-muted small">beta</span>
</a>
</h2>
<a class="btn btn-outline-light btn-sm text-muted border rounded-pill" href="../out">LogOut</a>
</div>
<div class="col-sm-12 col-md-4 mt-4 mb-4 text-capitalize">
<div class="text-right">
<a class="btn btn-success btn-sm rounded-pill" style="background-color: #6FCD17; font-weight: bold; border: 1px solid #6FCD17;" href="#">
Usuario
</a>
<a class="btn btn-outline-light text-muted btn-sm rounded-pill" style="background-color: #fff; font-weight: bold; border: 1px solid #fff;" href="#">
Maria
</a>

<div class="p-3 mt-2">
<span class="small">Valor por hora</span>
<span class="h5">$160</span>
<br>
<span class="small">Gastos</span>
<span class="h5">$125</span>
</div>
</div>
</div>
</div>
</div>

<div class="container">
<br>
<form class="form-inline">
<div class="form-group">
<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Buscar proyecto">
</div>
<button type="submit" class="ml-2 btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
</form>

<br>

<table class="table">
<thead class="thead-light">
<tr>
<th scope="col"><i class="far fa-list-alt"></i> Proyecto</th>
<th scope="col"><i class="far fa-clock"></i> Horas</th>
<th scope="col"><i class="far fa-file-alt"></i> Detalle</th>
<th scope="col"><i class="far fa-file-excel"></i> Exportar</th>
</tr>
</thead>
<tbody>
<tr>
<td>Gmail is a free, advertising-supported email service developed by Google.</td>
<td>
<a href="#" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Cargar horas</a>
</td>
<td><a href="#"><i class="fas fa-external-link-alt"></i> Ver</a></td>
<td><a href="#"><i class="fas fa-download"></i></a></td>
</tr>
</tbody>
</table>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>