<?php
try {
	//$conn = new PDO('mysql:host=localhost;dbname=manager', 'root', 'tresde0599');
	$conn = new PDO('mysql:host=localhost;dbname=akiraweb_ch', 'akiraweb_chu19', 'chhoras2019$');
//	$conn = new PDO('mysql:host=localhost;dbname=test', 'root', '26059573Ar*');
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
	catch(PDOException $e){
		echo "ERROR: " . $e->getMessage();
}


date_default_timezone_set('America/Argentina/Buenos_Aires');

function incluir_file_var($file , $data = array()){
	extract($data);

	$control = empty($control) ? 'n' : $control; 

	if($control == 'n') {
		if( file_exists($file) ) include($file);
		else if( file_exists('../' . $file) ) include('../' . $file);
		else if( file_exists('../../' . $file) ) include('../../' . $file);
		else if( file_exists('../../../' . $file) ) include('../../../' . $file);
		else if( file_exists('../../../../' . $file) ) include('../../../../' . $file);
		else if( file_exists('../../../../../' . $file) ) include('../../../../../' . $file);
	}else{

		if( file_exists($file) ) return $file;
		else if( file_exists('../' . $file) ) return '../' . $file;
		else if( file_exists('../../' . $file) ) return '../../' . $file;
		else if( file_exists('../../../' . $file) ) return '../../../' . $file;
		else if( file_exists('../../../../' . $file) ) return '../../../../' . $file;
		else if( file_exists('../../../../../' . $file) ) return '../../../../../' . $file;
	}
}

incluir_file_var('include/helpers.php' );

?>