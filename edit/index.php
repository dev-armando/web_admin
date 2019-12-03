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

$pro_titulo = $conn->query("SELECT * FROM nombre_proyecto WHERE id = '".$row['nombre_proyecto_id']."'");

$row_2 = $pro_titulo->fetch();



$gastos_pro = $conn->query("SELECT * FROM gastos_proyectos WHERE idp = ".$idp);


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


<?php incluir_file_var('include/menu.php' , array('opcion' => 'client' ) ) ?>


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

<div class="btn-group" style="float: right">
    <div class="dropdown">
        <button class="btn btn-light dropdown-toggle btn-sm rounded-pill text-white status-<?php echo $row['pestado'] ?>" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php
                if ($row['pestado'] == 0) {
                    echo "En Proceso";
                } else if ($row['pestado'] == 1) {
                    echo "En Pausa";
                } else if ($row['pestado'] == 3) {
                    echo "Inactivo";
                }else {
                    echo "Cancelado";
                }
            ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item item-state" href="#" data-state="0" data-id=<?php echo $idp ?>>En Proceso</a>
            <a class="dropdown-item item-state" href="#" data-state="1" data-id=<?php echo $idp ?>>En Pausa</a>
            <a class="dropdown-item item-state" href="#" data-state="2" data-id=<?php echo $idp ?>>Cancelado</a>
            <a class="dropdown-item item-state" href="#" data-state="3" data-id=<?php echo $idp ?>>Inactivo</a>
        </div>
    </div>
</div>


<?= $row_2[1] ?>

<h5><?=$row['pnombre'];?></h5>
<p><?=$row['pdescrip'];?></p>
<hr>
<div class="d-flex w-100 justify-content-between">
<span class="mb-1 text-muted"><?=$row['pcliente'];?></span>
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


<a class="btn btn-sm border rounded-pill"  <?= "href='../new/project/editar.php?idp=$idp'" ?> ><i class="fa fa-edit"></i> Editar</a>

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

<?php while( $fl = $gastos_pro->fetch()): ?>
    <p>     <?= $fl['gasto']  ?>      </p>
    <p>  <?= $fl['cantidad']  ?>  $ </p>
    <p> <small><a  href="#"  onclick="eliminar(<?= $fl['id']  ?> )"  >+ Eliminar Gasto</a></small>  </p>
    <hr> 
<?php endwhile ?>
<small><a href="../ressource/index2.php?@=<?=$idp;?>" >+ Asignar Gastos</a></small>
</div>
</div>
</div>





<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="./ajax.js"></script>

<script>
    
    function eliminar(id){  

        fetch(`delete.php?id=${id}`, {method: 'GET'})

        window.location.reload()

    }

</script>


</body>
</html>