<?php 
/* 
	Funciones de Ayuda, 
	Armando Rojas <rojasarmando260@gmail.com> 
	github: @mrrojas  
*/

class Usuarios
{
	private $conn;

	function __construct($conn)
	{
		$this->conn = $conn;	
	}

	public function updateValorHora($username , $valorHora){
		$conn = $this->conn ;
		$userID = $this->getUsuarioID($username);

		$add = $conn->prepare("UPDATE usuario_hora set status = '0' where id_usuario =  :id ");
		$add->bindValue(':id', $userID );
		$add->execute();

		$add = $conn->prepare("INSERT INTO usuario_hora (id_usuario , v_hora ) VALUES (:id , :hora) ");
		$add->bindValue(':id', $userID );
		$add->bindValue(':hora', $valorHora );
		$add->execute();

	}

	public function updateValorHoraID($ID , $valorHora){
		$conn = $this->conn ;
		$userID = $ID;

		$add = $conn->prepare("UPDATE usuario_hora set status = '0' where id_usuario =  :id ");
		$add->bindValue(':id', $userID );
		$add->execute();

		$add = $conn->prepare("INSERT INTO usuario_hora (id_usuario , v_hora ) VALUES (:id , :hora) ");
		$add->bindValue(':id', $userID );
		$add->bindValue(':hora', $valorHora );
		$add->execute();

	}


	public function update($array = array()){
		extract($array); 

		$pass = md5($pass); 

		$conn = $this->conn ;


		$add = $conn->prepare("UPDATE usuario set status = :status , 
								  pass = :pass , 
								  cate = :cate ,
								  email = :email
								  where id =  :id 
								 ");

		$add->bindValue(':id', $id );
		$add->bindValue(':status', $status );
		$add->bindValue(':pass', $pass );
		$add->bindValue(':cate', $cate );
		$add->bindValue(':email', $email );
		$add->execute();

	}

	public function getUsuarioID($username){
		$conn = $this->conn;
		$userl = $conn->query("SELECT * FROM usuario WHERE nombre = '".$username."'");
		return $userl->fetch()['id'];
	}

	public function getUsuarioByID($id){
		$conn = $this->conn;
		$userl = $conn->query("SELECT * FROM usuario WHERE id = $id ");

		return $userl->fetch();
	}

	public function getHoraValorByID($id){
		$conn = $this->conn;
		$userl = $conn->query("SELECT * FROM usuario_hora WHERE id_usuario = $id and status = '1' ");

		return $userl->fetch();
	}




}
// ----------------------------------------------

 ?>