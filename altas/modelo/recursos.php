<?php 
/* 
	Funciones de Ayuda, 
	Armando Rojas <rojasarmando260@gmail.com> 
	github: @mrrojas  
*/

	ini_set('display_errors', 'On');

class Recursos
{
	private $conn;

	function __construct($conn)
	{
		$this->conn = $conn;	
	}

	public function updateValorHora($username , $valorHora){
		$conn = $this->conn ;
		$userID = $this->getRecursoID($username);

		$add = $conn->prepare("UPDATE recurso_hora set status = '0' where id_recurso =  :id ");
		$add->bindValue(':id', $userID );
		$add->execute();

		$add = $conn->prepare("INSERT INTO recurso_hora (id_recurso, v_hora ) VALUES (:id , :hora) ");
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


	public function update($array = array() , $control =  '0' ){
		extract($array); 

		if($control == '0')
			$rpass = md5($rpass);
	
		$conn = $this->conn ;


		$add = $conn->prepare("UPDATE recurso set status = :status , 
								  rpass = :rpass , 
								  rnombre = :rnombre ,
								  rcorreo = :rcorreo,
								  rvhora = :rvhora
								  where id =  :id 
								 ");

		$add->bindValue(':id', $id );
		$add->bindValue(':status', $status );
		$add->bindValue(':rpass', $rpass );
		$add->bindValue(':rnombre', $rnombre );
		$add->bindValue(':rcorreo', $rcorreo );
		$add->bindValue(':rvhora', $rvhora );
		$add->execute();

	}

	public function getRecursoID($username){
		$conn = $this->conn;
		$userl = $conn->query("SELECT * FROM recurso WHERE rusuario = '".$username."'");
		return $userl->fetch()['id'];
	}

	public function getRecursoByID($id){
		$conn = $this->conn;
		$userl = $conn->query("SELECT * FROM recurso WHERE id = $id ");

		return $userl->fetch();
	}

	public function getHoraValorByID($id){
		$conn = $this->conn;
		$userl = $conn->query("SELECT * FROM recurso_hora WHERE id_recurso = $id and status = '1' ");

		return $userl->fetch()['id'];
	}

	public function getHorasAsignadas($id_recurso , $id_proyecto){

		$conn = $this->conn;
		$userl = $conn->query("SELECT sum(hhoras) total FROM `recpro`  where  idrecc = $id_recurso and idproj = $id_proyecto ");

		return $userl->fetch()['total'];
	}


	public function getHorasConsumidas($id_recurso , $id_proyecto){

		$conn = $this->conn;
		$userl = $conn->query("SELECT sum(totalh) as total FROM `horaspro`  where idrecurso = $id_recurso and idpro = $id_proyecto ");

		return $userl->fetch()['total'];
	}





}
// ----------------------------------------------

 ?>