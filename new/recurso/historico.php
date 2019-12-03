<?php
session_start();
if($_SESSION['logueado'] != "SI"){
header('location: sign-in');
exit();
}

include '../../crm/connect.php';


$user = $_SESSION['usuario'];

$userl = $conn->query("SELECT * FROM usuario WHERE nombre = '".$user."'");

$row_u = $userl->fetch();


if( isset( $_POST['cancelar'] )  ){  header("location:index.php"); }

incluir_file_var("modelo/recursos.php");
$modelo = new Recursos($conn); 


$id = base64_decode($_GET['id']); 


$valor_historico = $conn->query("SELECT * from recurso_hora WHERE id_recurso = ".$id." ");




$data = $modelo->getRecursoByID( $id ); 

$valor_hora = $modelo->getHoraValorByID($id); 

if( isset( $_POST['edd'] )  ){



	if( !empty($_POST['rpass']) ) {
			extract($_POST);
		
			$modelo->update( array(
				'id'=> $id ,
				'status' =>  $status ,
				'rpass'   => $rpass ,
				'rnombre'   => $rnombre ,
				'rcorreo'  => $rcorreo,
				'rvhora'  => $_POST['rvhora'],
				)); 


		echo '<div class="mb-3">El recurso se edito correctamente</div>';
		$modelo->updateValorHoraID($id , $_POST['rvhora']) ;

		Helpers::refreshPage();


	} else {
		echo 'Error';
	}
}



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
<h2 class="mb-4">
<a class="navbar-brand js-scroll-trigger" href="#page-top">
<img class="rounded-circle" src="../../image/manager512x512.png" width="44"> Manager <span class="text-muted small">beta</span>
</a>
</h2>

<?php incluir_file_var('include/menu.php' , array('opcion' => 'recurso' ) ) ?>


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
<div class="row">
<div class="col-sm-12 col-md-8 mt-4 mb-4">
<div class="p-4 bg-white">
<h5>Consultar Recurso</h5>
<p class="mt-4">

<form action="" method="POST">
<div class="form-row">
<div class="form-group col-md-8">
<input  <?= Helpers::addValue($data['rnombre'])  ?> type="text" name="rnombre" class="form-control" placeholder="Nombre (max 40 car)" maxlength="40">
</div>


<div class="form-group col-md-8">
<input disabled <?= Helpers::addValue($data['rusuario'])  ?>  type="text" name="rusuario" class="form-control" placeholder="Nombre de usuario (max 40 car)" maxlength="40">
</div>



<div class="form-group col-md-4">
<select name="cate" class="form-control" style="display:none" disabled="" >
<option>Categoria</option>
<option value="1">Administrador</option>
<option value="2">GPC</option>
</select>
</div>
</div>


<div class="form-group col-md-4">
<select name="status" class="form-control"  >

<option  <?= Helpers::selectOption( $data['status']  , '1') ?> value="1">Activo</option>
<option  <?= Helpers::selectOption( $data['status']  , '0') ?> value="0">Desactivado</option>
</select>
</div>




<div class="form-group">  <label for="">  Valor por Hora Actual  </label>  </div>


<div class="form-group"><input <?= Helpers::addValue($data['rvhora'])  ?>  type="text" name="rvhora" class="form-control" placeholder="Valor por Hora"></div>


<?php while($row_vhs =  $valor_historico->fetch() ): ?>


<div class="form-group">  <label >  Valor por Hora Anterior  </label>  </div>


<div class="form-group"><input <?= Helpers::addValue($row_vhs['v_hora'])  ?>  type="text" name="rvhora_a" class="form-control" placeholder="Valor por Hora"></div>

<?php endwhile ?>










<button onclick="window.history.back()"  class="btn btn-danger btn-sm">Regresar</button>
</form>
</p>
</div>
</div>

<div class="col-sm-12 col-md-4 mt-4 mb-4">
<div class="p-4 bg-white">
<p>Lista de Usuarios</p>
<hr>
<?php
$glist = $conn->query("SELECT * FROM recurso");
while ($fila = $glist->fetch()) {
?>

<p>
<span class="text-capitalize"><?=$fila['rnombre'];?></span> <span class="text-muted"><?=$fila['rusuario'];?> </span><br>
<a title="Editar"  <?= Helpers::addHrefID( 'editar.php', $fila['id']) ?> ><i class="far fa-edit"></i></a>
<a title="Consultar"  <?= Helpers::addHrefID( 'consultar.php', $fila['id']) ?> ><i class="fa fa-search"></i></a>
<a title="Historico" <?= Helpers::addHrefID( 'historico.php', $fila['id']) ?> ><i class="fa fa-book"></i></a>

<span class="text-muted"><?=$fila['rcorreo'];?></span>

</p>
<?php

}
?>
</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
	$(document).ready(function() {
		$("input").attr('disabled', 'disabled');
		$("select").attr('disabled', 'disabled');
	});
</script>

</body>
</html>