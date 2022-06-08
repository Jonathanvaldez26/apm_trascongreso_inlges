<?php
namespace App\controllers;

use \Core\View;
use \Core\Controller;
use \App\models\Profesores AS ProfesoresDao;

class Profesores extends Controller{

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
html;
        $extraFooter =<<<html
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
                      url:"/Profesores/uploadComprobante",
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
                              window.location.replace("/Profesores/");
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

        $prof_nacional = ProfesoresDao::getAll();
        $prof_internacional = ProfesoresDao::getAllInternacional();

        $card_profesores_nacionales = '';
        $card_profesores_internacionales = '';


        foreach ($prof_nacional as $key => $value) {
            $card_profesores_nacionales .= <<<html
            
            <div class="col-12 col-md-3 text-center">
            <br>
                <div class="card card-body card-course p-0 border-radius-15">
                    <input class="curso" hidden type="text" value="{$value['id_profesor']}" readonly>
                        <img class="profesor-img" src="/profesores_img/{$value['img']}.png">
                        <!--<div class="mt-2 color-vine font-14 text-bold"><p><b>{$value['prefijo']} {$value['nombre']}</b></p></div>-->
                        <!--<div class="color-vine font-12" style="color:#0F978D;"><p style="color:#0F978D; font-size:11px;">{$value['descripcion']}</p></div>-->
                </div>
            </div>
html;
        }

        foreach ($prof_internacional as $key => $value) {
            $card_profesores_internacionales .= <<<html
            
            <div class="col-12 col-md-3 text-center">
            <br>
                <div class="card card-body card-course p-0 border-radius-15">
                    <input class="curso" hidden type="text" value="{$value['id_profesor']}" readonly>
                        <img class="profesor-img" src="/profesores_img/{$value['img']}.png">
                        <!--<div class="mt-2 color-vine font-14 text-bold"><p><b>{$value['prefijo']} {$value['nombre']}</b></p></div>-->
                        <!--<div class="color-vine font-12" style="color:#0F978D;"><p style="color:#0F978D; font-size:11px;">{$value['descripcion']}</p></div>-->
                </div>
            </div>
html;
        }

        View::set('card_profesores_nacionales',$card_profesores_nacionales);
        View::set('card_profesores_internacionales',$card_profesores_internacionales);
        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$this->_contenedor->footer($extraFooter));
        View::render("profesores_all");
    }

    function generateRandomString($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

}