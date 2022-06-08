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

class Talleres extends Controller
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

        $data_user = HomeDao::getDataUser($this->__usuario);
        $modalComprar = '';
        // var_dump($data_user);

        $permisos_congreso = $data_user['congreso'] != '1' ? "style=\"display:none;\"" : "";

        // $usuarios = HomeDao::getAllUsers();
        // $free_courses = HomeDao::getFreeCourses();


        // foreach ($free_courses as $key => $value) {
        //     // HomeDao::insertCursos($_SESSION['id_registrado'],$value['id_curso']);
        //     $hay = HomeDao::getAsignaCursoByUser($_SESSION['id_registrado'], $value['id_curso']);
        //     // var_dump($hay);
        //     if ($hay == NULL || $hay == 'NULL ') {
        //         HomeDao::insertCursos($_SESSION['id_registrado'], $value['id_curso']);
        //     }
        // }

        //CURSOS COMPRADOS
        // $cursos = TalleresDao::getAll();
        $cursos = TalleresDao::getAsignaProducto($_SESSION['user_id']);

        $card_cursos = '';

        foreach ($cursos as $key => $value) {
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
                       <!-- <a href="/Talleres/Video/{$value['clave']}"> -->
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
                    <a href="/Talleres/Video/{$value['clave']}">
                        <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre']}</b></p>               
                        
        
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
                <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$value['precio_publico']} {$value['tipo_moneda']}</b></p>
                <div style = "display: flex; justify-content:start">
                <p class="badge badge-success" style="margin-left: 5px;margin-bottom: 38px;">
                  Este curso ya lo compraste.
                </p>
               
            </div>
          </div>
                </div>
                
            </div>
        
            <script>
                // $('#video_{$value['clave']}').on('click', function(){
                //     let like = $('#video_{$value['clave']}').hasClass('heart-like');
                    
                //     if (like){
                //         $('#video_{$value['clave']}').removeClass('heart-like').addClass('heart-not-like')
                //     } else {
                //         $('#video_{$value['clave']}').removeClass('heart-not-like').addClass('heart-like')
                //     }
                // });
            </script>
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
                            <!-- <a href="/Talleres/Video/{$value['clave']}"> -->
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
                        <!--<a href="/Talleres/Video/{$value['clave']}">-->
                            <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre']}</b></p> 

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

                    $link_parametro_user_id = base64_encode($_SESSION['user_id']);
                    $link_parametro_id_producto = base64_encode($value['id_producto']);

                    $card_cursos .= <<<html
                            <!--</a>-->

                            <div>
                    
                        </div>
                    </div>
                    <div class="card-footer">
                        <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$value['precio_publico']} {$value['tipo_moneda']}</b></p>
                        <div style = "display: flex; justify-content:start">
                        <!--<button class="btn btn-primary" style="margin-right: 5px;margin-left: 5px; width:145px;" data-toggle="modal" data-target="#comprar-curso{$value['id_producto']}">Comprar</button>-->
                        <a class="btn btn-primary" href="/OrdenPago/impticket/{$link_parametro_user_id}/{$link_parametro_id_producto})" target="_blank" style="margin-right: 5px;margin-left: 5px; width:auto;">Reimprimir orden de pago</a>
                    
                    </div>
                </div>
            </div>        
        </div>

    <script>
        // $('#video_{$value['clave']}').on('click', function(){
        //     let like = $('#video_{$value['clave']}').hasClass('heart-like');
            
        //     if (like){
        //         $('#video_{$value['clave']}').removeClass('heart-like').addClass('heart-not-like')
        //     } else {
        //         $('#video_{$value['clave']}').removeClass('heart-not-like').addClass('heart-like')
        //     }
        // });
    </script>
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
                            <!-- <a href="/Talleres/Video/{$value['clave']}"> -->
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
                        <!--<a href="/Talleres/Video/{$value['clave']}">-->
                            <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre']}</b></p> 

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
                            <!--</a>-->

                            <div>
                    
                        </div>
                    </div>
                    <div class="card-footer">
                        <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$value['precio_publico']} {$value['tipo_moneda']}</b></p>
                        <div style = "display: flex; justify-content:start">
                        <button class="btn btn-primary" style="margin-right: 5px;margin-left: 5px; width:145px;" data-toggle="modal" data-target="#comprar-curso{$value['id_producto']}">Comprar</button>
                    
                    </div>
                </div>
            </div>        
        </div>

    <script>
        // $('#video_{$value['clave']}').on('click', function(){
        //     let like = $('#video_{$value['clave']}').hasClass('heart-like');
            
        //     if (like){
        //         $('#video_{$value['clave']}').removeClass('heart-like').addClass('heart-not-like')
        //     } else {
        //         $('#video_{$value['clave']}').removeClass('heart-not-like').addClass('heart-like')
        //     }
        // });
    </script>
html;

            $modalComprar .= $this->generateModalComprar($value);
        }

            
    }

        //CURSOS SIN COMPRAR


        //CONGRESOS COMPRADOS
        // $cursos = TalleresDao::getAll();
        $cursos = TalleresDao::getAsignaProductoCongreso($_SESSION['user_id']);

        $card_congresos = '';

        foreach ($cursos as $key => $value) {
            $progreso = TalleresDao::getProductProgreso($_SESSION['user_id'], $value['id_producto']);

            $max_time = $value['duracion'];
            $duracion_sec = substr($max_time, strlen($max_time) - 2, 2);
            $duracion_min = substr($max_time, strlen($max_time) - 5, 2);
            $duracion_hrs = substr($max_time, 0, strpos($max_time, ':'));

            $secs_totales = (intval($duracion_hrs) * 3600) + (intval($duracion_min) * 60) + intval($duracion_sec);

            $porcentaje = round(($progreso['segundos'] * 100) / $secs_totales);

            $card_congresos .= <<<html



            <div class="col-12 col-md-4 mt-3">
            <div class="card card-course p-0 border-radius-15">
                <div class="card-body " style="height:235px;">
                    <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                    <div class="caratula-content">
                       <!-- <a href="/Talleres/Video/{$value['clave']}"> -->
                            <img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">
                        <!--</a>-->
                        <!--<div class="duracion"><p>{$value['duracion']}</p></div>-->
                        <!--<button class="btn btn-outline-danger"></button-->
                        
html;
        
                    $like = TalleresDao::getlikeProductCurso($value['id_producto'], $_SESSION['user_id']);
                    if ($like['status'] == 1) {
                        $card_congresos .= <<<html
                    <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>
html;
                    } else {
                        $card_congresos .= <<<html
                    <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2"></span>
html;
                    }
        
                    $card_congresos .= <<<html
                       <!-- <div class="row">
                            <div class="col-11 m-auto" id="">
                                <progress class="barra_progreso_small mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                            </div>
                        </div>-->
                    </div>
                    <a href="/Talleres/Video/{$value['clave']}">
                        <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre']}</b></p>               
                        
        
                        <!--<p class="text-left mx-3 text-sm">{$value['fecha_curso']}
                            {$value['descripcion']}<br>
                            {$value['vistas']} vistas
                            <br> <br>
                            <b>Avance: $porcentaje %</b>
                        </p>-->
        
html;
                    if ($value['status'] == 2 || $porcentaje >= 80) {
                        $card_congresos .= <<<html
                            <!--<div class="ms-3 me-3 msg-encuesta px-2 py-1">Se ha habilitado un examen para este taller</div><br><br>-->
html;
                    }
        
                    $card_congresos .= <<<html
                    </a>
        
                    <div>
                        
                    </div>
                </div>
                <div class="card-footer">
                <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['precio_publico']}</b></p>
                <div style = "display: flex; justify-content:start">
                <p class="badge badge-success" style="margin-left: 5px;margin-bottom: 38px;">
                  Este curso ya lo compraste.
                </p>
               
            </div>
          </div>
                </div>
                
            </div>
        
            <script>
                // $('#video_{$value['clave']}').on('click', function(){
                //     let like = $('#video_{$value['clave']}').hasClass('heart-like');
                    
                //     if (like){
                //         $('#video_{$value['clave']}').removeClass('heart-like').addClass('heart-not-like')
                //     } else {
                //         $('#video_{$value['clave']}').removeClass('heart-not-like').addClass('heart-like')
                //     }
                // });
            </script>
html;
        }
        //FIN CONGRESOS COMPRADOS

        //CONGRESOS SIN COMPRAR

        $cursos = TalleresDao::getAllProductCongresosNotInUser($_SESSION['user_id']);
        $costoUser  = RegisterDao::getUserById($_SESSION['user_id'])[0]['amout_due'];        


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
                    //echo "pendiente pago";

                $card_congresos .= <<<html
    
    
                <div class="col-12 col-md-4 mt-3">
                    <div class="card card-course p-0 border-radius-15">
                        <div class="card-body " style="height:235px;">
                            <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                            <div class="caratula-content">
                                <!-- <a href="/Talleres/Video/{$value['clave']}"> -->
                                <img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">
                                <!--</a>-->
                                <!--<div class="duracion"><p>{$value['duracion']}</p></div>-->
                                <!--<button class="btn btn-outline-danger"></button-->
                
html;

                                $like = TalleresDao::getlikeProductCurso($value['id_producto'], $_SESSION['user_id']);
                                if ($like['status'] == 1) {
                                    $card_congresos .= <<<html
                                <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>
html;
                                } else {
                                    $card_congresos .= <<<html
                                <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2"></span>
html;
                                }

                $card_congresos .= <<<html
                                <!-- <div class="row">
                                        <div class="col-11 m-auto" id="">
                                            <progress class="barra_progreso_small mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                                        </div>
                                    </div>-->
                            </div>
                            <!--<a href="/Talleres/Video/{$value['clave']}">-->
                                <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre']}</b></p> 

                            <!--<p class="text-left mx-3 text-sm">{$value['fecha_curso']}
                                {$value['descripcion']}<br>
                                {$value['vistas']} vistas
                                <br> <br>
                                <b>Avance: $porcentaje %</b>
                            </p>-->

html;
                        if ($value['status'] == 2 || $porcentaje >= 80) {
                            $card_congresos .= <<<html
                                <!--<div class="ms-3 me-3 msg-encuesta px-2 py-1">Se ha habilitado un examen para este taller</div><br><br>-->
html;
            }
                $link_parametro_user_id = base64_encode($_SESSION['user_id']);
                $link_parametro_id_producto = base64_encode($value['id_producto']);

                $card_congresos .= <<<html
                            <!--</a>-->

                        <div>                
                    </div>
                </div>
                <div class="card-footer">
                    <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$costoUser} {$value['tipo_moneda']}</b></p>
                    <div style = "display: flex; justify-content:start">
                        <!--<button class="btn btn-primary" style="margin-right: 5px;margin-left: 5px; width:145px;" data-toggle="modal" data-target="#comprar-curso{$value['id_producto']}">Comprar</button>-->

                        <a class="btn btn-primary" href="/OrdenPago/impticket/{$link_parametro_user_id}/{$link_parametro_id_producto})" target="_blank" style="margin-right: 5px;margin-left: 5px; width:auto;">Reimprimir orden de pago</a>
       
                    </div>
                </div>
            </div>        
        </div>

        <script>
            // $('#video_{$value['clave']}').on('click', function(){
            //     let like = $('#video_{$value['clave']}').hasClass('heart-like');
                
            //     if (like){
            //         $('#video_{$value['clave']}').removeClass('heart-like').addClass('heart-not-like')
            //     } else {
            //         $('#video_{$value['clave']}').removeClass('heart-not-like').addClass('heart-like')
            //     }
            // });
        </script>
html;

                }else {
                    //echo "pagado";
                }
            }else{
                //echo "comprar";
                $card_congresos .= <<<html
    
    
                <div class="col-12 col-md-4 mt-3">
                    <div class="card card-course p-0 border-radius-15">
                        <div class="card-body " style="height:235px;">
                            <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                            <div class="caratula-content">
                                <!-- <a href="/Talleres/Video/{$value['clave']}"> -->
                                <img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">
                                <!--</a>-->
                                <!--<div class="duracion"><p>{$value['duracion']}</p></div>-->
                                <!--<button class="btn btn-outline-danger"></button-->
                
html;

                                $like = TalleresDao::getlikeProductCurso($value['id_producto'], $_SESSION['user_id']);
                                if ($like['status'] == 1) {
                                    $card_congresos .= <<<html
                                <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-like p-2"></span>
html;
                                } else {
                                    $card_congresos .= <<<html
                                <span id="video_{$value['clave']}" data-clave="{$value['clave']}" class="fas fa-heart heart-not-like p-2"></span>
html;
                                }

                $card_congresos .= <<<html
                                <!-- <div class="row">
                                        <div class="col-11 m-auto" id="">
                                            <progress class="barra_progreso_small mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                                        </div>
                                    </div>-->
                            </div>
                            <!--<a href="/Talleres/Video/{$value['clave']}">-->
                                <p style="font-size: 14px;" class="text-left mx-3 mt-2" style="color: black;"><b>{$value['nombre']}</b></p> 

                            <!--<p class="text-left mx-3 text-sm">{$value['fecha_curso']}
                                {$value['descripcion']}<br>
                                {$value['vistas']} vistas
                                <br> <br>
                                <b>Avance: $porcentaje %</b>
                            </p>-->

html;
                        if ($value['status'] == 2 || $porcentaje >= 80) {
                            $card_congresos .= <<<html
                                <!--<div class="ms-3 me-3 msg-encuesta px-2 py-1">Se ha habilitado un examen para este taller</div><br><br>-->
html;
            }

                $card_congresos .= <<<html
                            <!--</a>-->

                        <div>                
                    </div>
                </div>
                <div class="card-footer">
                    <p style="font-size: 23px; color: #2B932B;" class="text-left mx-3 mt-2" style="color: black;"><b>$ {$costoUser} {$value['tipo_moneda']}</b></p>
                    <div style = "display: flex; justify-content:start">
                        <button class="btn btn-primary" style="margin-right: 5px;margin-left: 5px; width:145px;" data-toggle="modal" data-target="#comprar-curso{$value['id_producto']}">Comprar</button>
       
                    </div>
                </div>
            </div>        
        </div>

        <script>
            // $('#video_{$value['clave']}').on('click', function(){
            //     let like = $('#video_{$value['clave']}').hasClass('heart-like');
                
            //     if (like){
            //         $('#video_{$value['clave']}').removeClass('heart-like').addClass('heart-not-like')
            //     } else {
            //         $('#video_{$value['clave']}').removeClass('heart-not-like').addClass('heart-like')
            //     }
            // });
        </script>
html;

            $cost = ['amout_due'=> $costoUser];
            $value = array_merge($value, $cost);
            // array_push($value, ['amout_due'=>$costoUser]);
            $modalComprar .= $this->generateModalComprar($value);
            }
        
        }

        //CONGRESOS SIN COMPRAR

        // $modalComprar = '';
        // foreach (TalleresDao::getAll() as $key => $value) {
        //     $modalComprar .= $this->generateModalComprar($value);
        // }

        View::set('header', $this->_contenedor->header($extraHeader));
        View::set('permisos_congreso', $permisos_congreso);
        View::set('datos', $data_user['datos']);
        View::set('card_cursos', $card_cursos);
        View::set('card_congresos', $card_congresos);
        View::set('modalComprar', $modalComprar);
        View::render("talleres_all");
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
        
       
        $modal = <<<html
        <div class="modal fade" id="comprar-curso{$datos['id_producto']}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="comprar-curso">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                Completa tu compra
                </h5>

                <span type="button" class="btn bg-gradient-danger" data-dismiss="modal" aria-label="Close">
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

                    <p class="text-center mt-3"><b>{$datos['nombre']}</b></p>

                    <p class="text-center" style="color: #2B932B;"><b>{$precio_curso}</b></p>
                    <input type="text" value="{$solo_precio_curso}" name="costo"/>
                    <input type="text" value="{$datos['tipo_moneda']}" name="tipo_moneda"/>
                    <input type="text" value="{$datos['id_producto']}" name="id_producto"/>
                    <input type="text" value="{$datos['nombre']}" name="nombre_curso"/>
                    <input type="text" class="tipo_pago" name="tipo_pago"/>

                    <div class="row d-flex justify-content-center">
                        <div class="col-4">
                            <label>Elige tu metodo de pago *</label>
                            <select class="multisteps-form__select form-control all_input_second_select metodo_pago" name="metodo_pago">
                                <option value="" disabled selected>Selecciona una Opción</option>
                                <option value="Paypal">Paypal</option>
                                <option value="Efectivo">Efectivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center mt-3">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary btn_comprar" style="width: 100%;" name="btn_tipo_pago" >Comprar</button>
                        </div>
                    </div>
                    
                    
                
                </div>
                <div class="col-md-4">
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      
html;



        return $modal;
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

        $curso = TalleresDao::getProductCursoByClave($clave);
        $contenido_taller = '';

        $permiso_taller = TalleresDao::getContenidoProdductCursoByAsignacion($_SESSION['user_id'], $clave);

        $progreso_curso = TalleresDao::getProductProgreso($_SESSION['user_id'], $curso['id_producto']);
        if ($progreso_curso) {
            $progreso_curso = TalleresDao::getProductProgreso($_SESSION['user_id'], $curso['id_producto']);
        } else {
            TalleresDao::insertProductCursoProgreso($_SESSION['user_id'], $curso['id_producto']);
            $progreso_curso = TalleresDao::getProductProgreso($_SESSION['user_id'], $curso['id_producto']);
        }

        $duracion = $curso['duracion'];

        $duracion_sec = substr($duracion, strlen($duracion) - 2, 2);
        $duracion_min = substr($duracion, strlen($duracion) - 5, 2);
        $duracion_hrs = substr($duracion, 0, strpos($duracion, ':'));

        $secs_totales = (intval($duracion_hrs) * 3600) + (intval($duracion_min) * 60) + intval($duracion_sec);

        $progreso_curso = TalleresDao::getProductProgreso($_SESSION['user_id'], $curso['id_producto']);
        if ($progreso_curso) {
            $progreso_curso = TalleresDao::getProductProgreso($_SESSION['user_id'], $curso['id_producto']);
        } else {
            TalleresDao::insertProductCursoProgreso($_SESSION['user_id'], $curso['id_producto']);
            $progreso_curso = TalleresDao::getProductProgreso($_SESSION['user_id'], $curso['id_producto']);
        }

        $porcentaje = round(($progreso_curso['segundos'] * 100) / $secs_totales);

        if ($curso) {
            $id_curso = TalleresDao::getProductCursoByClave($clave)['id_producto'];
            $url = TalleresDao::getProductCursoByClave($clave)['url'];
            $nombre_taller = TalleresDao::getProductCursoByClave($clave)['nombre'];
            $descripcion = TalleresDao::getProductCursoByClave($clave)['descripcion'];

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
                if ($curso['status'] == 2 || $porcentaje >= 80) {
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
            $data->_tipo = 2;
            $data->_sala = 1;
            $data->_id_tipo = $id_curso;

            $chat_taller = TransmisionDao::getNewChatByID($data);
            $cont_chat = '';
            $avatar = '';


            foreach ($chat_taller as $chat => $value) {
                $nombre_completo = $value['nombre'] . ' ' . $value['apellidop'] . ' ' . $value['apellidom'];
                $nombre_completo = utf8_encode($nombre_completo);
                $cont_chat .= <<<html
            <div class="d-flex mt-3">
                <div class="flex-shrink-0">
                    <img alt="Image placeholder" class="avatar rounded-circle" src="../../../img/users_musa/{$value['avatar_img']}">
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
            View::render("video_all");
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
        $data->_id_registrado = $_SESSION['id_registrado'];
        $data->_chat = $chat;
        $data->_tipo = 2; //taller
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
        $data->_tipo = 2;
        $data->_sala = $sala;
        $data->_id_tipo = $taller['id_curso'];

        $chat_taller = TransmisionDao::getNewChatByID($data);

        echo json_encode($chat_taller);
    }

    public function savePregunta()
    {
        $pregunta = $_POST['txt_pregunta'];
        $salapre = $_POST['salapre'];
        $id_tipopre = $_POST['id_tipopre'];



        $data = new \stdClass();
        $data->_id_registrado = $_SESSION['id_registrado'];
        $data->_pregunta = $pregunta;
        $data->_tipopre = 2;
        $data->_id_tipopre = $id_tipopre;
        $data->_salapre = $salapre;


        $id = TransmisionDao::insertPregunta($data);

        if ($id) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    
    public function guardarRespuestas()
    {
        $respuestas = $_POST['list_r'];
        $id_curso = $_POST['id_curso'];

        $ha_respondido = TalleresDao::getRespuestasCurso($_SESSION['user_id'], $id_curso);

        // var_dump($respuestas);
        $userData = RegisterDao::getUser($this->getUsuario())[0];

        // var_dump($userData['clave']);

        // exit;

        if ($ha_respondido) {
            // echo 'fail';
            $data = [
                'status' => 'success',
                'clave_user' => $userData['clave']
            ];
            echo json_encode($data);
        } else {
            foreach ($respuestas as $key => $value) {
                $id_pregunta = $value[0];
                $respuesta = $value[1];
                TalleresDao::insertRespuestaProductCurso($_SESSION['user_id'], $id_pregunta, $respuesta);
            }
            // echo 'success';
            $data = [
                'status' => 'success',
                'clave_user' => $userData['clave'],
                'href' => '/Talleres/abrirConstancia/' . $userData['clave'] . '/' . $id_curso,
                'href_download' => 'constancias/' . $userData['clave'] . $id_curso . '.pdf'
            ];
            echo json_encode($data);
        }
    }

    public function updateProgress()
    {
        $progreso = $_POST['segundos'];
        $curso = $_POST['curso'];

        TalleresDao::updateProgresoFecha($curso, $_SESSION['id_registrado'], $progreso);

        echo 'minuto ' . $progreso . ' ' . $curso;
    }

    public function Vistas()
    {
        $clave = $_POST['clave_video'];
        $vistas = TalleresDao::getCursoByClave($clave)['vistas'];
        $vistas++;

        TalleresDao::updateVistasByClave($clave, $vistas);

        echo $clave;
    }

    public function Likes()
    {
        $clave = $_POST['clave'];
        $id_curso = TalleresDao::getCursoByClave($clave)['id_curso'];

        $hay_like = TalleresDao::getlike($id_curso, $_SESSION['id_registrado']);
        // var_dump($hay_like);

        if ($hay_like) {
            $status = 0;
            if ($hay_like['status'] == 1) {
                $status = 0;
            } else if ($hay_like['status'] == 0) {
                $status = 1;
            }
            TalleresDao::updateLike($id_curso, $_SESSION['id_registrado'], $status);
            // echo 'siuu '.$clave;
        } else {
            TalleresDao::insertLike($id_curso, $_SESSION['id_registrado']);
            // echo 'nooouuu '.$clave;
        }
    }

    public function uploadComprobante()
    {

        $documento = new \stdClass();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $marca_ = '';
            $usuario = $_POST["user_"];
            $numero_dosis = $_POST['numero_dosis'];
            foreach ($_POST['checkbox_marcas'] as $selected) {
                $marca_ = $selected . "/ ";
            }
            $marca = $marca_;
            $file = $_FILES["file_"];

            $pdf = $this->generateRandomString();

            move_uploaded_file($file["tmp_name"], "comprobante_vacunacion/" . $pdf . '.pdf');

            $documento->_url = $pdf . '.pdf';
            $documento->_user = $usuario;
            $documento->_numero_dosis = $numero_dosis;
            $documento->_marca_dosis = $marca;

            $id = TalleresDao::insert($documento);

            if ($id) {
                echo 'success';
            } else {
                echo 'fail';
            }
        } else {
            echo 'fail REQUEST';
        }
    }

    function generateRandomString($length = 10)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    
}
