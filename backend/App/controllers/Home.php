<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\Controller;
use \App\models\Home AS HomeDao;
use App\models\RegistroAcceso as RegistroAccesoDao;
use \App\models\Talleres as TalleresDao;

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
   
           $id_curso = 100;
   
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

    function getItinerario(){
      $id_asis = $_POST['id'];
      $asistenteItinerario = HomeDao::getItinerarioAsistente($id_asis)[0];
      echo json_encode($asistenteItinerario);
    }

}
