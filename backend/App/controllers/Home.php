<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");
require_once dirname(__DIR__) . '/../public/librerias/fpdf/fpdf.php';

use \Core\View;
use \Core\Controller;
use \App\models\Home AS HomeDao;
use App\models\RegistroAcceso as RegistroAccesoDao;
use \App\models\Talleres as TalleresDao;
use \App\models\General as GeneralDao;

class Home extends Controller{

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
   
           $permisos_congreso = $data_user['congreso'] != '1' ? "style=\"display:none;\"" : "";
   
           $id_curso = 102;
   
           $encuesta = '';
   
           $preguntas  = TalleresDao::getPreguntasTriviaUsuario($id_curso);
           $ha_respondido = TalleresDao::getRespuestasCurso($_SESSION['user_id'], $id_curso);
   
           if ($preguntas) {
   
               $num_pregunta = 1;
   
               if ($ha_respondido) {
   
                   foreach ($preguntas as $key => $value) {
                       $opcion1 = $value['opcion1_ingles'];
                       $opcion2 = $value['opcion2_ingles'];
                       $opcion3 = $value['opcion3_ingles'];
                       $opcion4 = $value['opcion4_ingles'];
   
                       $encuesta .= <<<html
                       <div class="col-12 encuesta_completa">
                           <div class="mb-3 text-dark">
                               <h6 class="">$num_pregunta. {$value['pregunta_ingles']}</h6>
                           </div>
                           <input id="id_pregunta_$num_pregunta" value="{$value['id_pregunta_encuesta']}" hidden readonly>
                           <div class="form-group encuesta_curso_$num_pregunta">
html;
                       if ($value['respuesta_correcta'] == 1) {
                           $encuesta .= <<<html
                           <div id="op1">
                               <input type="radio" data-label="{$value['opcion1_ingles']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                               <label class="text-success form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1_ingles']}</label>
                           </div>
   
                           <div id="op2">
                               <input type="radio" data-label="{$value['opcion2_ingles']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2_ingles']}</label>
                           </div>
   
                           <div id="op3">
                               <input type="radio" data-label="{$value['opcion3_ingles']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3_ingles']}</label>
                           </div>
   
                           <div id="op4">
                               <input type="radio" data-label="{$value['opcion4_ingles']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4_ingles']}</label>
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
                               <input type="radio" data-label="{$value['opcion1_ingles']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1_ingles']}</label>
                           </div>
   
                           <div id="op2">
                               <input type="radio" data-label="{$value['opcion2_ingles']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                               <label class="text-success form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2_ingles']}</label>
                           </div>
   
                           <div id="op3">
                               <input type="radio" data-label="{$value['opcion3_ingles']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3_ingles']}</label>
                           </div>
   
                           <div id="op4">
                               <input type="radio" data-label="{$value['opcion4_ingles']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4_ingles']}</label>
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
                               <input type="radio" data-label="{$value['opcion1_ingles']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1_ingles']}</label>
                           </div>
   
                           <div id="op2">
                               <input type="radio" data-label="{$value['opcion2_ingles']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2_ingles']}</label>
                           </div>
   
                           <div id="op3">
                               <input type="radio" data-label="{$value['opcion3_ingles']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                               <label class="text-success form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3_ingles']}</label>
                           </div>
   
                           <div id="op4">
                               <input type="radio" data-label="{$value['opcion4_ingles']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4_ingles']}</label>
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
                               <input type="radio" data-label="{$value['opcion1_ingles']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1_ingles']}</label>
                           </div>
   
                           <div id="op2">
                               <input type="radio" data-label="{$value['opcion2_ingles']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2_ingles']}</label>
                           </div>
   
                           <div id="op3">
                               <input type="radio" data-label="{$value['opcion3_ingles']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3_ingles']}</label>
                           </div>
   
                           <div id="op4">
                               <input type="radio" data-label="{$value['opcion4_ingles']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                               <label class="text-success form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4_ingles']}</label>
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
                               <input type="radio" data-label="{$value['opcion1_ingles']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1_ingles']}</label>
                           </div>
   
                           <div id="op2">
                               <input type="radio" data-label="{$value['opcion2_ingles']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2_ingles']}</label>
                           </div>
   
                           <div id="op3">
                               <input type="radio" data-label="{$value['opcion3_ingles']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3_ingles']}</label>
                           </div>
   
                           <div id="op4">
                               <input type="radio" data-label="{$value['opcion4_ingles']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4" disabled>
                               <label class="text-dark form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4_ingles']}</label>
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
                               <h6 class="">$num_pregunta. {$value['pregunta_ingles']}</h6>
                           </div>
                           <input id="id_pregunta_$num_pregunta" value="{$value['id_pregunta_encuesta']}" hidden readonly>
                           <div class="form-group encuesta_curso_$num_pregunta">
                               <div id="op1">
                                   <input type="radio" data-label="{$value['opcion1_ingles']}" id="opcion1_$num_pregunta" name="pregunta_$num_pregunta" value="1" required>
                                   <label class="form-label opcion-encuesta" for="opcion1_$num_pregunta">{$value['opcion1_ingles']}</label>
                               </div>
   
                               <div id="op2">
                                   <input type="radio" data-label="{$value['opcion2_ingles']}" id="opcion2_$num_pregunta" name="pregunta_$num_pregunta" value="2">
                                   <label class="form-label opcion-encuesta" for="opcion2_$num_pregunta">{$value['opcion2_ingles']}</label>
                               </div>
   
                               <div id="op3">
                                   <input type="radio" data-label="{$value['opcion3_ingles']}" id="opcion3_$num_pregunta" name="pregunta_$num_pregunta" value="3">
                                   <label class="form-label opcion-encuesta" for="opcion3_$num_pregunta">{$value['opcion3_ingles']}</label>
                               </div>
   
                               <div id="op4">
                                   <input type="radio" data-label="{$value['opcion4_ingles']}" id="opcion4_$num_pregunta" name="pregunta_$num_pregunta" value="4">
                                   <label class="form-label opcion-encuesta" for="opcion4_$num_pregunta">{$value['opcion4_ingles']}</label>
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
           } 
   else {
               $encuesta = <<<html
               <h3 class="text-danger">Aún no hay preguntas para este Curso.</h3>
html;
           }
   
           View::set('header',$this->_contenedor->header($extraHeader));
           View::set('footer', $this->_contenedor->footer($extraFooter));
           View::set('permisos_congreso',$permisos_congreso);
           View::set('datos',$data_user);
           View::set('encuesta',$encuesta);
           View::set('id_curso',$id_curso);
           View::render("principal_all");
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

    public function abrirConstanciaDigital($clave, $id_producto, $no_horas = NULL)
    {

        // $this->generaterQr($clave_ticket);
        // echo $clave;

        $no_horas = base64_decode($no_horas);

        $productos = HomeDao::getProductosById($id_producto);
        $progresos_productos = HomeDao::getProgresosById($id_producto,$clave);
        $progresos_productos_congreso = HomeDao::getProgresosCongresoById($id_producto,$clave);

        // echo $progresos_productos_congreso['segundos'];
        // exit;

        $nombre_constancia = $productos['nombre_ingles'];

        if ($id_producto == 1) {
            $attend = '';
            $progreso = $progresos_productos_congreso;
            $nombre_constancia = '';
            $fecha = 'June, 21 to 24, 2022';
        } 
        else if ($id_producto == 2) {
            $attend = 'Trans-Congress Course I';
            $progreso = $progresos_productos;
            $fecha = 'Tuesday 21st June, 2022';
        } else if ($id_producto == 3) {
            $attend = 'Trans-Congress Course II';
            $progreso = $progresos_productos;
            $fecha = 'Tuesday 21st June, 2022';
        } else if ($id_producto == 4) {
            $attend = 'Trans-Congress Course III';
            $progreso = $progresos_productos;
            $fecha = 'Tuesday 21st June, 2022';
        } else if ($id_producto == 5) {
            $attend = 'Trans-Congress Course IV';
            $progreso = $progresos_productos;
            $fecha = 'Tuesday 21st June, 2022';
        } else if ($id_producto == 6) {
            $attend = 'Trans-Congress Course V';
            $progreso = $progresos_productos;
            $fecha = 'Tuesday 21st June, 2022';
        } 
        else if ($id_producto == 7) {
            $attend = 'Trans-Congress Course VI';
            // $nombre_imagen = 'constancia_transcongreso_7.png';
            $progreso = $progresos_productos;
            $fecha = 'Thursday 23 June, 2022';
        } else if ($id_producto == 8) {
            $attend = 'Trans-Congress Course VII';
            // $nombre_imagen = 'constancia_transcongreso_8.png';
            $progreso = $progresos_productos;
            $fecha = 'Thursday 23 June, 2022';
        } else if ($id_producto == 9) {
            $attend = 'Trans-Congress Course VIII';
            // $nombre_imagen = 'constancia_transcongreso_9.png';
            $progreso = $progresos_productos;
            $fecha = 'Friday 24th, June, 2022';
        }

        $datos_user = GeneralDao::getUserRegisterByClave($clave,$id_producto)[0];

        // $nombre = explode(" ", $datos_user['nombre']);

        // $nombre_completo = $datos_user['prefijo'] . " " . $nombre[0] . " " . $datos_user['apellidop']. " " . $datos_user['apellidom'];
        $nombre_completo = $datos_user['name_user']." ".$datos_user['middle_name']." ".$datos_user['surname']." ".$datos_user['second_surname'];
        $nombre_completo = mb_strtoupper($nombre_completo);

        $nombre = html_entity_decode($datos_user['name_user']);
        $segundo_nombre = html_entity_decode($datos_user['middle_name']);
        $apellido = html_entity_decode($datos_user['surname']);
        $segundo_apellido = html_entity_decode($datos_user['second_surname']);
        $nombre_completo = ($nombre)." ".($segundo_nombre)." ".($apellido)." ".($segundo_apellido);
        $nombre_completo = mb_strtoupper($nombre_completo);

        // echo $nombre_completo;
        // exit;
        $insert_impresion_constancia = HomeDao::insertImpresionConstanciaUser($datos_user['user_id'],'Digital',$id_producto,$no_horas);
        

        $pdf = new \FPDF($orientation = 'L', $unit = 'mm', $format = 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
        $pdf->setY(1);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Image('constancias/plantillas/constancia_congreso_1.jpeg', 0, 0, 296, 210);
        // $pdf->Image('constancias/plantillas/'.$nombre_imagen, 0, 0, 296, 210);
        // $pdf->SetFont('Arial', 'B', 25);
        // $pdf->Multicell(133, 80, $clave_ticket, 0, 'C');

        //$pdf->Image('1.png', 1, 0, 190, 190);
        $pdf->SetFont('Arial', 'B', 5);    //Letra Arial, negrita (Bold), tam. 20
        //$nombre = utf8_decode("Jonathan Valdez Martinez");
        //$num_linea =utf8_decode("Línea: 39");
        //$num_linea2 =utf8_decode("Línea: 39");
        
        if($id_producto == 1){
            $pdf->SetXY(15, 80);
            
            $pdf->SetFont('Arial', 'B', 30);
            #4D9A9B
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Multicell(273, 30, utf8_decode($nombre_completo), 0, 'C');
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->Multicell(275, 25, utf8_decode('Attended the:'), 0, 'C');
            $pdf->SetFont('Arial', '',20);
            if($id_producto == 1){
                $pdf->Multicell(275, 10, utf8_decode($attend).' '.utf8_decode("$nombre_constancia").' ', 0, 'C');
            }else{
            $pdf->Multicell(275, 10, utf8_decode($attend).' "'.utf8_decode("$nombre_constancia").'"', 0, 'C');
            }
            // $pdf->SetFont('Arial', 'B',10);
            // $pdf->SetXY(156, 170.5);
            // $pdf->Multicell(10, 10, utf8_decode(round($progreso['segundos']/3600)), 0, 'C');
            //TIEMPO
            $pdf->SetFont('Arial', 'B',10);
            $pdf->SetXY(157, 170.5);
            $pdf->Multicell(10, 10, utf8_decode($no_horas), 0, 'C');
            $pdf->SetFont('Arial', '',10);
            $pdf->SetXY(13, 175);
            $pdf->Multicell(275, 10, utf8_decode($fecha), 0, 'C');
            $pdf->Output();
            }
            else{
            $pdf->SetXY(15, 66);
            
            $pdf->SetFont('Arial', 'B', 30);
            #4D9A9B
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Multicell(273, 20, utf8_decode($nombre_completo), 0, 'C');
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->Multicell(275, 20, utf8_decode('Attended the:'), 0, 'C');
            $pdf->SetFont('Arial', '',20);
            if($id_producto == 1){
                $pdf->Multicell(275, 10, utf8_decode($attend).' '.utf8_decode("$nombre_constancia").' ', 0, 'C');
            }else{
            $pdf->Multicell(275, 10, utf8_decode($attend).' "'.utf8_decode("$nombre_constancia").'"', 0, 'C');
            }
            // $pdf->SetFont('Arial', 'B',10);
            // $pdf->SetXY(156, 170.5);
            // $pdf->Multicell(10, 10, utf8_decode(round($progreso['segundos']/3600)), 0, 'C');
            //TIEMPO
            $pdf->SetFont('Arial', 'B',10);
            $pdf->SetXY(156, 170.5);
            $pdf->Multicell(10, 10, utf8_decode($no_horas), 0, 'C');
            //FECHA
            $pdf->SetFont('Arial', '',10);
            $pdf->SetXY(13, 175);
            $pdf->Multicell(275, 10, utf8_decode($fecha), 0, 'C');
            $pdf->Output();
                
            }
        // $pdf->Output('F','constancias/'.$clave.$id_curso.'.pdf');

        // $pdf->Output('F', 'C:/pases_abordar/'. $clave.'.pdf');
    }

    function getItinerario(){
      $id_asis = $_POST['id'];
      $asistenteItinerario = HomeDao::getItinerarioAsistente($id_asis)[0];
      echo json_encode($asistenteItinerario);
    }

}
