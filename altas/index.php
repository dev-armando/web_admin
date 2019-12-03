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

<a class="btn btn-outline-light btn-sm text-muted border rounded-pill" href="../panel">Panel</a>
<a class="btn btn-outline-light btn-sm text-muted border rounded-pill" href="#">Altas</a>
<a class="btn btn-outline-light btn-sm text-muted border rounded-pill" href="../out">LogOut</a>
</div>
<div class="col-sm-12 col-md-4 mt-4 mb-4 text-capitalize">
<div class="text-right">
<a class="btn btn-success btn-sm rounded-pill" style="background-color: #6FCD17; font-weight: bold; border: 1px solid #6FCD17;" href="#">
Administrador
</a>
<a class="btn btn-outline-light text-muted btn-sm rounded-pill" style="background-color: #fff; font-weight: bold; border: 1px solid #fff;" href="#">
Maria
</a>


<div class="p-3 mt-2">
<span class="small">Plan Go</span>
<span class="h4">$16000</span>
<span class="small text-success">Active</span>
<br>
<span class="small">Projects</span>
<span class="h4">125</span>
</div>
</div>
</div>
</div>
</div>

<div class="container">
<div class="row">
<div class="card-columns">
<div class="card">
<div class="card-header">Nuevo Proyecto</div>
<blockquote class="blockquote mb-0 card-body">
<form>
<div class="form-group">
<input type="text" class="form-control" placeholder="Nombre del proyecto (max 60 car)">
</div>
<div class="form-group">
<textarea class="form-control" rows="3" placeholder="Descripci&oacute;n (max 260 car)"></textarea>
</div>

<div class="form-group">
<select class="form-control">
<option>Cliente</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
</select>
</div>

<div class="form-group">
<input type="text" class="form-control" placeholder="Horas proyectadas">
</div>

<div class="form-group">
<input type="text" class="form-control" placeholder="Monto proyactado">
</div>


<div class="form-row">
<div class="form-group col-md-6">
<input type="text" class="form-control" placeholder="Gastos estimados">
</div>

<div class="form-group col-md-6">
<select class="form-control">
<option>Categoria</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
</select>
</div>
</div>

<button type="submit" class="btn btn-primary">Submit</button>
</form>
</blockquote>
</div>


<div class="card">
<div class="card-header">Nuevo Cliente</div>
<blockquote class="blockquote mb-0 card-body">
<form>
<div class="form-group">
<input type="text" class="form-control" placeholder="Nombre cliente (max 60 car)">
</div>
<div class="form-group">
<input type="text" class="form-control" placeholder="Raz&oacute;n social (max 60 car)">
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>
</blockquote>
</div>

<div class="card">
<div class="card-header">Carga Horaria</div>
<blockquote class="blockquote mb-0 card-body">
<form>
<div class="form-group">
<input type="text" class="form-control" placeholder="Cantidad de Horas">
</div>
<div class="form-group">
<input type="text" class="form-control" placeholder="Buscar proyecto">
</div>
<div class="form-group">
<input type="date" class="form-control" placeholder="Fecha">
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>
</blockquote>
</div>

<div class="card">
<div class="card-header">Nuevo Recurso</div>
<blockquote class="blockquote mb-0 card-body">
<form>
<div class="form-group">
<input type="text" class="form-control" placeholder="Nombre (max 60 car)">
</div>
<div class="form-group">
<input type="text" class="form-control" placeholder="Valor por hora">
</div>
<div class="form-group">
<input type="text" class="form-control" placeholder="Correo electr&oacute;nico">
</div>
<div class="form-group">
<input type="text" class="form-control" placeholder="Usuario">
</div>
<div class="form-group">
<input type="text" class="form-control" placeholder="Contrase&ntilde;a">
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>
</blockquote>
</div>



<div class="card">
<div class="card-header">Nuevo Gastos</div>
<blockquote class="blockquote mb-0 card-body">
<form>
<div class="form-group">
<input type="text" class="form-control" placeholder="Nuevo gasto">
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>
<div class="card-body">
<h5 class="card-title">Actuales</h5>
<p class="card-text" style="font-size: 1rem;">
Movilidad<br>
Licencia<br>
Gastos de seguro
</p>
</div>
</blockquote>
</div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>