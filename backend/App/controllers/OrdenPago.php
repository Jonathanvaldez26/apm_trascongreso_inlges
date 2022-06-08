<?php

namespace App\controllers;

defined("APPPATH") or die("Access denied");
require_once dirname(__DIR__) . '/../public/librerias/fpdf/fpdf.php';

use \Core\View;
use \Core\Controller;
use \App\models\Talleres as TalleresDao;
use \App\models\Transmision as TransmisionDao;
use \App\models\Register as RegisterDao;
use \App\models\Home as HomeDao;

class OrdenPago extends Controller
{

    private $_contenedor;

    function __construct()
    {
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header', $this->_contenedor->header());
        View::set('footer', $this->_contenedor->footer());
    }

    public function getUsuario()
    {
        return $this->__usuario;
    }


    public function Pagar(){
        echo $_POST['costo'];
    }
    
    public function ticketAll($clave = null, $id_curso = null)
    {
        date_default_timezone_set('America/Mexico_City');

        
        $metodo_pago = $_POST['metodo_pago'];
        $user_id = $_SESSION['user_id'];
        $clave = $_POST['clave'];
        $datos_user = RegisterDao::getUser($this->getUsuario())[0];

        $productos = TalleresDao::getCarritoByIdUser($user_id);

        // var_dump($productos);
        // exit;



        foreach($productos as $key => $value){

            if($value['es_congreso'] == 1){
                $precio = $value['amout_due'];
            }else if($value['es_servicio'] == 1){
                $precio = $value['precio_publico'];
            }else if($value['es_curso'] == 1){
                $precio = $value['precio_publico'];
            }
           
            $documento = new \stdClass();  

            $nombre_curso = $value['nombre'];
            $id_producto = $value['id_producto'];
            $user_id = $datos_user['user_id'];
            $reference = $datos_user['reference'];
            $fecha =  date("Y-m-d");
            // $monto = $value['precio_publico'];
            $monto = $precio;
            $tipo_pago = $metodo_pago;
            $status = 0;
    
            $documento->_id_producto = $id_producto;
            $documento->_user_id = $user_id;
            $documento->_reference = $reference;
            $documento->_fecha = $fecha;
            $documento->_monto = $monto;
            $documento->_tipo_pago = $tipo_pago;
            $documento->_clave = $clave;
            $documento->_status = $status;

            $existe = TalleresDao::getProductosPendientesPago($user_id,$id_producto);

            if(!$existe){
                $id = TalleresDao::inserPendientePago($documento); 
                $delete = TalleresDao::deleteItem($value['id_carrito']);
            }
                // $delete = TalleresDao::deleteItem($value['id_carrito']);

        }



        $d = $this->fechaCastellano($fecha);
        
        $nombre_completo = $datos_user['name_user'] . " " . $datos_user['middle_name'] . " " . $datos_user['surname'] . " " . $datos_user['second_surname'];


        $pdf = new \FPDF($orientation = 'P', $unit = 'mm', $format = 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
        $pdf->setY(1);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Image('constancias/plantillas/orden.jpeg', 0, 0, 200, 300);
        // $pdf->SetFont('Arial', 'B', 25);
        // $pdf->Multicell(133, 80, $clave_ticket, 0, 'C');

        $espace = 125;
        $total = array();
        foreach($productos as $key => $value){            
            
            
            if($value['es_congreso'] == 1){
                $precio = $value['amout_due'];
            }else if($value['es_servicio'] == 1){
                $precio = $value['precio_publico'];
            }else if($value['es_curso'] == 1){
                $precio = $value['precio_publico'];
            }

            array_push($total,$precio);

            //Nombre Curso
            $pdf->SetXY(12, $espace);
            $pdf->SetFont('Arial', 'B', 8);  
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Multicell(100, 4, utf8_decode($value['nombre']), 0, 'C');

            //Costo
            $pdf->SetXY(118, $espace);
            $pdf->SetFont('Arial', 'B', 8);  
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Multicell(100, 4, '$ '.$precio.' ' .$value['tipo_moneda'], 0, 'C');

            $espace = $espace + 8;
        }

        //folio
        $pdf->SetXY(118, 42.5);
        $pdf->SetFont('Arial', 'B', 13);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, $reference, 0, 'C');

        //fecha
        $pdf->SetXY(118, 51.5);
        $pdf->SetFont('Arial', 'B', 13);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, $fecha, 0, 'C');

        //total
        // $pdf->SetXY(118, 170);
        // $pdf->SetFont('Arial', 'B', 8);  
        // $pdf->SetTextColor(0, 0, 0);
        // $pdf->Multicell(100, 10, 'TOTAL : '.number_format(array_sum($total),2), 0, 'C');

        $pdf->Output();
        // $pdf->Output('F','constancias/'.$clave.$id_curso.'.pdf');

        // $pdf->Output('F', 'C:/pases_abordar/'. $clave.'.pdf');
    }
    

    public function ordenPago($clave = null, $id_curso = null)
    {
        date_default_timezone_set('America/Mexico_City');

        // $this->generaterQr($clave_ticket);

        $datos_user = RegisterDao::getUser($this->getUsuario())[0];
        $clave = $this->generateRandomString();

        $documento = new \stdClass();  

        $nombre_curso = $_POST['nombre_curso'];
        $id_producto = $_POST['id_producto'];
        $user_id = $datos_user['user_id'];
        $reference = $datos_user['reference'];
        $fecha =  date("Y-m-d");
        $monto = $_POST['costo'];
        $tipo_pago = $_POST['tipo_pago'];
        $status = 0;

        $documento->_id_producto = $id_producto;
        $documento->_user_id = $user_id;
        $documento->_reference = $reference;
        $documento->_clave = $clave;
        $documento->_fecha = $fecha;
        $documento->_monto = $monto;
        $documento->_tipo_pago = $tipo_pago;
        $documento->_status = $status;

        $d = $this->fechaCastellano($fecha);

        // var_dump($documento);
        // exit;

        $existe = TalleresDao::getProductosPendientesPago($user_id,$id_producto);

        if(!$existe){
            $id = TalleresDao::inserPendientePago($documento);   
        }
        $nombre_completo = $datos_user['name_user'] . " " . $datos_user['middle_name'] . " " . $datos_user['surname'] . " " . $datos_user['second_surname'];


        $pdf = new \FPDF($orientation = 'P', $unit = 'mm', $format = 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
        $pdf->setY(1);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Image('constancias/plantillas/orden.jpeg', 0, 0, 200, 300);
        // $pdf->SetFont('Arial', 'B', 25);
        // $pdf->Multicell(133, 80, $clave_ticket, 0, 'C');

        //$pdf->Image('1.png', 1, 0, 190, 190);
        $pdf->SetFont('Arial', 'B', 5);    //Letra Arial, negrita (Bold), tam. 20
        //$nombre = utf8_decode("Jonathan Valdez Martinez");
        //$num_linea =utf8_decode("Línea: 39");
        //$num_linea2 =utf8_decode("Línea: 39");

        //Nombre Curso
        $pdf->SetXY(12, 125);
        $pdf->SetFont('Arial', 'B', 8);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, utf8_decode($nombre_curso), 0, 'C');

        //Costo
        $pdf->SetXY(118, 125);
        $pdf->SetFont('Arial', 'B', 8);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, '$ '.$monto, 0, 'C');

        //folio
        $pdf->SetXY(118, 42.5);
        $pdf->SetFont('Arial', 'B', 13);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, $reference, 0, 'C');

        //fecha
        $pdf->SetXY(118, 51.5);
        $pdf->SetFont('Arial', 'B', 13);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, $fecha, 0, 'C');


        $pdf->Output();
        // $pdf->Output('F','constancias/'.$clave.$id_curso.'.pdf');

        // $pdf->Output('F', 'C:/pases_abordar/'. $clave.'.pdf');
    }



    public function impticket($user_id = null, $id_producto = null)
    {
        date_default_timezone_set('America/Mexico_City');

        // $this->generaterQr($clave_ticket);

        $user_id = base64_decode($user_id);
        $id_producto = base64_decode($id_producto);

        $datos_user = RegisterDao::getUser($this->getUsuario())[0];
        $datos_pendiente_pago = TalleresDao::getProductosPendientesPagoTicket($user_id,$id_producto)[0];



        $documento = new \stdClass();  

        $nombre_curso = $datos_pendiente_pago['nombre'];
        $id_producto = $_POST['id_producto'];
        $user_id = $datos_pendiente_pago['user_id'];
        $reference = $datos_pendiente_pago['reference'];
        $fecha =  $datos_pendiente_pago['fecha'];
        $monto = $datos_pendiente_pago['monto'];
        $tipo_pago = $datos_pendiente_pago['tipo_pago'];
     


        $nombre_completo = $datos_user['name_user'] . " " . $datos_user['middle_name'] . " " . $datos_user['surname'] . " " . $datos_user['second_surname'];


        $pdf = new \FPDF($orientation = 'P', $unit = 'mm', $format = 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
        $pdf->setY(1);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Image('constancias/plantillas/orden.jpeg', 0, 0, 200, 300);
        // $pdf->SetFont('Arial', 'B', 25);
        // $pdf->Multicell(133, 80, $clave_ticket, 0, 'C');

        //$pdf->Image('1.png', 1, 0, 190, 190);
        $pdf->SetFont('Arial', 'B', 5);    //Letra Arial, negrita (Bold), tam. 20
        //$nombre = utf8_decode("Jonathan Valdez Martinez");
        //$num_linea =utf8_decode("Línea: 39");
        //$num_linea2 =utf8_decode("Línea: 39");

        //Nombre Curso
        $pdf->SetXY(12, 125);
        $pdf->SetFont('Arial', 'B', 13);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, utf8_decode($nombre_curso), 0, 'C');

        //Costo
        $pdf->SetXY(118, 125);
        $pdf->SetFont('Arial', 'B', 13);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, '$ '.$monto, 0, 'C');

        //folio
        $pdf->SetXY(118, 42.5);
        $pdf->SetFont('Arial', 'B', 13);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, $reference, 0, 'C');

        //fecha
        $pdf->SetXY(118, 51.5);
        $pdf->SetFont('Arial', 'B', 13);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, $fecha, 0, 'C');


        $pdf->Output();
        // $pdf->Output('F','constancias/'.$clave.$id_curso.'.pdf');

        // $pdf->Output('F', 'C:/pases_abordar/'. $clave.'.pdf');
    }


    // public function PagarPaypal($clave = null, $id_curso = null)
    // {
    //     date_default_timezone_set('America/Mexico_City');

    //     // $this->generaterQr($clave_ticket);

    //     $datos_user = RegisterDao::getUser($this->getUsuario())[0];
    //     $clave = $this->generateRandomString();

    //     $documento = new \stdClass();  

    //     $nombre_curso = $_POST['nombre_curso'];
    //     $id_producto = $_POST['id_producto'];
    //     $user_id = $datos_user['user_id'];
    //     $reference = $datos_user['reference'];
    //     $fecha =  date("Y-m-d");
    //     $monto = $_POST['costo'];
    //     $tipo_pago = $_POST['tipo_pago'];
    //     $status = 0;

    //     $documento->_id_producto = $id_producto;
    //     $documento->_user_id = $user_id;
    //     $documento->_reference = $reference;
    //     $documento->_clave = $clave;
    //     $documento->_fecha = $fecha;
    //     $documento->_monto = $monto;
    //     $documento->_tipo_pago = $tipo_pago;
    //     $documento->_status = $status;


    //     // var_dump($documento);
    //     // exit;

    //     $existe = TalleresDao::getProductosPendientesPago($user_id,$id_producto);

    //     if(!$existe){
    //         $id = TalleresDao::inserPendientePago($documento);   
    //     }
    //     // $nombre_completo = $datos_user['name_user'] . " " . $datos_user['middle_name'] . " " . $datos_user['surname'] . " " . $datos_user['second_surname'];

    // }

    function PagarPaypalAll(){

        $metodo_pago = $_POST['tipo_pago_paypal'];
        $user_id = $_SESSION['user_id'];
        $clave = $_POST['clave_paypal'];

        $bandera = '';
        $datos_user = RegisterDao::getUser($this->getUsuario())[0];

        $productos = TalleresDao::getCarritoByIdUser($user_id);


        foreach($productos as $key => $value){

            if($value['es_congreso'] == 1){
                $precio = $value['amout_due'];
            }else if($value['es_servicio'] == 1){
                $precio = $value['precio_publico'];
            }else if($value['es_curso'] == 1){
                $precio = $value['precio_publico'];
            }
           
            $documento = new \stdClass();  

            $nombre_curso = $value['nombre'];
            $id_producto = $value['id_producto'];
            $user_id = $datos_user['user_id'];
            $reference = $datos_user['reference'];
            $fecha =  date("Y-m-d");
            // $monto = $value['precio_publico'];
            $monto = $precio;
            $tipo_pago = $metodo_pago;
            $status = 0;
    
            $documento->_id_producto = $id_producto;
            $documento->_user_id = $user_id;
            $documento->_reference = $reference;
            $documento->_fecha = $fecha;
            $documento->_monto = $monto;
            $documento->_tipo_pago = $tipo_pago;
            $documento->_clave = $clave;
            $documento->_status = $status;

            $existe = TalleresDao::getProductosPendientesPago($user_id,$id_producto);

            if(!$existe){
                $id = TalleresDao::inserPendientePago($documento); 
                $delete = TalleresDao::deleteItem($value['id_carrito']);

                
            }
                // $delete = TalleresDao::deleteItem($value['id_carrito']);
                $bandera = "success";
        }

        $d = $this->fechaCastellano($fecha);
        
        $nombre_completo = $datos_user['name_user'] . " " . $datos_user['middle_name'] . " " . $datos_user['surname'] . " " . $datos_user['second_surname'];

       if($bandera == "success"){
           echo "success";
       }else{
           echo "fail";
       }
        // $raw_post_data = file_get_contents('php://input');
        // $raw_post_array = explode('&', $raw_post_data);
        // $myPost = array();
        // foreach ($raw_post_array as $keyval) {
        //     $keyval = explode ('=', $keyval);
        //     if (count($keyval) == 2)
        //         $myPost[$keyval[0]] = urldecode($keyval[1]);
        // }

        // // read the post from PayPal system and add 'cmd'
        // $req = 'cmd=_notify-validate';
        // if(function_exists('get_magic_quotes_gpc')) {
        //     $get_magic_quotes_exists = true;
        // }


        // foreach ($myPost as $key => $value) {
        //     if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
        //         $value = urlencode(stripslashes($value));
        //     } else {
        //         $value = urlencode($value);
        //     }
        //     $req .= "&$key=$value";
        // }

        // // Post IPN data back to PayPal to validate the IPN data is genuine
        // // Without this step anyone can fake IPN data

        // $ch = curl_init("https://www.paypal.com/es/cgi-bin/webscr");
        // if ($ch == FALSE) {
        //     return FALSE;
        // }
        // curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        // curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        // curl_setopt($ch, CURLOPT_HEADER, 1);
        // curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

        // // Set TCP timeout to 30 seconds
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        // $res = curl_exec($ch);


        // if (curl_errno($ch) != 0) // cURL error
        //     {
        //     error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, 'app.log');
        //     curl_close($ch);
        //     exit;
        // } else {
        //         // Log the entire HTTP response if debug is switched on.
        //         error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, 'app.log');
        //         error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, 'app.log');
        //         curl_close($ch);
        // }
        // // Inspect IPN validation result and act accordingly
        // // Split response headers and payload, a better way for strcmp
        // $payment_response = $res;

        // $tokens = explode("\r\n\r\n", trim($res));
        // $res = trim(end($tokens));
        // if (strcmp ($res, "VERIFIED") == 0) {
        //     // assign posted variables to local variables
            
        //     $item_name = $_POST['item_name'];
        //     $item_number = $_POST['item_number'];
        //     $payment_status = $_POST['payment_status'];
        //     $payment_amount = $_POST['mc_gross'];
        //     $payment_currency = $_POST['mc_currency'];
        //     $txn_id = $_POST['txn_id'];
        //     $receiver_email = $_POST['receiver_email'];
        //     $payer_email = $_POST['payer_email'];
            
        //     // check whether the payment_status is Completed
        //     $isPaymentCompleted = false;
        //     if($payment_status == "Completed") {
        //         $isPaymentCompleted = true;
        //     }
        //     $payment_id = $shoppingCart->insertPayment($item_number, $payment_status, $payment_response);
            
        //     // process payment and mark item as paid.
        //     $shoppingCart->paymentStatusChange ( $item_number,"PAID" );
        //     error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, 'app.log');
            
        // } else if (strcmp ($res, "INVALID") == 0) {
        //     // log for manual investigation
        //     // Add business logic here which deals with invalid IPN messages
        //     error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, 'app.log');
        // }
    }

    function fechaCastellano ($fecha) {
        $fecha = substr($fecha, 0, 10);
        $numeroDia = date('d', strtotime($fecha));
        $dia = date('l', strtotime($fecha));
        $mes = date('F', strtotime($fecha));
        $anio = date('Y', strtotime($fecha));

        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);

        return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
    }

    function generateRandomString($length = 10)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

}
