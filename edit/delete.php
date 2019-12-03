<?php 

	

		extract($_GET);

		include '../crm/connect.php';

		$add = $conn->prepare("DELETE FROM gastos_proyectos WHERE id = :id ");
		$add->bindValue(':id', $id );
		$add->execute();



 ?>