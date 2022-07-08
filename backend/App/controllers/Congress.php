<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\Controller;
use \App\models\Home AS HomeDao;
use App\models\RegistroAcceso as RegistroAccesoDao;
use \App\models\Talleres as TalleresDao;
use \App\models\Transmision as TransmisionDao;
use \App\models\Congreso as CongresoDao;
use \App\models\Register as RegisterDao;
use \App\models\ComprobantePago as ComprobantePagoDao;

class Congress extends Controller{

    private $_contenedor;

    function __construct(){
        parent::__construct();
        $this->_contenedor = new Contenedor;
        View::set('header',$this->_contenedor->header());
        View::set('footer',$this->_contenedor->footer());
    }

    public function getUsuario(){
      return $this->__usuario;
    }

    public function index() {
     $extraHeader =<<<html
      <link id="pagestyle" href="/assets/css/style.css" rel="stylesheet" />
      <title>
            Home
      </title>
html;


        $tabla = '';

        $data_user = HomeDao::getDataUser($this->__usuario);
    
        View::set('header',$this->_contenedor->header($extraHeader));      
        View::set('datos',$data_user);
        //View::set('tabla',$tabla);
        View::render("congreso_all");
    }

    public function All(){

        $extraHeader =<<<html
      <link id="pagestyle" href="/assets/css/style.css" rel="stylesheet" />
      <title>
            Home
      </title>
html;


        $tabla = '';

        $data_user = HomeDao::getDataUser($this->__usuario);
    
        View::set('header',$this->_contenedor->header($extraHeader));      
        View::set('datos',$data_user);
        //View::set('tabla',$tabla);
        View::render("congreso_all");

    }

    public function Transcongress()
    {
        $extraHeader = <<<html
html;
       

        $data_user = HomeDao::getDataUser($this->__usuario);
        $modalComprar = '';
        // var_dump($data_user);

        $permisos_congreso = $data_user['congreso'] != '1' ? "style=\"display:none;\"" : "";

      
        //CURSOS COMPRADOS
        // $cursos = TalleresDao::getAll();
        $cursos = TalleresDao::getAsignaProducto($_SESSION['user_id']);

        $card_cursos = '';

        foreach ($cursos as $key => $value) {

           $title_badge = '';
           $precio = 0;

            if($value['clave_socio'] == ""){
                $title_badge = 'You have already purchased this course.';
                $precio = $value['precio_publico'];
            }else{
                $title_badge = 'This course was asigned by APM for free';
                $precio = 0;
                
            }

            // if($value['es_congreso'] == 1){
            //     $precio = $value['amout_due'];
            // }else if($value['es_servicio'] == 1){
            //     $precio = $value['precio_publico'];
            // }else if($value['es_curso'] == 1){
            //     $precio = $value['precio_publico'];
            // }

            $progreso = TalleresDao::getProductProgreso($_SESSION['user_id'], $value['id_producto']);

            $max_time = $value['duracion'];
            $duracion_sec = substr($max_time, strlen($max_time) - 2, 2);
            $duracion_min = substr($max_time, strlen($max_time) - 5, 2);
            $duracion_hrs = substr($max_time, 0, strpos($max_time, ':'));

            $secs_totales = (intval($duracion_hrs) * 3600) + (intval($duracion_min) * 60) + intval($duracion_sec);

            $porcentaje = round(($progreso['segundos'] * 100) / $secs_totales);

            $card_cursos .= <<<html



            <div class="col-12 col-md-4 mt-3">
            <div class="card card-course p-0 border-radius-15">
                <div class="card-body " style="height:235px;">
                    <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                    <div class="caratula-content">
                       <!-- <a href="/Programa/Video/{$value['clave']}/{$value['id_producto']}"> -->
                            <img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">
                        <!--</a>-->
                        <!--<div class="duracion"><p>{$value['duracion']}</p></div>-->
                        <!--<button class="btn btn-outline-danger"></button-->
                        
html;
        
                    $like = TalleresDao::getlikeProductCurso($value['id_producto'], $_SESSION['user_id']);
                    if ($like['status'] == 1) {
                        $card_cursos .= <<<html
                    <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>
html;
                    } else {
                        $card_cursos .= <<<html
                    <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2"></span>
html;
                    }
        
                    $card_cursos .= <<<html
                       <!-- <div class="row">
                            <div class="col-11 m-auto" id="">
                                <progress class="barra_progreso_small mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                            </div>
                        </div>-->
                    </div>
                    <a href="/Programa/Video/{$value['clave']}/{$value['id_producto']}">
                        <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre_ingles']}</b></p>               
                        
        
                        <!--<p class="text-left mx-3 text-sm">{$value['fecha_curso']}
                            {$value['descripcion']}<br>
                            {$value['vistas']} vistas
                            <br> <br>
                            <b>Avance: $porcentaje %</b>
                        </p>-->
        
html;
                    if ($value['status'] == 2 || $porcentaje >= 80) {
                        $card_cursos .= <<<html
                            <!--<div class="ms-3 me-3 msg-encuesta px-2 py-1">Se ha habilitado un examen para este taller</div><br><br>-->
html;
                    }
        
                    $card_cursos .= <<<html
                    </a>
        
                    <div>
                        
                    </div>
                </div>
                <div class="card-footer">
                <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$precio} {$value['tipo_moneda']}</b></p>
                <div style = "display: flex; justify-content:start">
                <p class="badge badge-success" style="margin-left: 5px;margin-bottom: 38px;">
                  {$title_badge}
                </p>
               
            </div>
          </div>
                </div>
                
            </div>
        
            
html;
        }
        //FIN CURSOS COMPRADOS


        //CURSOS SIN COMPRAR

        $cursos = TalleresDao::getAllProductCursosNotInUser($_SESSION['user_id']);

        foreach ($cursos as $key => $value) {
            $progreso = TalleresDao::getProductProgreso($_SESSION['user_id'], $value['id_producto']);

            $max_time = $value['duracion'];
            $duracion_sec = substr($max_time, strlen($max_time) - 2, 2);
            $duracion_min = substr($max_time, strlen($max_time) - 5, 2);
            $duracion_hrs = substr($max_time, 0, strpos($max_time, ':'));

            $secs_totales = (intval($duracion_hrs) * 3600) + (intval($duracion_min) * 60) + intval($duracion_sec);

            $porcentaje = round(($progreso['segundos'] * 100) / $secs_totales);

            $pendientes_pago = TalleresDao::getProductosPendientesPago($_SESSION['user_id'], $value['id_producto'])[0];

            if(isset($pendientes_pago['status'])){

                if($pendientes_pago['status'] == 0){
                    //pediente de pago
                    $card_cursos .= <<<html
    
    
                <div class="col-12 col-md-4 mt-3">
                    <div class="card card-course p-0 border-radius-15">
                        <div class="card-body " style="height:235px;">
                            <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                            <div class="caratula-content">
                          
                                <img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">
                           
html;

                            $like = TalleresDao::getlikeProductCurso($value['id_producto'], $_SESSION['user_id']);
                            if ($like['status'] == 1) {
                                $card_cursos .= <<<html
                            <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>
html;
                            } else {
                                $card_cursos .= <<<html
                            <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2"></span>
html;
                            }

                $card_cursos .= <<<html
                       
                        </div>
                        
                            <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre_ingles']}</b></p> 

                           

html;
                       

                    $link_parametro_user_id = base64_encode($_SESSION['user_id']);
                    $link_parametro_id_producto = base64_encode($value['id_producto']);

                    $card_cursos .= <<<html
                            

                            <div>
                    
                        </div>
                    </div>
                    <div class="card-footer">
                        <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$value['precio_publico']} {$value['tipo_moneda']}</b></p>
                        <div style = "display: flex; justify-content:start">
                        <!--<button class="btn btn-primary" style="margin-right: 5px;margin-left: 5px; width:145px;" data-toggle="modal" data-target="#comprar-curso{$value['id_producto']}">Buy</button>-->
                        <!--<a class="btn btn-primary" href="/OrdenPago/impticket/{$link_parametro_user_id}/{$link_parametro_id_producto})" target="_blank" style="margin-right: 5px;margin-left: 5px; width:auto;">Reimprimir orden de pago</a>-->
                        <div style = "display: flex; justify-content:start">
                            <p class="badge badge-info" style="margin-left: 5px;margin-bottom: 38px;">
                            Waiting for payment validation. <br>If you have already made your payment or want to reprint the format <br> of payment <a href="/ComprobantePago/" style="color: #08a1c4; text-decoration: underline; font-weight: bold; font-size: 15px;">click here.</a>
                            </p>
                   
                        </div>
                    
                    </div>
                </div>
            </div>        
        </div>

html;
                }else if($pendientes_pago['status'] == 2){
                    //pago rechazado
                    $card_cursos .= <<<html
    
    
                    <div class="col-12 col-md-4 mt-3">
                        <div class="card card-course p-0 border-radius-15">
                            <div class="card-body " style="height:235px;">
                                <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                                <div class="caratula-content">
                              
                                    <img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">
                               
html;
    
                                $like = TalleresDao::getlikeProductCurso($value['id_producto'], $_SESSION['user_id']);
                                if ($like['status'] == 1) {
                                    $card_cursos .= <<<html
                                <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>
html;
                                } else {
                                    $card_cursos .= <<<html
                                <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2"></span>
html;
                                }
    
                    $card_cursos .= <<<html
                           
                            </div>
                            
                                <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre_ingles']}</b></p> 
    
                               
    
html;
                           
    
                        $link_parametro_user_id = base64_encode($_SESSION['user_id']);
                        $link_parametro_id_producto = base64_encode($value['id_producto']);
    
                        $card_cursos .= <<<html
                                
    
                                <div>
                        
                            </div>
                        </div>
                        <div class="card-footer">
                            <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$value['precio_publico']} {$value['tipo_moneda']}</b></p>
                            <div style = "display: flex; justify-content:start">
                            <!--<button class="btn btn-primary" style="margin-right: 5px;margin-left: 5px; width:145px;" data-toggle="modal" data-target="#comprar-curso{$value['id_producto']}">Buy</button>-->
                            <!--<a class="btn btn-primary" href="/OrdenPago/impticket/{$link_parametro_user_id}/{$link_parametro_id_producto})" target="_blank" style="margin-right: 5px;margin-left: 5px; width:auto;">Reimprimir orden de pago</a>-->
                            <div style = "display: flex; justify-content:start">
                                <p class="badge badge-danger" style="margin-left: 5px;margin-bottom: 38px;">
                                    No se pudo validar tu pago, vuelve a subir tu <br> comprobante dando <a href="/ComprobantePago/" style="color: #bd0000; text-decoration: underline; font-weight: bold; font-size: 15px;">clic aquí.</a>
                                </p>
                       
                            </div>
                        
                        </div>
                    </div>
                </div>        
            </div>
    
html;
                
                }else {
                    //echo "pagado";
                }

            }
            else{
                //comprar
                $card_cursos .= <<<html
    
    
                <div class="col-12 col-md-4 mt-3">
                    <div class="card card-course p-0 border-radius-15">
                        <div class="card-body " style="height:235px;">
                            <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                            <div class="caratula-content">
                            <!-- <a href="/Programa/Video/{$value['clave']}/{$value['id_producto']}"> -->
                                <img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">
                            <!--</a>-->
                            <!--<div class="duracion"><p>{$value['duracion']}</p></div>-->
                            <!--<button class="btn btn-outline-danger"></button-->
                
html;

                            $like = TalleresDao::getlikeProductCurso($value['id_producto'], $_SESSION['user_id']);
                            if ($like['status'] == 1) {
                                $card_cursos .= <<<html
                            <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>
html;
                            } else {
                                $card_cursos .= <<<html
                            <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2"></span>
html;
                            }

                $card_cursos .= <<<html
                        
                        </div>
                       
                            <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre_ingles']}</b></p> 

html;
                    if($data_user['clave_socio'] == "" || empty($data_user['clave_socio'])){
                        $costo = $value['precio_publico']." ".$value['tipo_moneda'];
                    }else{
                        $costo = "0 USD";
                    }

                    $card_cursos .= <<<html
                            

                            <div>
                    
                        </div>
                    </div>
                    <div class="card-footer">
                        <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$costo}</b></p>
                        <div style = "display: flex; justify-content:start">
html;
                            
                if($data_user['clave_socio'] == "" || empty($data_user['clave_socio'])){

                
                    $card_cursos .= <<<html
                        <button class="btn btn-primary btn_comprar_individual" style="margin-right: 5px;margin-left: 5px; width:145px;"  value="{$value['id_producto']}">Buy</button>
                        <button class="btn btn-primary btn_cart" value="{$value['id_producto']}" style="margin-right: 5px;margin-left: 5px;">Add to cart <i class="fa far fa-cart-plus"></i></button>
html;
                }else{
                    $card_cursos .= <<<html
                        <button class="btn btn-primary btn_obtener_curso" style="margin-right: 5px;margin-left: 5px; width:auto;"  value="{$value['id_producto']}">Obtener Curso</button>
                       
html;
                }
                    $card_cursos .= <<<html
                    
                    </div>
                </div>
            </div>        
        </div>

    
html;

            $modalComprar .= $this->generateModalComprar($value);
        }

            
    }

        //CURSOS SIN COMPRAR


        
        
        

        //CONGRESOS SIN COMPRAR

        // $modalComprar = '';
        // foreach (TalleresDao::getAll() as $key => $value) {
        //     $modalComprar .= $this->generateModalComprar($value);
        // }

        View::set('header', $this->_contenedor->header($extraHeader));
        View::set('permisos_congreso', $permisos_congreso);
        View::set('datos', $data_user['datos']);
        View::set('card_cursos', $card_cursos);
        // View::set('card_congresos', $card_congresos);
        View::set('modalComprar', $modalComprar);
        View::render("transcongreso_all");
    }

    public function Video($clave)
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

        $congreso = CongresoDao::getVideoCongresoByClave($clave);

        //     var_dump($congreso['id_producto']);
        //     echo $_SESSION['user_id'];
        // exit;


        $contenido_taller = '';

        $permiso_taller = CongresoDao::getVideoCongresoByAsignacion($_SESSION['user_id'], $congreso['id_producto']);

        $progreso_curso = CongresoDao::getVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
        if ($progreso_curso) {
            $progreso_curso = CongresoDao::getVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
        } else {
          CongresoDao::insertVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
            $progreso_curso = CongresoDao::getVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
        }

        $duracion = $congreso['duracion'];

        $duracion_sec = substr($duracion, strlen($duracion) - 2, 2);
        $duracion_min = substr($duracion, strlen($duracion) - 5, 2);
        $duracion_hrs = substr($duracion, 0, strpos($duracion, ':'));

        $secs_totales = (intval($duracion_hrs) * 3600) + (intval($duracion_min) * 60) + intval($duracion_sec);

        $progreso_curso = CongresoDao::getVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
        if ($progreso_curso) {
            $progreso_curso = CongresoDao::getVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
        } else {
          CongresoDao::insertVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
            $progreso_curso = CongresoDao::getVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
        }
        

        $porcentaje = round(($progreso_curso['segundos'] * 100) / $secs_totales);

        if ($congreso) {
            $id_curso = CongresoDao::getVideoCongresoByClave($clave)['id_video_congreso'];
            $url = CongresoDao::getVideoCongresoByClave($clave)['url'];
            $nombre_taller = CongresoDao::getVideoCongresoByClave($clave)['nombre'];
            $descripcion = CongresoDao::getVideoCongresoByClave($clave)['descripcion'];

            if ($permiso_taller) {
                $contenido_taller .= <<<html
                <div class="row">
                <div class="embed-responsive embed-responsive-16by9">
         <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="{$url}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
        </div>
                   <!-- <iframe id="iframe" class="bg-gradient-warning iframe-course" src="{$url}" allow="autoplay; fullscreen; style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0"></iframe>-->
                    <!-- <iframe src="{$url}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:640;height:521;"></iframe>-->
                </div>
    
                <input type="text" value="{$clave}" id="clave_video" readonly hidden>
    
                <div>
                    <p>
                        <hr class="horizontal dark my-1">
                        <h6 class="mb-1 mt-2 text-center">{$descripcion}</h6>
                    </p>
                </div>
    
                
                
html;
                if ($congreso['status'] == 2 || $porcentaje >= 80) {
                    //                     $btn_encuesta = <<<html
                    //                     <button type="button" class="btn btn-primary" style="background-color: orangered!important;" data-toggle="modal" data-target="#encuesta">
                    //                         Examen
                    //                     </button>
                    // html;
                } else {
                    $btn_encuesta = '';
                }
            } else {
                $contenido_taller .= <<<html
                <hr>
                <div class="row mt-3">
                    <div class="col-10 m-auto text-center">
                        <h2 class="text-bolder text-gradient text-danger">
                            <i class="fas fa-exclamation"></i><br>
                            We are sorry, you don't have access to this course, contact with support.
                        </h2>
                    </div>
                </div>                
html;
                $btn_encuesta = '';
            }

            $encuesta = '';

            $preguntas  = TalleresDao::getPreguntasByProductCursoUsuario($id_curso);
            $ha_respondido = TalleresDao::getRespuestasCurso($_SESSION['user_id'], $id_curso);

            if ($preguntas) {

                $num_pregunta = 1;

                if ($ha_respondido) {

                    foreach ($preguntas as $key => $value) {
                        $opcion1 = $value['opcion1'];
                        $opcion2 = $value['opcion2'];
                        $opcion3 = $value['opcion3'];
                        $opcion4 = $value['opcion4'];

                        $encuesta .= <<<html
                        <div class="col-12 encuesta_completa">
                            <div class="mb-3 text-dark">
                                <h6 class="">$num_pregunta. {$value['pregunta']}</h6>
                            </div>
                            <input id="id_pregunta_$num_pregunta" value="{$value['id_pregunta_encuesta']}" hidden readonly>
                            <div class="form-group encuesta_curso_$num_pregunta">
html;
                        if ($value['respuesta_correcta'] == 1) {
                            $encuesta .= <<<html
                            <div id="op1">
                                <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                                <label class="text-success form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                            </div>

                            <div id="op2">
                                <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                            </div>

                            <div id="op3">
                                <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                            </div>

                            <div id="op4">
                                <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                            </div>

                            <div id="op5">
                                <input type="radio" data-label="{$value['opcion5']}" id="opcion5_$num_pregunta" name="pregunta_$num_pregunta" value="5" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion5_$num_pregunta">{$value['opcion5']}</label>
                            </div>
html;
                        }

                        if ($value['respuesta_correcta'] == 2) {
                            $encuesta .= <<<html
                            <div id="op1">
                                <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                            </div>

                            <div id="op2">
                                <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                                <label class="text-success form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                            </div>

                            <div id="op3">
                                <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                            </div>

                            <div id="op4">
                                <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                            </div>

                            <div id="op5">
                                <input type="radio" data-label="{$value['opcion5']}" id="opcion5_$num_pregunta" name="pregunta_$num_pregunta" value="5" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion5_$num_pregunta">{$value['opcion5']}</label>
                            </div>
html;
                        }

                        if ($value['respuesta_correcta'] == 3) {
                            $encuesta .= <<<html
                            <div id="op1">
                                <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                            </div>

                            <div id="op2">
                                <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                            </div>

                            <div id="op3">
                                <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                                <label class="text-success form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                            </div>

                            <div id="op4">
                                <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                            </div>

                            <div id="op5">
                                <input type="radio" data-label="{$value['opcion5']}" id="opcion5_$num_pregunta" name="pregunta_$num_pregunta" value="5" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion5_$num_pregunta">{$value['opcion5']}</label>
                            </div>
html;
                        }

                        if ($value['respuesta_correcta'] == 4) {
                            $encuesta .= <<<html
                            <div id="op1">
                                <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                            </div>

                            <div id="op2">
                                <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                            </div>

                            <div id="op3">
                                <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                            </div>

                            <div id="op4">
                                <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                                <label class="text-success form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                            </div>

                            <div id="op5">
                                <input type="radio" data-label="{$value['opcion5']}" id="opcion5_$num_pregunta" name="pregunta_$num_pregunta" value="5" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion5_$num_pregunta">{$value['opcion5']}</label>
                            </div>
html;
                        }

                        if ($value['respuesta_correcta'] == 5) {
                            $encuesta .= <<<html
                            <div id="op1">
                                <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                            </div>

                            <div id="op2">
                                <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                            </div>

                            <div id="op3">
                                <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                            </div>

                            <div id="op4">
                                <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                            </div>

                            <div id="op5">
                                <input type="radio" data-label="{$value['opcion5']}" id="opcion5_$num_pregunta" name="pregunta_$num_pregunta" value="5" disabled>
                                <label class="text-success form-label opcion-encuesta" for="opcion5_$num_pregunta">{$value['opcion5']}</label>
                            </div>
html;
                        }

                        $encuesta .= <<<html
                            </div>
                        </div>
    
                        <script>
                            $(document).ready(function(){
                                
                                // Pinta la respuesta si es correcta o no
                                console.log({$ha_respondido[$num_pregunta - 1]['respuesta_registrado']});
                                if({$ha_respondido[$num_pregunta - 1]['respuesta_registrado']} == 1){
                                    $('.encuesta_curso_$num_pregunta #op1 input').attr('checked','');
                                    if(!$('.encuesta_curso_$num_pregunta #op1 label').hasClass('text-success')){
                                        $('.encuesta_curso_$num_pregunta #op1 label').removeClass('text-dark').addClass('text-danger');
                                    }
                                } else if({$ha_respondido[$num_pregunta - 1]['respuesta_registrado']} == 2){
                                    $('.encuesta_curso_$num_pregunta #op2 input').attr('checked','');
                                    if(!$('.encuesta_curso_$num_pregunta #op2 label').hasClass('text-success')){
                                        $('.encuesta_curso_$num_pregunta #op2 label').removeClass('text-dark').addClass('text-danger');
                                    }
                                } else if({$ha_respondido[$num_pregunta - 1]['respuesta_registrado']} == 3){
                                    $('.encuesta_curso_$num_pregunta #op3 input').attr('checked','');
                                    if(!$('.encuesta_curso_$num_pregunta #op3 label').hasClass('text-success')){
                                        $('.encuesta_curso_$num_pregunta #op3 label').removeClass('text-dark').addClass('text-danger');
                                    }
                                } else if({$ha_respondido[$num_pregunta - 1]['respuesta_registrado']} == 4){
                                    $('.encuesta_curso_$num_pregunta #op4 input').attr('checked','');
                                    if(!$('.encuesta_curso_$num_pregunta #op4 label').hasClass('text-success')){
                                        $('.encuesta_curso_$num_pregunta #op4 label').removeClass('text-dark').addClass('text-danger');
                                    }
                                }

                                $('.encuesta_curso_$num_pregunta').on('click',function(){
                                    let respuesta = $('.encuesta_curso_$num_pregunta input[name=pregunta_$num_pregunta]:checked');
                                    if($('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' input').prop('checked')){
                                        $('.encuesta_curso_$num_pregunta label').removeClass('opacity-5');
                                        $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').addClass('opacity-5');
                                    }
        
                                    // Pinta la respuesta si es correcta o no
                                    // if(respuesta.val() == {$value['respuesta_correcta']}){
                                    //     $('.encuesta_curso_$num_pregunta label').addClass('text-dark');
                                    //     $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').removeClass('text-dark').addClass('text-success');
                                    // } else {
                                    //     $('.encuesta_curso_$num_pregunta label').addClass('text-dark');
                                    //     $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').removeClass('text-dark').addClass('text-danger');
                                    // }
                                });
                                
                            });
                        </script>
html;
                        $num_pregunta = $num_pregunta + 1;
                    }
                } else {
                    foreach ($preguntas as $key => $value) {
                        $encuesta .= <<<html
                        <div class="col-12 encuesta_completa">
                            <div class="mb-3 text-dark">
                                <h6 class="">$num_pregunta. {$value['pregunta']}</h6>
                            </div>
                            <input id="id_pregunta_$num_pregunta" value="{$value['id_pregunta_encuesta']}" hidden readonly>
                            <div class="form-group encuesta_curso_$num_pregunta">
                                <div id="op1">
                                    <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" required>
                                    <label class="form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                                </div>
    
                                <div id="op2">
                                    <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2">
                                    <label class="form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                                </div>
    
                                <div id="op3">
                                    <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3">
                                    <label class="form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                                </div>
    
                                <div id="op4">
                                    <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4">
                                    <label class="form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                                </div>
                                
                            </div>
                        </div>
    
                        <script>
                            $('.encuesta_curso_$num_pregunta').on('click',function(){
                                let respuesta = $('.encuesta_curso_$num_pregunta input[name=pregunta_$num_pregunta]:checked');
                                if($('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' input').prop('checked')){
                                    $('.encuesta_curso_$num_pregunta label').removeClass('opacity-5');
                                    $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').addClass('opacity-5');
                                }
    
                                // Pinta la respuesta si es correcta o no
                                // if(respuesta.val() == {$value['respuesta_correcta']}){
                                //     $('.encuesta_curso_$num_pregunta label').addClass('text-dark');
                                //     $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').removeClass('text-dark').addClass('text-success');
                                // } else {
                                //     $('.encuesta_curso_$num_pregunta label').addClass('text-dark');
                                //     $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').removeClass('text-dark').addClass('text-danger');
                                // }
                            });
                                
                            
                        </script>
html;
                        $num_pregunta = $num_pregunta + 1;
                    }
                }
            } else {
                $encuesta = <<<html
                <h3 class="text-danger">Aún no hay preguntas para este Curso.</h3>
html;
            }

            $data = new \stdClass();
            $data->_tipo = 3;
            $data->_sala = 1;
            $data->_id_tipo = $id_curso;

            $chat_taller = TransmisionDao::getNewChatByID($data);
            $cont_chat = '';
            $avatar = '';


            foreach ($chat_taller as $chat => $value) {
                $nombre_completo = $value['name_user'] . ' ' . $value['surname'] . ' ' . $value['second_surname'];
                $nombre_completo = utf8_encode($nombre_completo);
                $cont_chat .= <<<html
            <div class="d-flex mt-3">
                <div class="flex-shrink-0">
                    <img alt="Image placeholder" class="avatar rounded-circle" src="../../../img/users_musa/form.jpg">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="h5 mt-0">{$nombre_completo}</h6>
                    <p class="text-sm">{$value['chat']}</p>
                    
                </div>
            </div>
html;
                // $avatar = $value['avatar_img'];
                $avatar = 'form.jpg';
            }


            // var_dump($preguntas)


            View::set('clave', $clave);
            View::set('encuesta', $encuesta);
            View::set('id_curso', $id_curso);
            View::set('descripcion', $descripcion);
            View::set('nombre_taller', $nombre_taller);
            View::set('url', $url);
            View::set('btn_encuesta', $btn_encuesta);
            View::set('porcentaje', $porcentaje);
            View::set('contenido_taller', $contenido_taller);
            View::set('progreso_curso', $progreso_curso);
            View::set('secs_totales', $secs_totales);
            View::set('cont_chat', $cont_chat);
            View::set('avatar', $avatar);
            View::set('header', $this->_contenedor->header($extraHeader));
            View::set('footer', $this->_contenedor->footer($extraFooter));
            View::render("video_all_congreso");
        } else {
            View::render("404");
        }
    }

    public function VideoTraduccion($clave)
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

        $congreso = CongresoDao::getVideoCongresoByClave($clave);

        //     var_dump($congreso['id_producto']);
        //     echo $_SESSION['user_id'];
        // exit;


        $contenido_taller = '';

        $permiso_taller = CongresoDao::getVideoCongresoByAsignacion($_SESSION['user_id'], $congreso['id_producto']);

        $progreso_curso = CongresoDao::getVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
        if ($progreso_curso) {
            $progreso_curso = CongresoDao::getVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
        } else {
          CongresoDao::insertVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
            $progreso_curso = CongresoDao::getVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
        }

        $duracion = $congreso['duracion'];

        $duracion_sec = substr($duracion, strlen($duracion) - 2, 2);
        $duracion_min = substr($duracion, strlen($duracion) - 5, 2);
        $duracion_hrs = substr($duracion, 0, strpos($duracion, ':'));

        $secs_totales = (intval($duracion_hrs) * 3600) + (intval($duracion_min) * 60) + intval($duracion_sec);

        $progreso_curso = CongresoDao::getVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
        if ($progreso_curso) {
            $progreso_curso = CongresoDao::getVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
        } else {
          CongresoDao::insertVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
            $progreso_curso = CongresoDao::getVideoCongresoProgreso($_SESSION['user_id'], $congreso['id_video_congreso']);
        }
        

        $porcentaje = round(($progreso_curso['segundos'] * 100) / $secs_totales);

        if ($congreso) {
            $id_curso = CongresoDao::getVideoCongresoByClave($clave)['id_producto'];
            $url = CongresoDao::getVideoCongresoByClave($clave)['url_traduccion'];
            $nombre_taller = CongresoDao::getVideoCongresoByClave($clave)['nombre'];
            $descripcion = CongresoDao::getVideoCongresoByClave($clave)['descripcion'];

            if ($permiso_taller) {
                $contenido_taller .= <<<html
                <div class="row">
                <div class="embed-responsive embed-responsive-16by9">
         <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="{$url}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
        </div>
                   <!-- <iframe id="iframe" class="bg-gradient-warning iframe-course" src="{$url}" allow="autoplay; fullscreen; style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0"></iframe>-->
                    <!-- <iframe src="{$url}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:640;height:521;"></iframe>-->
                </div>
    
                <input type="text" value="{$clave}" id="clave_video" readonly hidden>
    
                <div>
                    <p>
                        <hr class="horizontal dark my-1">
                        <h6 class="mb-1 mt-2 text-center">{$descripcion}</h6>
                    </p>
                </div>
    
                
                
html;
                if ($congreso['status'] == 2 || $porcentaje >= 80) {
                    //                     $btn_encuesta = <<<html
                    //                     <button type="button" class="btn btn-primary" style="background-color: orangered!important;" data-toggle="modal" data-target="#encuesta">
                    //                         Examen
                    //                     </button>
                    // html;
                } else {
                    $btn_encuesta = '';
                }
            } else {
                $contenido_taller .= <<<html
                <hr>
                <div class="row mt-3">
                    <div class="col-10 m-auto text-center">
                        <h2 class="text-bolder text-gradient text-danger">
                            <i class="fas fa-exclamation"></i><br>
                            Lo sentimos no tiene acceso a este curso, contacte a soporte.
                        </h2>
                    </div>
                </div>                
html;
                $btn_encuesta = '';
            }

            $encuesta = '';

            $preguntas  = TalleresDao::getPreguntasByProductCursoUsuario($id_curso);
            $ha_respondido = TalleresDao::getRespuestasCurso($_SESSION['user_id'], $id_curso);

            if ($preguntas) {

                $num_pregunta = 1;

                if ($ha_respondido) {

                    foreach ($preguntas as $key => $value) {
                        $opcion1 = $value['opcion1'];
                        $opcion2 = $value['opcion2'];
                        $opcion3 = $value['opcion3'];
                        $opcion4 = $value['opcion4'];

                        $encuesta .= <<<html
                        <div class="col-12 encuesta_completa">
                            <div class="mb-3 text-dark">
                                <h6 class="">$num_pregunta. {$value['pregunta']}</h6>
                            </div>
                            <input id="id_pregunta_$num_pregunta" value="{$value['id_pregunta_encuesta']}" hidden readonly>
                            <div class="form-group encuesta_curso_$num_pregunta">
html;
                        if ($value['respuesta_correcta'] == 1) {
                            $encuesta .= <<<html
                            <div id="op1">
                                <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                                <label class="text-success form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                            </div>

                            <div id="op2">
                                <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                            </div>

                            <div id="op3">
                                <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                            </div>

                            <div id="op4">
                                <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                            </div>

                            <div id="op5">
                                <input type="radio" data-label="{$value['opcion5']}" id="opcion5_$num_pregunta" name="pregunta_$num_pregunta" value="5" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion5_$num_pregunta">{$value['opcion5']}</label>
                            </div>
html;
                        }

                        if ($value['respuesta_correcta'] == 2) {
                            $encuesta .= <<<html
                            <div id="op1">
                                <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                            </div>

                            <div id="op2">
                                <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                                <label class="text-success form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                            </div>

                            <div id="op3">
                                <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                            </div>

                            <div id="op4">
                                <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                            </div>

                            <div id="op5">
                                <input type="radio" data-label="{$value['opcion5']}" id="opcion5_$num_pregunta" name="pregunta_$num_pregunta" value="5" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion5_$num_pregunta">{$value['opcion5']}</label>
                            </div>
html;
                        }

                        if ($value['respuesta_correcta'] == 3) {
                            $encuesta .= <<<html
                            <div id="op1">
                                <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                            </div>

                            <div id="op2">
                                <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                            </div>

                            <div id="op3">
                                <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                                <label class="text-success form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                            </div>

                            <div id="op4">
                                <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                            </div>

                            <div id="op5">
                                <input type="radio" data-label="{$value['opcion5']}" id="opcion5_$num_pregunta" name="pregunta_$num_pregunta" value="5" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion5_$num_pregunta">{$value['opcion5']}</label>
                            </div>
html;
                        }

                        if ($value['respuesta_correcta'] == 4) {
                            $encuesta .= <<<html
                            <div id="op1">
                                <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                            </div>

                            <div id="op2">
                                <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                            </div>

                            <div id="op3">
                                <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                            </div>

                            <div id="op4">
                                <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                                <label class="text-success form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                            </div>

                            <div id="op5">
                                <input type="radio" data-label="{$value['opcion5']}" id="opcion5_$num_pregunta" name="pregunta_$num_pregunta" value="5" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion5_$num_pregunta">{$value['opcion5']}</label>
                            </div>
html;
                        }

                        if ($value['respuesta_correcta'] == 5) {
                            $encuesta .= <<<html
                            <div id="op1">
                                <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                            </div>

                            <div id="op2">
                                <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                            </div>

                            <div id="op3">
                                <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                            </div>

                            <div id="op4">
                                <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                                <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                            </div>

                            <div id="op5">
                                <input type="radio" data-label="{$value['opcion5']}" id="opcion5_$num_pregunta" name="pregunta_$num_pregunta" value="5" disabled>
                                <label class="text-success form-label opcion-encuesta" for="opcion5_$num_pregunta">{$value['opcion5']}</label>
                            </div>
html;
                        }

                        $encuesta .= <<<html
                            </div>
                        </div>
    
                        <script>
                            $(document).ready(function(){
                                
                                // Pinta la respuesta si es correcta o no
                                console.log({$ha_respondido[$num_pregunta - 1]['respuesta_registrado']});
                                if({$ha_respondido[$num_pregunta - 1]['respuesta_registrado']} == 1){
                                    $('.encuesta_curso_$num_pregunta #op1 input').attr('checked','');
                                    if(!$('.encuesta_curso_$num_pregunta #op1 label').hasClass('text-success')){
                                        $('.encuesta_curso_$num_pregunta #op1 label').removeClass('text-dark').addClass('text-danger');
                                    }
                                } else if({$ha_respondido[$num_pregunta - 1]['respuesta_registrado']} == 2){
                                    $('.encuesta_curso_$num_pregunta #op2 input').attr('checked','');
                                    if(!$('.encuesta_curso_$num_pregunta #op2 label').hasClass('text-success')){
                                        $('.encuesta_curso_$num_pregunta #op2 label').removeClass('text-dark').addClass('text-danger');
                                    }
                                } else if({$ha_respondido[$num_pregunta - 1]['respuesta_registrado']} == 3){
                                    $('.encuesta_curso_$num_pregunta #op3 input').attr('checked','');
                                    if(!$('.encuesta_curso_$num_pregunta #op3 label').hasClass('text-success')){
                                        $('.encuesta_curso_$num_pregunta #op3 label').removeClass('text-dark').addClass('text-danger');
                                    }
                                } else if({$ha_respondido[$num_pregunta - 1]['respuesta_registrado']} == 4){
                                    $('.encuesta_curso_$num_pregunta #op4 input').attr('checked','');
                                    if(!$('.encuesta_curso_$num_pregunta #op4 label').hasClass('text-success')){
                                        $('.encuesta_curso_$num_pregunta #op4 label').removeClass('text-dark').addClass('text-danger');
                                    }
                                }

                                $('.encuesta_curso_$num_pregunta').on('click',function(){
                                    let respuesta = $('.encuesta_curso_$num_pregunta input[name=pregunta_$num_pregunta]:checked');
                                    if($('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' input').prop('checked')){
                                        $('.encuesta_curso_$num_pregunta label').removeClass('opacity-5');
                                        $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').addClass('opacity-5');
                                    }
        
                                    // Pinta la respuesta si es correcta o no
                                    // if(respuesta.val() == {$value['respuesta_correcta']}){
                                    //     $('.encuesta_curso_$num_pregunta label').addClass('text-dark');
                                    //     $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').removeClass('text-dark').addClass('text-success');
                                    // } else {
                                    //     $('.encuesta_curso_$num_pregunta label').addClass('text-dark');
                                    //     $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').removeClass('text-dark').addClass('text-danger');
                                    // }
                                });
                                
                            });
                        </script>
html;
                        $num_pregunta = $num_pregunta + 1;
                    }
                } else {
                    foreach ($preguntas as $key => $value) {
                        $encuesta .= <<<html
                        <div class="col-12 encuesta_completa">
                            <div class="mb-3 text-dark">
                                <h6 class="">$num_pregunta. {$value['pregunta']}</h6>
                            </div>
                            <input id="id_pregunta_$num_pregunta" value="{$value['id_pregunta_encuesta']}" hidden readonly>
                            <div class="form-group encuesta_curso_$num_pregunta">
                                <div id="op1">
                                    <input type="radio" data-label="{$value['opcion1']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" required>
                                    <label class="form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1']}</label>
                                </div>
    
                                <div id="op2">
                                    <input type="radio" data-label="{$value['opcion2']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2">
                                    <label class="form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2']}</label>
                                </div>
    
                                <div id="op3">
                                    <input type="radio" data-label="{$value['opcion3']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3">
                                    <label class="form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3']}</label>
                                </div>
    
                                <div id="op4">
                                    <input type="radio" data-label="{$value['opcion4']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4">
                                    <label class="form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4']}</label>
                                </div>
                                
                            </div>
                        </div>
    
                        <script>
                            $('.encuesta_curso_$num_pregunta').on('click',function(){
                                let respuesta = $('.encuesta_curso_$num_pregunta input[name=pregunta_$num_pregunta]:checked');
                                if($('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' input').prop('checked')){
                                    $('.encuesta_curso_$num_pregunta label').removeClass('opacity-5');
                                    $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').addClass('opacity-5');
                                }
    
                                // Pinta la respuesta si es correcta o no
                                // if(respuesta.val() == {$value['respuesta_correcta']}){
                                //     $('.encuesta_curso_$num_pregunta label').addClass('text-dark');
                                //     $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').removeClass('text-dark').addClass('text-success');
                                // } else {
                                //     $('.encuesta_curso_$num_pregunta label').addClass('text-dark');
                                //     $('.encuesta_curso_$num_pregunta #op'+respuesta.val()+' label').removeClass('text-dark').addClass('text-danger');
                                // }
                            });
                                
                            
                        </script>
html;
                        $num_pregunta = $num_pregunta + 1;
                    }
                }
            } else {
                $encuesta = <<<html
                <h3 class="text-danger">Aún no hay preguntas para este Curso.</h3>
html;
            }

            $data = new \stdClass();
            $data->_tipo = 3;
            $data->_sala = 1;
            $data->_id_tipo = $id_curso;

            $chat_taller = TransmisionDao::getNewChatByID($data);
            $cont_chat = '';
            $avatar = '';


            foreach ($chat_taller as $chat => $value) {
                $nombre_completo = $value['name_user'] . ' ' . $value['surname'] . ' ' . $value['second_surname'];
                $nombre_completo = utf8_encode($nombre_completo);
                $cont_chat .= <<<html
            <div class="d-flex mt-3">
                <div class="flex-shrink-0">
                    <img alt="Image placeholder" class="avatar rounded-circle" src="../../../img/users_musa/form.jpg">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="h5 mt-0">{$nombre_completo}</h6>
                    <p class="text-sm">{$value['chat']}</p>
                    
                </div>
            </div>
html;
                $avatar = $value['avatar_img'];
            }


            // var_dump($preguntas)

            View::set('clave', $clave);
            View::set('encuesta', $encuesta);
            View::set('id_curso', $id_curso);
            View::set('descripcion', $descripcion);
            View::set('nombre_taller', $nombre_taller);
            View::set('url', $url);
            View::set('btn_encuesta', $btn_encuesta);
            View::set('porcentaje', $porcentaje);
            View::set('contenido_taller', $contenido_taller);
            View::set('progreso_curso', $progreso_curso);
            View::set('secs_totales', $secs_totales);
            View::set('cont_chat', $cont_chat);
            View::set('avatar', $avatar);
            View::set('header', $this->_contenedor->header($extraHeader));
            View::set('footer', $this->_contenedor->footer($extraFooter));
            View::render("video_all_congreso_traduccion");
        } else {
            View::render("404");
        }
    }

    public function saveChat()
    {
        $chat = $_POST['txt_chat'];
        $sala = $_POST['sala'];
        $id_tipo = $_POST['id_tipo'];

        $data = new \stdClass();
        $data->_id_registrado = $_SESSION['user_id'];
        $data->_chat = $chat;
        $data->_tipo = 3; //taller
        $data->_id_tipo = $id_tipo;
        $data->_sala = $sala;

        $id = TransmisionDao::insertNewChat($data);

        if ($id) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    public function getChatById()
    {
        $id_tipo = $_POST['id_tipo'];
        $sala = $_POST['sala'];

        $taller = TalleresDao::getPorductById($id_tipo);
        $data = new \stdClass();
        $data->_tipo = 3;
        $data->_sala = $sala;
        $data->_id_tipo = $taller['id_producto'];

        $chat_taller = TransmisionDao::getNewChatByID($data);

        echo json_encode($chat_taller);
    }

    public function generateModalComprar($datos)
    {
        if(isset($datos['amout_due'])){
            $precio_curso = '$ '.$datos['amout_due'] ." ".$datos['tipo_moneda'];
            $solo_precio_curso = $datos['amout_due'];
        }else{
            $precio_curso = '$ '.$datos['precio_publico']." ".$datos['tipo_moneda'];
            $solo_precio_curso = $datos['precio_publico'];
        }

        $clave = $this->generateRandomString();

        $modal = <<<html
        <div class="modal fade" id="comprar-curso{$datos['id_producto']}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="comprar-curso">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                Complete your purchase
                </h5>

                <span type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal" aria-label="Close">
                    X
                </span>
            </div>
            <div class="modal-body">
              <form class="form_compra" method="POST" action="" target="_blank">              
              <div class="row">
                <div class="col-md-8">
                    <div style="display:flex; justify-content:center;">
                        <img src="/caratulas/{$datos['caratula']}" style="width:60%; border-radius: 10px;" alt="" />
                    </div>

                    <p class="text-center mt-3"><b>{$datos['nombre_ingles']}</b></p>

                    <p class="text-center" style="color: #2B932B;"><b>{$precio_curso}</b></p>
                    <input type="hidden" value="{$solo_precio_curso}" name="costo"/>
                    <input type="hidden" value="{$datos['tipo_moneda']}" name="tipo_moneda"/>
                    <input type="hidden" value="{$datos['id_producto']}" name="id_producto"/>
                    <input type="hidden" value="{$datos['nombre']}" name="nombre_curso"/>
                    <input type="hidden" class="tipo_pago" name="tipo_pago"/>

                    <br>

                    <!-- campos para paypal -->
                    <input type="hidden" name="charset" value="utf-8">
                    <input type='hidden' name='business' value='aspsiqm@prodigy.net.mx'> 
                    <input type='hidden' name='item_name' value='{$datos['nombre']}'> 
                    <input type='hidden' name='item_number' value="{$clave}"> 
                    <input type='hidden' name='amount' value='{$solo_precio_curso}'> 
                    <input type='hidden' name='currency_code' value='{$datos['tipo_moneda']}'> 
                    <input type='hidden' name='notify_url' value=''> 
                    <input type='hidden' name='return' value='https://registro.dualdisorderswaddmexico2022.com/ComprobantePago/'> 
                    <input type="hidden" name="cmd" value="_xclick">  
                    <input type="hidden" name="order" value="{$clave}">

                    <div class="row d-flex justify-content-center">
                        <div class="col-4">
                            <label>Choose your payment method *</label>
                            <select class="multisteps-form__select form-control all_input_second_select metodo_pago" name="metodo_pago" required>
                                <option value="" disabled selected>Select an option</option>
                                <option value="Paypal">Paypal</option>
                                <option value="Efectivo">Cash</option>
                            </select>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center mt-3">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary btn_comprar" style="width: 100%;" name="btn_tipo_pago" data-id={$datos['id_producto']} >Buy</button>
                        </div>
                    </div>
                    
                    
                
                </div>
                <div class="col-md-4">
                </div>
              </div>
              </form>
                
              <form id="form_compra_paypal{$datos['id_producto']}">
                    <input type="hidden" value="{$solo_precio_curso}" name="costo"/>
                    <input type="hidden" value="{$datos['tipo_moneda']}" name="tipo_moneda"/>
                    <input type="hidden" value="{$datos['id_producto']}" name="id_producto"/>
                    <input type="hidden" value="{$datos['nombre']}" name="nombre_curso"/>
                    <input type="hidden" class="tipo_pago" name="tipo_pago"/>                    
                    <input type='hidden' name='clave' value="{$clave}">                    


              </form>
            </div>
          </div>
        </div>
      </div>

      
html;



        return $modal;
    }

    function generateRandomString($length = 10)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    public function Certificate()
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

        

      });
</script>

html;


        View::set('tabla', $this->getAllConstanciasByIdUser($_SESSION['user_id']));
        View::set('header', $this->_contenedor->header($extraHeader));
        View::render("constancias_all");
    }

    public function getAllConstanciasByIdUser($id_user)
    {

        $html = "";
        foreach (CongresoDao::getBuscarCursos($id_user) as $key => $value) {

            if($value['id_producto'] == 1){
            $progreso_programa = CongresoDao::getProgresoPrograma($id_user);
            }else if($value['id_producto'] > 1 AND $value['id_producto'] < 10){
            $progreso_cursos = CongresoDao::getProgresoCursos($id_user,$value['id_producto']);
            $progreso_programa = 0;
            }
            else{
                $progreso_cursos = 0;
                $progreso_programa = 0;
            }

            $progreso = TalleresDao::getProductProgreso($id_user, $value['id_producto']);

            $max_time = $value['duracion'];
            $duracion_sec = substr($max_time, strlen($max_time) - 2, 2);
            $duracion_min = substr($max_time, strlen($max_time) - 5, 2);
            $duracion_hrs = substr($max_time, 0, strpos($max_time, ':'));

            $secs_totales = (intval($duracion_hrs) * 3600) + (intval($duracion_min) * 60) + intval($duracion_sec);             

            $progreso_total = $progreso['segundos'] + $progreso_programa['total_segundos'] + $progreso_cursos['total_segundos_a'];

            //Progreso Horas
            $progreso_horas = round(($progreso_total / 3600));

            //progerso minutos 
            $progreso_minutos = ($progreso_horas * 60);

            //progreso a poner
            $progress = base64_encode($progreso_horas);

            $porcentaje = round(($progreso_total * 100) / $secs_totales);

            //Verificar si es NAN
            $porcentaje_1 = is_nan($porcentaje);
            $porcentaje_2 = is_infinite($porcentaje);           
            if($porcentaje_1 || $porcentaje_2){
                $porcentaje = 0;
            }else{
                $porcentaje = round(($progreso_total * 100) / $secs_totales);
            }

            $existe = CongresoDao::getProductoByIdAndUser($value['id_producto'],$id_user);

            if($existe){
                $td = '<p class="badge badge-success" style="margin-left: 5px;margin-bottom: 38px;">
                You already downloaded this certificate.
                </p>';
            }else{
                $td = '
                    <a href="/Home/abrirConstanciaDigital/'.$value['clave'].'/'.$value['id_producto'].'/'.$progress.'" style="display:none;" id="download'.$value['id_producto'].'" class="btn bg-pink btn-icon-only morado-musa-text" title="Digital" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Digital" target="_blank"><i class="fas fa-print"> </i></a>

                <button class="btn bg-pink btn-icon-only morado-musa-text btn-constancia" data-clave="'.$value['clave'].'" data-id-producto="'.$value['id_producto'].'" data-progreso="'.$progreso_horas.'" title="Digital" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Digital" target="_blank"><i class="fas fa-print"> </i>
                ';
            }
 
            $html .= <<<html
        <tr>
            <td style="overflow:auto;max-width:200px;">
                {$value['nombre_producto']}
            </td>
            <td style="width:50%">
                <div>
                    <progress class="barra_progreso_small" max="{$secs_totales}" value="{$progreso_total}"></progress>
                </div>
                
                <span class="text-lg text-center text-dark opacity-8">Progress: <span class="porcentaje">{$progreso_horas} HOURS</span> </span>
               
            </td>

            <td style="text-align:center;">
                <!--<a href="/Home/abrirConstancia/{$value['clave']}/{$value['id_producto']}" class="btn bg-pink btn-icon-only morado-musa-text" title="Impresa" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Impresa" target="_blank"><i class="fas fa-print"> </i></a>-->
                {$td}

                
                
                </button>
            </td>
     
           

        </tr>
html;
// var_dump($value);
        }

        return $html;
    }


    public function getData(){
      echo $_POST['datos'];
    }

    public function NoCargaPickup(){
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/logos/apmn.png">
        <title>
            Home ASDF
        </title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="../../../assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="../../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="../../../assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- CSS Files -->
        <link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
        <link rel="stylesheet" href="/css/alertify/alertify.core.css" />
        <link rel="stylesheet" href="/css/alertify/alertify.default.css" id="toggleCSS" />
        
        
        
        

html;
        $extraFooter =<<<html
     
        <script src="/js/jquery.min.js"></script>
        <script src="/js/validate/jquery.validate.js"></script>
        <script src="/js/alertify/alertify.min.js"></script>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
       <!--   Core JS Files   -->
          <script src="../../../assets/js/core/popper.min.js"></script>
          <script src="../../../assets/js/core/bootstrap.min.js"></script>
          <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
          <script src="../../../assets/js/plugins/multistep-form.js"></script>
         
          <!-- Kanban scripts -->
          <script src="../../../assets/js/plugins/dragula/dragula.min.js"></script>
          <script src="../../../assets/js/plugins/jkanban/jkanban.js"></script>
          <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
              var options = {
                damping: '0.5'
              }
              Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
          </script>
          <!-- Github buttons -->
          <script async defer src="https://buttons.github.io/buttons.js"></script>
          <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->

html;

        View::set('header',$extraHeader);
        View::set('footer',$extraFooter);
        View::render("code");
    }

    function getItinerario(){
      $id_asis = $_POST['id'];
      $asistenteItinerario = HomeDao::getItinerarioAsistente($id_asis)[0];
      echo json_encode($asistenteItinerario);
    }

}
