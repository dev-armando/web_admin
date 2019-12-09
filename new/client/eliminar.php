<?php

ini_set("display_errors" , "On");
session_start();
if($_SESSION['logueado'] != "SI"){
header('location: sign-in');
exit();
}

include '../../crm/connect.php';



	$add = $conn->prepare("DELETE FROM  clientes WHERE id = :id ");
	$add->bindValue(':id', $_GET['id']);
	$add->execute();

	header('location: index.php');


?>

