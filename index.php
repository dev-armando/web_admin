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

<?php incluir_file_var('include/menu.php' , array('opcion' => 'panel'  )  ) ?>

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
<table id="show-results" class="table bg-white">
<thead class="thead-light">
<div class="search-container row">
    <form>
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" id="search" class="form-control" name="search" placeholder="Buscar..." />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <select name="from-date" id="from-date" class="form-control">
                    <option selected disabled>Desde</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <select name="to-date" id="to-date" class="form-control">
                    <option selected disabled>Hasta</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <button id="make-query" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>
</div>
<tr>
<th scope="col"><i class="far fa-list-alt"></i> Proyecto</th>
<th scope="col"><i class="far fa-building"></i> Cliente</th>
<th scope="col"><i class="far fa-building"></i> Estado</th>
<th scope="col"><i class="far fa-calendar-alt"></i> Inicio</th>
<th scope="col"><i class="far fa-calendar-alt"></i> Finalizaci&oacute;n</th>
<th scope="col"><i class="fas fa-sliders-h"></i> Opciones</th>
</tr>
</thead>
<tbody id="tbody"></tbody>
</table>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="buscar/ajax.js"></script>
</body>
</html>