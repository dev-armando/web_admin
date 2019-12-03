<?php
try{
	$pdo = new PDO('mysql:host=localhost;dbname=akiraweb_ch', 'akiraweb_chu19', 'sebastian2019$');
	//$pdo = new PDO('mysql:host=localhost;dbname=manager', 'root', 'tresde0599');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		die("ERROR: Could not connect. " . $e->getMessage());
		}

try{
if(isset($_REQUEST['term'])){
	$sql = "SELECT * FROM recurso WHERE rnombre LIKE :term";
	$stmt = $pdo->prepare($sql);
	$term = $_REQUEST['term'] . '%';
	$stmt->bindParam(':term', $term);
	$stmt->execute();

if($stmt->rowCount() > 0){
	while($srow = $stmt->fetch()){
	//$id = $srow['id'];
?>
<p><?=$srow['rnombre'];?> #<input style="border: none;" type="text" name="recc" value="<?=$srow['id'];?>"></p>
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