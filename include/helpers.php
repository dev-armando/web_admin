<?php /* 
	Funciones de Ayuda, 
	Armando Rojas <rojasarmando260@gmail.com> 
	github: @mrrojas  
*/
class Helpers{

	public static function getRolID(){
		return $_SESSION['rol']; 
	}

	public static function getRolName(){
		
		$name = ""; 

		switch ($_SESSION['rol']) {
			case '1':
				$name = 'Admin';
			break;

			case '2':
				$name = 'GPC';
			break;
			
		}


		return $name;
	}

	public static function getPermisos($ruta){

		$permisos = array(
			'panel' => array( 'Admin' => 'S' , 'GPC' => 'S'  ),
			'listado_de_usuarios' => array( 'Admin' => 'S' , 'GPC' => 'N'  ),
			'setting' => array( 'Admin' => 'S' , 'GPC' => 'N'  ),
			'setting/editar' => array( 'Admin' => 'S' , 'GPC' => 'N'  ),
			'setting/consultar' => array( 'Admin' => 'S' , 'GPC' => 'N'  ),
			'project_name' => array( 'Admin' => 'S' , 'GPC' => 'N'  ),
			'project' => array( 'Admin' => 'S' , 'GPC' => 'S'  ),
			'client' => array( 'Admin' => 'S' , 'GPC' => 'N'  ),
			'recurso' => array( 'Admin' => 'S' , 'GPC' => 'N'  ),
			'recurso/consultar' => array( 'Admin' => 'S' , 'GPC' => 'N'  ),
			'recurso/editar' => array( 'Admin' => 'S' , 'GPC' => 'N'  ),
			'expense' => array( 'Admin' => 'S' , 'GPC' => 'N'  ),
			'0' => array( 'Admin' => 'S' , 'GPC' => 'N'   ),
		);

		return $permisos[$ruta][self::getRolName()];
	}

	public static function validaPermiso($ruta){

		if(self::getPermisos($ruta) == 'N' ) echo "<script> window.history.back() </script>";
	}


	public static function addHrefID($ruta , $id){ 

		$id = $ruta . '?id='.base64_encode($id); 
		return "href='{$id}'";
	}


	public static function selectOption($row , $val){ 

		return ($row == $val) ? 'selected' : '';
	}

	public static function addValue($data){ 

		return "value='$data' ";
	}

	public static function refreshPage(){

		return '<script> setTimeout( () => window.location.reload() , 1000  ) </script>';
	}

	
}

//---------------------------------

?>