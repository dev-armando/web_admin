<?php

header('Content-Type: application/json');

session_start();

include '../crm/connect.php';

if ( $_POST['qa'] ) {
    $qa = $_POST['qa'];
    $userid = $_POST['user_id'];
    $list = $conn->query("SELECT idp, nombre, pdesde, phasta FROM proyectos INNER JOIN recpro ON recpro.idproj = proyectos.idp INNER JOIN recurso ON recpro.idrecc = recurso.id INNER JOIN nombre_proyecto ON proyectos.nombre_proyecto_id = nombre_proyecto.id WHERE ( (nombre LIKE '%$qa%' OR pcliente LIKE '%$qa%') AND recurso.id = '".$userid."' ) ORDER BY idp DESC");

    return print_r(json_encode($list->fetchAll(PDO::FETCH_ASSOC)));
}

if ( $_POST['from-date'] or $_POST['to-date'] ) {
    $fromDate = Date($_POST['from-date']);
    $toDate = Date($_POST['to-date']);
    $userid = $_POST['user_id'];
    $list = $conn->query("SELECT idp, nombre, pdesde, phasta FROM proyectos INNER JOIN recpro ON recpro.idproj = proyectos.idp INNER JOIN recurso ON recpro.idrecc = recurso.id INNER JOIN nombre_proyecto ON proyectos.nombre_proyecto_id = nombre_proyecto.id WHERE ( DATE(pdesde) BETWEEN '$fromDate' AND '$toDate' ) AND recurso.id = '".$userid."' ORDER BY idp DESC");
    return print_r(json_encode($list->fetchAll(PDO::FETCH_ASSOC)));
}

$userid = $_GET['user_id'];

if(  isset($_SESSION['usuario_adm'] ) and $_SESSION['rol'] == '1' ){

$user = $_SESSION['usuario'];

$list = $conn->query("SELECT
	idp,
	nombre,
	pcliente,
	pdesde,
	phasta,
	recurso.rusuario,
IF
	( '$user' = recurso.rusuario, 'S', 'N' ) as ADM FROM  proyectos
	left JOIN recpro ON recpro.idproj = proyectos.idp
	LEFT JOIN recurso ON recpro.idrecc = recurso.id
	LEFT JOIN nombre_proyecto ON proyectos.nombre_proyecto_id = nombre_proyecto.id  ");


}

else {
$list = $conn->query("SELECT idp, nombre, pcliente, pdesde, phasta FROM proyectos INNER JOIN recpro ON recpro.idproj = proyectos.idp INNER JOIN recurso ON recpro.idrecc = recurso.id INNER JOIN nombre_proyecto ON proyectos.nombre_proyecto_id = nombre_proyecto.id WHERE recurso.id = '".$userid."'");
}



return print_r(json_encode($list->fetchAll(PDO::FETCH_ASSOC)));