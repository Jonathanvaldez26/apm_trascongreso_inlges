<?php

namespace App\controllers;

defined("APPPATH") or die("Access denied");
require_once dirname(__DIR__) . '/../public/librerias/fpdf/fpdf.php';

use \Core\View;
use \Core\Controller;
use \App\models\ComprobantePago as ComprobantePagoDao;
use \App\models\Talleres as TalleresDao;
use \App\models\Register as RegisterDao;

class ComprobantePago extends Controller
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

    public function index()
    {
        $extraHeader = <<<html
html;
        $extraFooter = <<<html
    <!--footer class="footer pt-0">
              <div class="container-fluid">
                  <div class="row align-items-center justify-content-lg-between">
                      <div class="col-lg-6 mb-lg-0 mb-4">
                          <div class="copyright text-center text-sm text-muted text-lg-start">
                              © <script>
                                  document.write(new Date().getFullYear())
                              </script>,
                              made with <i class="fa fa-heart"></i> by
                              <a href="https://www.creative-tim.com" class="font-weight-bold" target="www.grupolahe.com">Creative GRUPO LAHE</a>.
                          </div>
                      </div>
                      <div class="col-lg-6">
                          <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                              <li class="nav-item">
                                  <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">privacy policies</a>
                              </li>
                          </ul>
                      </div>
                  </div>
              </div>
          </footer--    >
          <!-- jQuery -->
            <script src="/js/jquery.min.js"></script>
            <!--   Core JS Files   -->
            <script src="/assets/js/core/popper.min.js"></script>
            <script src="/assets/js/core/bootstrap.min.js"></script>
            <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
            <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
            <!-- Kanban scripts -->
            <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
            <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
            <script src="/assets/js/plugins/chartjs.min.js"></script>
            <script src="/assets/js/plugins/threejs.js"></script>
            <script src="/assets/js/plugins/orbit-controls.js"></script>
            
          <!-- Github buttons -->
            <script async defer src="https://buttons.github.io/buttons.js"></script>
          <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
            <script src="/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>

          <!-- VIEJO INICIO -->
            <script src="/js/jquery.min.js"></script>
          
            <script src="/js/custom.min.js"></script>

            <script src="/js/validate/jquery.validate.js"></script>
            <script src="/js/alertify/alertify.min.js"></script>
            <script src="/js/login.js"></script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
          <!-- VIEJO FIN -->
   <script>
    $( document ).ready(function() {

          $("#form_vacunacion").on("submit",function(event){
              event.preventDefault();
              
                  var formData = new FormData(document.getElementById("form_vacunacion"));
                  for (var value of formData.values()) 
                  {
                     console.log(value);
                  }
                  $.ajax({
                      url:"/Talleres/uploadComprobante",
                      type: "POST",
                      data: formData,
                      cache: false,
                      contentType: false,
                      processData: false,
                      beforeSend: function(){
                      console.log("Procesando....");
                  },
                  success: function(respuesta){
                      if(respuesta == 'success'){
                         // $('#modal_payment_ticket').modal('toggle');
                         
                          swal("¡Se ha guardado tu prueba correctamente!", "", "success").
                          then((value) => {
                              window.location.replace("/Talleres/");
                          });
                      }
                      console.log(respuesta);
                  },
                  error:function (respuesta)
                  {
                      console.log(respuesta);
                  }
              });
          });

        

      });
</script>

html;

        View::set('tabla',$this->getAllComprobantesPagoById($_SESSION['user_id']));
        View::set('header', $this->_contenedor->header($extraHeader));
        View::render("comprobante_pago_all");
    }



//     public function getAllComprobantesPagoById($id_user){

//         $html = "";
//         foreach (ComprobantePagoDao::getAllComprobantes($id_user) as $key => $value) {

//             if ($value['status'] == 0 ) {
//                 $icon_status = '<i class="fa fad fa-hourglass" style="color: #4eb8f7;"></i>';
//                 $status = '<span class="badge badge-info">En espera de validación</span>';
//             } else if ($value['status'] == 1 ){
//                 $icon_status = '<i class="far fa-check-circle" style="color: #269f61;"></i>';
//                 $status = '<span class="badge badge-success">Aceptado</span>';

//             }
//             else{
//                 $icon_status = '<i class="far fa-times-circle" style="color: red;"></i>';
//                 $status = '<span class="badge badge-danger">Carga un Archivo PDF valido</span>';
//             }

        

//             if (empty($value['url_archivo']) || $value['url_archivo'] == '') {
//                 $button_comprobante = '<form method="POST" enctype="multipart/form-data" action="/ComprobantePago/uploadComprobante" data-id-pp='.$value["id_pendiente_pago"].'>
//                                         <input type="hidden" name="id_pendiente_pago" id="id_pendiente_pago" value="'.$value["id_pendiente_pago"].'"/>
//                                         <input type="file" accept="application/pdf" class="form-control" id="file-input" name="file-input" style="width: auto; margin: 0 auto;">
//                                         <button class="btn btn-primary btn-only-icon mt-2" type="submit">Subir</button>
//                                         </form>';
//             } else {
//                 $button_comprobante = '<a href="/comprobantesPago/'.$value["url_archivo"].'" class="btn bg-pink btn-icon-only morado-musa-text text-center"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Ver Comprobante" target="_blank"><i class="fas fa-print"> </i></a>';
//             }

// //             $estatus = '';
// //             if ($value['status'] == 1) {
// //                 $estatus .= <<<html
// //                 <span class="badge badge-success">Activo</span>
// // html;
// //             } else {
// //                 $estatus .= <<<html
// //                 <span class="badge badge-success">Inactivo</span>
// // html;
// //             }
//             $html .= <<<html
//             <tr>
//                 <td >
//                     <div class="text-center"> 
                                                   
//                             <p>{$icon_status} {$value['nombre']}</p>                       
//                     </div>
//                 </td>
         
//                 <td style="text-align:left; vertical-align:middle;" > 
                    
//                     <div class="text-center">
//                         <p>{$status}</p>
//                     </div>
                  
//                 </td>

//                 <td style="text-align:left; vertical-align:middle;" > 
                    
//                     <div class="text-center">
//                         <p>{$value['tipo_pago']}</p>
//                     </div>
                
//                 </td>  

                
//                 <td  class="text-center">
//                    {$button_comprobante}
                    
//                 </td>
//         </tr>
// html;
//         }
       
//         return $html;
//     }

public function getAllComprobantesPagoById($id_user){

    $html = "";
    foreach (ComprobantePagoDao::getAllComprobantes($id_user) as $key => $value) {

        $total_array = array();
        $precio = 0;

        if ($value['status'] == 0 ) {
            $icon_status = '<i class="fa fad fa-hourglass" style="color: #4eb8f7;"></i>';
            $status = '<span class="badge badge-info">En espera de validación</span>';
        } else if ($value['status'] == 1 ){
            $icon_status = '<i class="far fa-check-circle" style="color: #269f61;"></i>';
            $status = '<span class="badge badge-success">Aceptado</span>';

        }
        else{
            $icon_status = '<i class="far fa-times-circle" style="color: red;"></i>';
            $status = '<span class="badge badge-danger">Carga un Archivo PDF valido</span>';
        }

        
        $reimprimir_ticket = '<a href="/comprobantePago/ticketImp/'.$value["clave"].'" class="btn bg-pink btn-icon-only morado-musa-text text-center"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Reimprimir Ticket" target="_blank"><i class="fas fa-file"></i></a>';

        if (empty($value['url_archivo']) || $value['url_archivo'] == '') {
            $button_comprobante = '<form method="POST" enctype="multipart/form-data" action="/ComprobantePago/uploadComprobante" data-id-pp='.$value["id_pendiente_pago"].'>
                                    <input type="hidden" name="id_pendiente_pago" id="id_pendiente_pago" value="'.$value["id_pendiente_pago"].'"/>
                                    <input type="file" accept="application/pdf" class="form-control" id="file-input" name="file-input" style="width: auto; margin: 0 auto;">
                                    <button class="btn btn-primary btn-only-icon mt-2" type="submit">Subir</button>
                                    </form>';
        } else {
            $button_comprobante = '<a href="/comprobantesPago/'.$value["url_archivo"].'" class="btn bg-pink btn-icon-only morado-musa-text text-center"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Ver mi comprobante" target="_blank"><i class="fas fa-print"> </i></a>';
        }
        

//             $estatus = '';
//             if ($value['status'] == 1) {
//                 $estatus .= <<<html
//                 <span class="badge badge-success">Activo</span>
// html;
//             } else {
//                 $estatus .= <<<html
//                 <span class="badge badge-success">Inactivo</span>
// html;
//             }
        $html .= <<<html
        <tr>
            <td style="width:70%">
                <div class="text-center"> 
html;                

                foreach(ComprobantePagoDao::getAllComprobantesbyClave($id_user,$value['clave']) as $key => $value2){

                    if($value2['es_congreso'] == 1){
                        $precio = $value2['amout_due'];
                    }else if($value2['es_servicio'] == 1){
                        $precio = $value2['precio_publico'];
                    }else if($value2['es_curso'] == 1){
                        $precio = $value2['precio_publico'];
                    }                    

                    array_push($total_array,$precio);

                    $precio = number_format($precio,2);

                    $html .= <<<html
                    <p>{$icon_status} {$value2['nombre']} $ {$precio}</p>
html;

                }   
                $total = number_format(array_sum($total_array),2);
                    // <p>{$icon_status} {$value['nombre']}</p>                       
                $html .= <<<html
                </div>
            </td>
     
            <td style="text-align:left; vertical-align:middle;" > 
                
                <div class="text-center">
                    <p>{$status}</p>
                    
                </div>
              
            </td>

            <td style="text-align:left; vertical-align:middle;" >                 
                <div class="text-center">                
                <p>$ {$total} {$value['tipo_moneda']}</p>
            </div>
          
        </td>

            <td style="text-align:left; vertical-align:middle;" > 
                
                <div class="text-center">
                    <p>{$value['tipo_pago']}</p>
                </div>
            
            </td>  

            <td>
                {$reimprimir_ticket}
            </td>

            
            <td  class="text-center">
               {$button_comprobante}
                
            </td>

    </tr>
html;
    }
   
    return $html;
}

    public function ticketImp($clave)
    {
       
        date_default_timezone_set('America/Mexico_City');

        
        $metodo_pago = $_POST['metodo_pago'];
        $user_id = $_SESSION['user_id'];
        // $clave = $this->generateRandomString();
        $datos_user = RegisterDao::getUser($this->getUsuario())[0];
        $productos = TalleresDao::getCarritoByIdUserTicket($user_id,$clave);

        // echo $user_id;
        // echo "<br>";
        // echo $clave;

        // var_dump($productos);

        // exit;
        
        // foreach($productos as $key => $value){

        //     if($value['es_congreso'] == 1){
        //         $precio = $value['amout_due'];
        //     }else if($value['es_servicio'] == 1){
        //         $precio = $value['precio_publico'];
        //     }else if($value['es_curso'] == 1){
        //         $precio = $value['precio_publico'];
        //     }
           
        //     $documento = new \stdClass();  

        //     $nombre_curso = $value['nombre'];
        //     $id_producto = $value['id_producto'];
        //     $user_id = $datos_user['user_id'];
        //     $reference = $datos_user['reference'];
            $fecha =  date("Y-m-d");
        //     // $monto = $value['precio_publico'];
        //     $monto = $precio;
        //     $tipo_pago = $metodo_pago;
        //     $status = 0;
    
        //     $documento->_id_producto = $id_producto;
        //     $documento->_user_id = $user_id;
        //     $documento->_reference = $reference;
        //     $documento->_fecha = $fecha;
        //     $documento->_monto = $monto;
        //     $documento->_tipo_pago = $tipo_pago;
        //     $documento->_clave = $clave;
        //     $documento->_status = $status;

        // }



        // $d = $this->fechaCastellano($fecha);
        
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
            $pdf->Multicell(100, 4, '$ '.$precio, 0, 'C');

            $espace = $espace + 8;
        }

        //folio
        $pdf->SetXY(118, 42.5);
        $pdf->SetFont('Arial', 'B', 13);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, $datos_user['reference'], 0, 'C');

        //fecha
        $pdf->SetXY(118, 51.5);
        $pdf->SetFont('Arial', 'B', 13);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, $fecha, 0, 'C');

        //total
        $pdf->SetXY(118, 170);
        $pdf->SetFont('Arial', 'B', 8);  
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Multicell(100, 10, 'TOTAL : '.number_format(array_sum($total),2), 0, 'C');

        $pdf->Output();
        // $pdf->Output('F','constancias/'.$clave.$id_curso.'.pdf');

        // $pdf->Output('F', 'C:/pases_abordar/'. $clave.'.pdf');
    }

    public function uploadComprobante(){
        $numero_rand = $this->generateRandomString();
        $id_pendiente_pago = $_POST['id_pendiente_pago'];
        $file = $_FILES["file-input"];

        if($file['name'] != ""){            
    
            move_uploaded_file($file["tmp_name"], "comprobantesPago/".$numero_rand.".pdf");
            $documento = new \stdClass();
            $documento->_id_pendiente_pago = $id_pendiente_pago;
            $documento->_url = $numero_rand.".pdf";
    
            $id = ComprobantePagoDao::updateComprobante($documento);
    
            if($id){
    
            // $data = [
            //     'status' => 'success',
            //     'img' => $numero_rand.'.png'
            // ];
                // echo "success";
                echo "<script>
                    // alert('Archivo subido correctamente');
                    window.location.href = /ComprobantePago/;
                </script>";
                
            }else{
                // echo "fail";
                echo "<script>
                        // alert('Hubo un error al subir el archivo');
                        window.location.href = /ComprobantePago/;
                    </script>";
                 
            // $data = [
            //     'status' => 'fail'
    
            // ];
            }
    
            // echo json_encode($data);
    
    
            // var_dump()

        }else{
            echo "<script>
                // alert('No selecciono ningun archivo');
                window.location.href = /ComprobantePago/;
            </script>";
            
        }

       
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

    function generateRandomString($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    
}
