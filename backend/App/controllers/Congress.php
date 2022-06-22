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

        // $card_permisos = HomeDao::getCountByUser($_SESSION['utilerias_asistentes_id']);
        //$pickup_permisos = HomeDao::getCountPickUp($_SESSION['utilerias_asistentes_id']);
        $tabla = '';

        //foreach ($pickup_permisos as $key => $value) {
        //    if ($value['count'] >= 0) {
        //        $tabla.= <<<html
        //        aaaaaaas
//html;
  //          } else {
    //            $tabla.= <<<html
    //            ssssss
//html;

          //  }
        //}

        $data_user = HomeDao::getDataUser($this->__usuario);
    
        View::set('header',$this->_contenedor->header($extraHeader));      
        View::set('datos',$data_user);
        //View::set('tabla',$tabla);
        View::render("congreso_all");
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
                $nombre_completo = $value['name_user'] . ' ' . $value['surname'] . ' ' . $value['second_surname'];
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
            View::render("video_all_congreso");
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

    public function generateModalComprar($datos){
        $modal = <<<html
        <div class="modal fade" id="comprar-curso{$datos['id_curso']}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                Comprar curso
                </h5>

                <span type="button" class="btn bg-gradient-danger" data-dismiss="modal" aria-label="Close">
                    X
                </span>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
html;
                                
                              

        return $modal;
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
    
    public function savePregunta()
    {
        $pregunta = $_POST['txt_pregunta'];
        $sala = $_POST['sala'];
        $id_tipo = $_POST['id_tipo'];

        $data = new \stdClass();
        $data->_id_registrado = $_SESSION['user_id'];
        $data->_pregunta = $pregunta;
        $data->_tipo = 2; //taller
        $data->_id_tipo = $id_tipo;
        $data->_sala = $sala;

        $id = TransmisionDao::insertNewPregunta($data);

        if ($id) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    public function getPreguntaById()
    {
        $id_tipo = $_POST['id_tipo'];
        $sala = $_POST['sala'];

        $taller = TalleresDao::getPorductById($id_tipo);
        $data = new \stdClass();
        $data->_tipo = 2;
        $data->_sala = $sala;
        $data->_id_tipo = $taller['id_producto'];

        $pregunta_taller = TransmisionDao::getNewPreguntaByID($data);

        echo json_encode($pregunta_taller);
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

}
