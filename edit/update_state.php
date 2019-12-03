<?php

header('Content-Type: application/json');

include '../crm/connect.php';

$state = $_POST['state'];
$id = $_POST['id'];
if ($conn->query("UPDATE proyectos SET pestado = '$state' WHERE idp = '$id'")) {
    return print_r( json_encode( array('status' => $state) ) );
}
