<?php
session_start();
if($_SESSION['logueado'] != "SI"){
header('location: sign-in');
exit();
}

include '../crm/connect.php';

$user = $_SESSION['usuario'];

$menu_adm = isset( $_SESSION['usuario_adm']  ) ? '1' : '0';


// User
$userl = $conn->query("SELECT * FROM recurso WHERE rusuario = '".$user."'");
$row_u = $userl->fetch();
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
<img class="rounded-circle" src="../image/metricIcon512x512.jpg" width="64"> Manager <span class="text-muted small">beta</span>
</a>
</h2>


<?php if ($menu_adm == '1'): ?>


<a   href="../../index.php" class="btn btn-sm border rounded-pill"><i class="fas fa-bars"></i> Panel</a>
<?php incluir_file_var('include/menu.php' , array('auxiliar' => '1'  )  ) ?>

<?php else: ?>

<span class="btn btn-sm border rounded-pill"><i class="fas fa-bars"></i> Panel</span>

<?php endif ?>
<a class="btn btn-sm border rounded-pill" href="../out">LogOut</a>

</div>
<div class="col-sm-12 col-md-4 mt-4 mb-4 text-capitalize">
<div class="text-right">
<span class="btn btn-success btn-sm rounded-pill" style="background-color: #6FCD17; font-weight: bold; border: 1px solid #6FCD17;">
Desarrollo
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
<div class="col-md-12">
<table class="table bg-white">
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
                <input type="hidden" id="user_id" value="<?php echo $row_u['id'] ?>" />
            </div>
        </div>
    </form>
</div>
<tr>
<th scope="col"><i class="far fa-list-alt"></i> Proyecto</th>
<th scope="col"><i class="far fa-list-alt"></i> Clientes</th>
<th scope="col">Opciones</th>
</tr>
</thead>

<tbody id="tbody">

</tbody>

</table>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="./ajax.js"></script>
</body>
</html>