<?php
try{
	$pdo = new PDO('mysql:host=localhost;dbname=akiraweb_ch', 'akiraweb_chu19', 'chhoras2019$');
	//$pdo = new PDO('mysql:host=localhost;dbname=manager', 'root', 'tresde0599');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		die("ERROR: Could not connect. " . $e->getMessage());
		}

try{
if(isset($_REQUEST['term'])){
	$sql = "SELECT * FROM proyectos WHERE pdescrip LIKE :term OR pcliente LIKE :term OR pdesde LIKE :term OR phasta LIKE :term";
	$stmt = $pdo->prepare($sql);
	$term = $_REQUEST['term'] . '%';
	$stmt->bindParam(':term', $term);
	$stmt->execute();

if($stmt->rowCount() > 0){
	while($row = $stmt->fetch()){
	$id = $row['idp'];
?>

<div class="card mt-4">
<div class="card-body">
<div class="d-flex w-100 justify-content-between">
<h6 class="mb-1"><a href="#"><?=$row['pcliente'];?></a></h6>
<small class="text-muted">Creado el d&iacute;a <?=$row['pfecha'];?></small>
</div>
<h5 class="card-title"><?=$row['pdescrip'];?></h5>
<p class="card-text"><?=$row['pnombre'];?></p>
<p class="card-text">
Horas proyectadas: <?=$row['phorapro'];?>hs.<br>
Horas desarrolladas: 56hs.
</p>
<p class="card-text">
<small class="text-muted">
Inicio <?php
$dfecha = new DateTime($row['pdesde']);
$dfecha_d_m_y = $dfecha->format('d-m-Y');
echo $dfecha_d_m_y;
?>
 - Finalizaci&oacute;n 
<?php
$hfecha = new DateTime($row['phasta']);
$hfecha_d_m_y = $hfecha->format('d-m-Y');
echo $hfecha_d_m_y;
?>
</small>
</p>
<a href="edit?@=<?=$row['idp'];?>" title="Editar"><span><i class="far fa-edit"></i></span></a>
<a href="edit?@=<?=$row['idp'];?>" title="Detalles"><span class="ml-3"><i class="fas fa-sliders-h"></i></span></a>
</div>
</div>

<?php
}
} else{
echo "<p>No matches found</p>";
}
}
} catch(PDOException $e){
die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}
unset($stmt);
unset($pdo);
?>
