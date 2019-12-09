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



$recursos = $conn->query("SELECT re.* FROM `recpro` as rp JOIN recurso as re ON re.id = rp.idrec");


$clientes = $conn->query("SELECT distinct pcliente as nombre FROM `proyectos` as pro JOIN nombre_proyecto as np ON np.id = pro.nombre_proyecto_id");


$proyectos = $conn->query("SELECT distinct np.* FROM `proyectos` as pro JOIN nombre_proyecto as np ON np.id = pro.nombre_proyecto_id");



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

<?php incluir_file_var('include/menu.php' , array('opcion' => 'reporte'  )  ) ?>

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

</div>
</div>

<div class="container">
<div class="mt-4">
<table id="show-results" class="table bg-white">
<thead class="thead-light">
<div class="search-container row">

        <div class="col-md-4">
            <div class="form-group">
                <select  class="form-control" name=recursos >
                    <option selected disabled>Recursos</option>
                    <option value="T" > TODOS </option>
                    <?php while ($fila = $recursos->fetch()): ?>
                        <option <?= "value='".$fila['id']."'"  ?> >  <?= $fila['rnombre'] ?>  </option>
                    <?php endwhile ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <select  class="form-control" name=proyectos >
                    <option selected disabled>Proyectos</option>
                    <option value="T" > TODOS </option>
                    <?php while ($fila = $proyectos->fetch()): ?>
                        <option <?= "value='".$fila['id']."'"  ?> >  <?= $fila['nombre'] ?>  </option>
                    <?php endwhile ?>
                </select>
            </div>
        </div>
         <div class="col-md-4">
            <div class="form-group">
                <select  class="form-control" name=clientes >
                    <option selected disabled>Clientes</option>
                    <option value="T" > TODOS </option>
                         <?php while ($fila = $clientes->fetch()): ?>
                        <option <?= "value='".$fila['nombre']."'"  ?> >  <?= $fila['nombre'] ?>  </option>
                    <?php endwhile ?>
                </select>
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
                <button onclick="return generarReporte()"  id="make-query" class="btn btn-primary">Generar</button>
            </div>
        </div>
  
</div>
<tr style="display: none">
<th scope="col"><i class="far fa-list-alt"></i> Proyecto</th>
<th scope="col"><i class="far fa-building"></i> Cliente</th>
<th scope="col"><i class="far fa-building"></i> Estado</th>
<th scope="col"><i class="far fa-calendar-alt"></i> Inicio</th>
<th scope="col"><i class="far fa-calendar-alt"></i> Finalizaci&oacute;n</th>
<th scope="col"><i class="fas fa-sliders-h"></i> Opciones</th>
</tr>
</thead>
<tbody style="display: none"  id="tbody"></tbody>
</table>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="buscar/ajax.js"></script>

<script>
    function generarReporte(){

       let desde = $("select[name=from-date]").val(); 
       let hasta  = $("select[name=to-date]").val();
       let proyectos  = $("select[name=proyectos]").val(); 
       let recursos  = $("select[name=recursos]").val(); 
       let clientes  = $("select[name=clientes]").val();

       window.location.href = `reportes/index.php?desde=${desde}&hasta=${hasta}&proyectos=${proyectos}&recursos=${recursos}&clientes=${clientes}&tipo=reporteMasivo`;   
    }
</script>

</body>
</html>