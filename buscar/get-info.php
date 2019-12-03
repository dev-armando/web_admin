<?php

header('Content-Type: application/json');

include '../crm/connect.php';

if ( $_POST['qa'] ) {
    $qa = $_POST['qa'];
    $list = $conn->query("SELECT idp, nombre, pcliente, pestado, pdesde, phasta FROM proyectos JOIN nombre_proyecto ON proyectos.nombre_proyecto_id = nombre_proyecto.id WHERE (nombre LIKE '%$qa%' OR pcliente LIKE '%$qa%') ORDER BY idp DESC");

    return print_r(json_encode($list->fetchAll(PDO::FETCH_ASSOC)));
}

if ( $_POST['from-date'] or $_POST['to-date'] ) {
    $fromDate = Date($_POST['from-date']);
    $toDate = Date($_POST['to-date']);
    $list = $conn->query("SELECT idp, nombre, pcliente, pestado, pdesde, phasta FROM proyectos JOIN nombre_proyecto ON proyectos.nombre_proyecto_id = nombre_proyecto.id WHERE (DATE(pdesde) BETWEEN '$fromDate' AND '$toDate') ORDER BY idp DESC");
    return print_r(json_encode($list->fetchAll(PDO::FETCH_ASSOC)));
}

$list = $conn->query("SELECT idp, nombre, pcliente, pestado, pdesde, phasta FROM proyectos JOIN nombre_proyecto ON proyectos.nombre_proyecto_id = nombre_proyecto.id ORDER BY idp DESC");
return print_r(json_encode($list->fetchAll(PDO::FETCH_ASSOC)));