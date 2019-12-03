<?php 
/* 
	Funciones de Ayuda, 
	Armando Rojas <rojasarmando260@gmail.com> 
	github: @mrrojas  
*/


?>

<?php if($opcion == 'panel' ): ?>
<span class="btn btn-sm border rounded-pill"><i class="fas fa-bars"></i> Panel</span>
<?php else: ?>
<a class="btn btn-sm border rounded-pill" <?=  "href='". incluir_file_var("inicio.php" , array('control' => 's' )) ."'"  ?> ><i class="fas fa-bars"></i> Panel</a>
<?php endif ?>




<div class="btn-group">

<?php Helpers::validaPermiso($opcion);  ?>
<div class="dropdown">
<button class="btn btn-light dropdown-toggle btn-sm rounded-pill text-white" style="background-color: #ff9900; border: 1px solid #ff9900;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<i class="far fa-file-alt"></i> Agregar
</button>
<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<a class="dropdown-item" <?=  "href='". incluir_file_var("new/project_name/index.php" , array('control' => 's' )) ."'"  ?> >Registrar Titulo de Proyecto</a>
<a class="dropdown-item"   <?=  "href='". incluir_file_var("new/project/index.php" , array('control' => 's' )) ."'"  ?>   >Nuevo Proyecto</a>
<a class="dropdown-item" <?=  "href='". incluir_file_var("new/client/index.php" , array('control' => 's' )) ."'"  ?>  >Nuevo Cliente</a>
<a class="dropdown-item" <?=  "href='". incluir_file_var("new/recurso/index.php" , array('control' => 's' )) ."'"  ?> >Nuevo Recurso</a>
<a class="dropdown-item" <?=  "href='". incluir_file_var("new/expense/index.php" , array('control' => 's' )) ."'"  ?>>Categoria Gastos</a>
</div>
</div>
</div>


<?php if($opcion == 'setting' ): ?>
<span class="btn btn-sm border rounded-pill" ><i class="fas fa-cog"></i> Lista de Usuarios</span>
<?php elseif ($opcion == 'ressource'): ?>
<span></span>
<?php else: ?>
<a class="btn btn-sm border rounded-pill" <?=  "href='". incluir_file_var("setting/index.php" , array('control' => 's' )) ."'"  ?> ><i class="fas fa-cog"></i> Lista de Usuarios</a>
<?php endif ?>






<a class="btn btn-sm border rounded-pill" <?=  "href='". incluir_file_var('out/index.php' , array('control' => 's' )) ."'"  ?> ><i class="fas fa-sign-out-alt"></i> LogOut</a>

</div>
<div class="col-sm-12 col-md-4 mt-4 mb-4 text-capitalize">
<div class="text-right">
<span class="btn btn-success btn-sm rounded-pill" style="background-color: #6FCD17; font-weight: bold; border: 1px solid #6FCD17;">
<?php if($_SESSION['rol'] == '1') { ?>
Admin
<?php } else { ?>
GSP
<?php } ?>
</span>
<span class="btn btn-outline-light text-muted btn-sm rounded-pill" style="background-color: #fff; font-weight: bold; border: 1px solid #fff;">
<?=$_SESSION['usuario'];?>
</span>