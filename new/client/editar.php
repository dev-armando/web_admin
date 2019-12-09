<?php
ini_set("display_errors" , "On");
 
ini_set('upload_tmp_dir', __DIR__); 

session_start();
if($_SESSION['logueado'] != "SI"){
header('location: sign-in');
exit();
}

include '../../crm/connect.php';



$user = $_SESSION['usuario'];
// User
$userl = $conn->query("SELECT * FROM usuario WHERE nombre = '".$user."'");
$row_u = $userl->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

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
<div class="col-md-6">
<div class="p-3 bg-white">
<h4>Editar Cliente</h4>
<p class="mt-4">
<?php

$id_client = base64_decode($_GET['id']);

if(isset($_POST['down'])){
    
    echo "<script>  window.location.href = 'http://ch.akirawebandmarketing.com.ar/new/client/test.xls'  </script>";
}

if(isset($_POST['add'])){
	if(!empty($_POST['crazon'])){
		$add = $conn->prepare("INSERT INTO clientes (crazonsocial) VALUES (:crazonsocial)");
		$add->bindValue(':crazonsocial', $_POST['crazon']);
		$add->execute();

		//header('location: ../me');
		echo '<div class="mb-3">El cliente se agreg&oacute; correctamente</div>';
	} else {
		echo 'Error';
	}
}

else if(isset($_POST['edit'])){

	if(!empty($_POST['crazon'])){

	
		
		$add = $conn->prepare("UPDATE clientes SET crazonsocial = :crazonsocial WHERE id = :id ");
		$add->bindValue(':crazonsocial', $_POST['crazon']);
		$add->bindValue(':id', $id_client );
		$add->execute();

		//header('location: ../me');
		echo '<div class="mb-3">El cliente se Modifico Correctamente</div>';
	} else {
		echo 'Error';
	}
}

else if(isset($_POST['back'])){

	header('location: index.php');
	
}

else if(isset($_POST['up'])){

   
	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $_FILES['uploadedfile']['name'])) {

		require_once '../../include/phpexcel/PHPExcel/IOFactory.php' ;
			$inputFileType = PHPExcel_IOFactory::identify($_FILES['uploadedfile']['name']);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($_FILES['uploadedfile']['name']);
	
			$sheet = $objPHPExcel->getSheet(0); 
			
		
			$highestRow = $sheet->getHighestRow(); 
				
			$highestColumn = $sheet->getHighestColumn();
	 
			
			for ($row = 1; $row <= $highestRow; $row++){ 
				$nombreCliente = $sheet->getCell("A".$row)->getValue();
					
				
					$add = $conn->prepare("INSERT INTO clientes (crazonsocial) VALUES (:crazonsocial)");
					$add->bindValue(':crazonsocial', $nombreCliente );
					$add->execute();
				
			}

			 echo "<script>  window.location.href = 'http://ch.akirawebandmarketing.com.ar/index.php' </script>";
	   
	} else{
	    echo "Ha ocurrido un error, trate de nuevo!";
}
}





$cliente = $conn->query("SELECT * FROM clientes where id = $id_client ");


$cliente = $cliente->fetch(); 

?>
<form action="" method="POST">
<div class="form-group">


<input  <?= "value='".$cliente['crazonsocial']."'" ?>   type="text" name="crazon" class="form-control" placeholder="Raz&oacute;n Social (max 40 car)">
</div>
<button name="edit" class="btn btn-primary btn-sm">Editar Cliente</button>

<button name="back" class="btn btn-danger btn-sm">Regresar</button>


</form>
<br>

</p>
</div>
</div>

<div class="col-md-6">
<div class="p-3 bg-white">
<h5>Clientes</h5>
<hr>
<?php
$rlast = $conn->query("SELECT distinct c.* , IF(p.idp is null , '1' , '0') sin_proyecto FROM clientes as c LEFT JOIN proyectos as p ON p.pcliente = c.crazonsocial ORDER BY crazonsocial ASC");
while ($last = $rlast->fetch()) {
?>
<p>


<?=$last['crazonsocial'];?>
<a style="margin-left: 5px" title="Editar"  <?= Helpers::addHrefID( 'editar.php', $last['id']) ?> ><i class="far fa-edit"></i>
</a>

<?php if ($last['sin_proyecto']): ?>
<a style="margin-left: 5px" title="Eliminar"  onclick="return btnBorrar( <?= "'" .$last['id'] . "'" ?> , <?= "'" .$last['crazonsocial'] . "'" ?>    )"  ><i class="fa fa-minus"></i>
</a>
<?php endif ?>



</p>
<?php } ?>
</div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


<script type="text/javascript">
	
	function btnBorrar(id , cliente){

		let confirmacion = confirm(`¿Estas seguro de eliminar el cliente ${cliente} ?`)

		if(confirmacion){
			window.location.href = `eliminar.php?id=${id}`
		}
	}

</script>



</body>
</html>