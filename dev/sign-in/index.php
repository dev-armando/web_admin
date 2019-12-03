<?php
session_start();

include '../../crm/connect.php';

if(isset($_POST['login'])){
    if(!empty($_POST['user']) && !empty($_POST['pass'])){
       $stmt = $conn->prepare("SELECT * FROM recurso WHERE rusuario=:user AND rpass=:pass and status = '1' ");
       $stmt->execute(array(':user'=>$_POST['user'], ':pass'=>md5($_POST['pass'])));
       $fila = $stmt->fetch();       
            if($fila > 0){
             $_SESSION['logueado'] = "SI";
             $_SESSION['usuario']  = $fila['rusuario'];
             header('location: ../');
            } else {
                echo '<div class="error">Account not found. Please check your username and password and try again.</div>';
            }
    }
}  
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Manager - Sign in</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
<div class="p-3">
<div class="container">
<img class="rounded-circle" src="../../image/manager512x512.png" alt="Manager" width="44">
<span class="h5 ml-4">Manager</span>
</div>
</div>

<div class="bg-dark p-5">
<div class="container">
<div class="row">
<div class="col-sm-12 col-md-7">
<div class="p-3">
<div class="display-4 text-white">Sistema de trabajo</div>
<h4 class="text-white-50 text-wrap mt-4">
Manager.
</h4>
</div>
</div>

<div class="col-sm-12 col-md-5">
<div class="bg-white rounded">
<div class="p-3">
<h4 class="mt-2">Sign In</h4>
<p>
<form action="" method="post">
<div class="form-group">
<label for="inputUser">Usuario</label>
<input name="user" type="text" id="inputUser" class="form-control" required>
</div>
<div class="form-group">
<label for="inputPassword">Contrase&ntilde;a</label>
<input name="pass" type="password" id="inputPassword" class="form-control" required>
</div>
<button name="login" class="btn btn-primary mt-4" type="submit">Sign in</button>
</form>
</p>
<p>Ingreso para usuarios <a href="../../sign-in">Sign In</a></p>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="container">
<div class="mt-4">
<p>Manager v1.0</p>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>