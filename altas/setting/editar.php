<?php
ini_set('display_erros', 'On');
session_start();
if($_SESSION['logueado'] != "SI"){
header('location: sign-in');
exit();
}

include '../crm/connect.php';

Helpers::validaPermiso('setting/editar');

if( isset( $_POST['cancelar'] )  ){  header("location:index.php"); }

incluir_file_var("modelo/usuarios.php");
$modelo = new Usuarios($conn); 



$user = $_SESSION['usuario'];
// User
$userl = $conn->query("SELECT * FROM usuario WHERE nombre = '".$user."'");
$row_u = $userl->fetch();

$id = base64_decode($_GET['id']); 

$data = $modelo->getUsuarioByID( $id ); 

$valor_hora = $modelo->getHoraValorByID($id)['v_hora']; 

if( isset( $_POST['add'] )  ){


	if( !empty($_POST['pass']) && !empty($_POST['cate']) && !empty($_POST['email']) && !empty($_POST['v_hora']) ){
			extract($_POST);
		
			$modelo->update( array(
				'id'=> $id ,
				'status' => $status ,
				'pass'   => $pass ,
				'cate'   => $cate ,
				'email'  => $email
				)); 


		echo '<div class="mb-3">El recurso se edito correctamente</div>';
		Helpers::refreshPage();

		$modelo->updateValorHoraID($id , $_POST['v_hora']) ;

	} else {
		echo 'Error';
	}
}

?>

<script >   </script>
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

<?php incluir_file_var('include/menu.php' , array('opcion' => 'setting' ) ) ?>

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
<div class="row">
<div class="col-sm-12 col-md-8 mt-4 mb-4">
<div class="p-4 bg-white">
<h5>Editar usuario</h5>

<form action="" method="POST">
<div class="form-row">
<div class="form-group col-md-8">
<input disabled  <?= Helpers::addValue($data['nombre'])  ?> type="text" name="nombre" class="form-control" placeholder="Nombre de usuario (max 40 car)" maxlength="40">
</div>

<div class="form-group col-md-4">
<select name="cate" class="form-control">
<option>Categoria</option>
<option <?= Helpers::selectOption( $data['cate']  , '1') ?>  value="1">Administrador</option>
<option <?= Helpers::selectOption( $data['cate']  , '2') ?> value="2">GPC</option>
</select>
</div>
</div>

<div class="form-group"><input type="password" name="pass" class="form-control" placeholder="Contrase&ntilde;a"></div>
<div class="form-group"><input <?= Helpers::addValue($data['email'])  ?> type="text" name="email" class="form-control" placeholder="Email"></div>

<div class="form-group"><input <?= Helpers::addValue($valor_hora)  ?> type="text" name="v_hora" class="form-control" placeholder="Valor por Hora"></div>


<div class="form-group col-md-4">
<select name="status" class="form-control">
<option <?= Helpers::selectOption( $data['status']  , '1') ?>  value="1">Activo</option>
<option <?= Helpers::selectOption( $data['status']  , '0') ?> value="0">Inactivo</option>
</select>
</div>


<button name="add" class="btn btn-primary btn-sm">Agregar</button>
<button name="cancelar"   class="btn btn-danger btn-sm">Cancelar</button>
</form>
</p>
</div>
</div>

<div class="col-sm-12 col-md-4 mt-4 mb-4">
<div class="p-4 bg-white">
<p>Lista de usarios</p>
<hr>
<?php
$glist = $conn->query("SELECT * FROM usuario");
while ($fila = $glist->fetch()) {
?>
<?php
if($fila['cate'] == '1') {
?>
<p>
<span class="text-capitalize"><?=$fila['nombre'];?></span> <span class="text-muted">(Admin)</span><br>
<a <?= Helpers::addHrefID( 'editar.php', $fila['id']) ?> ><i class="far fa-edit"></i></a>
<a <?= Helpers::addHrefID( 'consultar.php', $fila['id']) ?> ><i class="far fa-search"></i></a>

<span class="text-muted"><?=$fila['email'];?></span>

</p>
<?php
} else {
?>
<p>
<span class="text-capitalize"><?=$fila['nombre'];?></span> <span class="text-muted">(GPC)</span><br>
<a <?= Helpers::addHrefID( 'editar.php', $fila['id']) ?> ><i class="far fa-edit"></i></a>
<a <?= Helpers::addHrefID( 'consultar.php', $fila['id']) ?> ><i class="far fa-search"></i></a>
<span class="text-muted"><?=$fila['email'];?></span>
</p>
<?php
}
}
?>
</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>