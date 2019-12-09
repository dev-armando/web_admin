<?php



ini_set('display_errors' , 'On');



session_start();



require_once '../include/phpexcel/PHPExcel/IOFactory.php' ;

include '../crm/connect.php';



 

class Reportes 

{



    private $conn;

    // imprimir reporte de la data de los estudiantes en excel 

    public function reporte($data = array()  ){







        date_default_timezone_set('Europe/London');



        $objReader = \PHPExcel_IOFactory::createReader('Excel5');

        $objPHPExcel = $objReader->load("../include/phpexcel/modelo.xls");



         $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Titulo ');

         $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Descripcion');

         $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Fecha');

         $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Horas Cargadas');

         $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Fecha de Creacion');

         $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Usuario');

         

        $baseRow = 2;



       foreach($data as $r => $dataRow) {

            $row = $baseRow + $r;

    

            extract($dataRow);

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $titulo)

                                   ->setCellValue('B'.$row,  $pdescrip    )

                                   ->setCellValue('F'.$row,  $usuario    )

                                ->setCellValue('C'.$row, $fecha )

                                ->setCellValue('D'.$row,  $total_horas )

                                ->setCellValue('E'.$row,  $fecha_cre );



        }



 

    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');



      // Redirect output to a client’s web browser (Excel5)

    header('Content-Type: application/vnd.ms-excel');

    header('Content-Disposition: attachment;filename="reporte_recurso.xls"');

    header('Cache-Control: max-age=0');

    // If you're serving to IE 9, then the following may be needed

    header('Cache-Control: max-age=1');



    // If you're serving to IE over SSL, then the following may be needed

    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past

    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified

    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1

    header ('Pragma: public'); // HTTP/1.0





    $objWriter->save('php://output');

    exit;

    }



    public function __construct($conn){



        $this->conn = $conn; 

    }





    public function reporte_consulta(){

        

         $conn = $this->conn;

        $row = array(); 

        $i = 0 ; 

        $idp = $_GET['idp'];

        $user = $this->getRecurso()['rusuario']; 



        $glist = $conn->query("SELECT * from reporte_horas where usuario = '$user' and id_proyecto = $idp   ");



        while ($fila = $glist->fetch())  $row[$i++] = $fila;



        return $row;



    }





    public function reporte_consulta_all(){

        

         $conn = $this->conn;

        $row = array(); 

        $i = 0 ; 

        $idp = $_GET['idp'];

        $user = $this->getRecurso()['rusuario']; 


        $glist = $conn->query("SELECT * from reporte_horas where  id_proyecto = $idp   ");


        while ($fila = $glist->fetch())  $row[$i++] = $fila


        return $row;

    }


    public function reporte_consulta_masiva($data = array()){

        extract($data); 

         $conn = $this->conn;

        $row = array(); 

        $i = 0 ; 

        $idp = $_GET['idp'];

        $user = $this->getRecurso()['rusuario']; 


        $glist = $conn->query("SELECT * from reporte_horas where  id_proyecto = $idp   ");


        while ($fila = $glist->fetch())  $row[$i++] = $fila


        return $row;

    }



    public function getRecurso(){



        $conn = $this->conn;

        $user = $_SESSION['usuario'];

        // User

        $userl = $conn->query("SELECT * FROM recurso WHERE rusuario = '".$user."'");

        $row_u = $userl->fetch();



       return $row_u;

    }



    public function getRecursoProyecto(){



        $conn = $this->conn;

        $idp = $_GET['idp'];



        $pro = $conn->query("SELECT * FROM proyectos WHERE idp = '".$idp."'");

        return  $pro->fetch();

    }





    public function getRecursoProyectoTitulo(){



        $conn = $this->conn;

        $idp = $_GET['idp'];



        $pro = $conn->query("SELECT * FROM nombre_proyecto WHERE id = ".$this->getRecursoProyecto()['nombre_proyecto_id'] );

        return  $pro->fetch()['nombre'];

    }



    public function getHorasProyectoRecurso(){



        $conn = $this->conn;

        $row = array(); 

        $i = 0 ; 

        $idp = $_GET['idp'];

        $userid = $this->getRecurso()['id']; 



        $glist = $conn->query("SELECT * FROM horaspro WHERE idrecurso = '".$userid."' AND idpro = '".$idp."' ORDER BY idh DESC");



        while ($fila = $glist->fetch())  $row[$i++] = $fila;



        return $row;

    }

  

}





$reporte = new Reportes($conn);





extract($_GET); 


if(isset($reporteMasivo)){

    //reporte masivo 


}
else if(  isset($_SESSION['usuario_adm'] ) and ($_SESSION['rol'] == '1' or $_SESSION['rol'] == '2' ) ){



    // reporte 3

     $data = $reporte->reporte_consulta_all();

    $reporte->reporte($data);   

}

else{



    // reporte 1

    $data = $reporte->reporte_consulta();

    $reporte->reporte($data);    

}





