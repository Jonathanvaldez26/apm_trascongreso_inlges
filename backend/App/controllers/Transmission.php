<?php

namespace App\controllers;

use App\models\General;
use \Core\View;
use \Core\Controller;
use \App\models\Transmision as TransmisionDao;
use \App\models\Data as DataDao;

class Transmission extends Controller
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
                      url:"/Transmision/uploadComprobante",
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
                              window.location.replace("/Transmision/");
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

       
       


        $transmision_1 = TransmisionDao::getTransmisionById(1);
        $transmision_2 = TransmisionDao::getTransmisionById(2);

        $transmision_1_p1 = TransmisionDao::getTransmisionById(1);
        $transmision_2_p2 = TransmisionDao::getTransmisionById(2);

        $data_p1 = new \stdClass();
        $data_p1->_tipo = 1;
        $data_p1->_sala = 1;
        $data_p1->_id_tipo = $transmision_1_p1['id_transmision'];

        $data_p2 = new \stdClass();
        $data_p2->_tipo = 1;
        $data_p2->_sala = 2;
        $data_p2->_id_tipo = $transmision_2_p2['id_transmision'];

        //$pregunta_transmision_1 = TransmisionDao::getPreguntaById($data_p1);



        $data_1 = new \stdClass();
        $data_1->_tipo = 1;
        $data_1->_sala = 1;
        $data_1->_id_tipo = $transmision_1['id_transmision'];

        $chat_transmision_1 = TransmisionDao::getChatByID($data_1);
        $cont_chat_1 = '';

        foreach ($chat_transmision_1 as $chat => $value) {
            $nombre_completo = $value['nombre'] . ' ' . $value['apellidop'] . ' ' . $value['apellidom'];
            $cont_chat_1 .= <<<html
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
        }

        $data_2 = new \stdClass();
        $data_2->_tipo = 1;
        $data_2->_sala = 2;
        $data_2->_id_tipo = $transmision_2['id_transmision'];

        $chat_transmision_2 = TransmisionDao::getChatByID($data_2);
        $cont_chat_2 = '';


        foreach ($chat_transmision_2 as $chat => $value) {
            $nombre_completo = $value['nombre'] . ' ' . $value['apellidop'] . ' ' . $value['apellidom'];
            $cont_chat_2 .= <<<html
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
        }

        $secs_t1 = TransmisionDao::getProgrsoTransmision($_SESSION['id_registrado'], $transmision_1['id_transmision']);
        $secs_t2 = TransmisionDao::getProgrsoTransmision($_SESSION['id_registrado'], $transmision_2['id_transmision']);

        if ($secs_t1) {
            $secs_t1 = TransmisionDao::getProgrsoTransmision($_SESSION['id_registrado'], $transmision_1['id_transmision']);
        } else {
            TransmisionDao::insertProgreso($_SESSION['id_registrado'], $transmision_1['id_transmision']);
            $secs_t1 = TransmisionDao::getProgrsoTransmision($_SESSION['id_registrado'], $transmision_1['id_transmision']);
        }

        if ($secs_t2) {
            $secs_t2 = TransmisionDao::getProgrsoTransmision($_SESSION['id_registrado'], $transmision_2['id_transmision']);
        } else {
            TransmisionDao::insertProgreso($_SESSION['id_registrado'], $transmision_2['id_transmision']);
            $secs_t2 = TransmisionDao::getProgrsoTransmision($_SESSION['id_registrado'], $transmision_2['id_transmision']);
        }

        $info_user = DataDao::getInfoUserById($_SESSION['id_registrado']);

        View::set('transmision_1', $transmision_1);
        View::set('transmision_2', $transmision_2);
        View::set('chat_transmision_1', $cont_chat_1);
        View::set('chat_transmision_2', $cont_chat_2);
        // View::set('chat_transmision_2',$chat_transmision_2);

        View::set('secs_t1', $secs_t1);
        View::set('secs_t2', $secs_t2);
        View::set('info_user', $info_user);
        View::set('header', $this->_contenedor->header($extraHeader));
        View::set('footer', $extraFooter);
        View::render("transmission");
    }

    public function getChatById()
    {
        $id_tipo = $_POST['id_tipo'];
        $sala = $_POST['sala'];

        $transmision = TransmisionDao::getTransmisionById($id_tipo);
        $data = new \stdClass();
        $data->_tipo = 1;
        $data->_sala = $sala;
        $data->_id_tipo = $transmision['id_transmision'];

        $chat_transmision = TransmisionDao::getChatByID($data);

        echo json_encode($chat_transmision);
    }

    public function updateProgress()
    {
        $progreso = $_POST['segundos'];
        $transmision = $_POST['transmision'];

        TransmisionDao::updateProgreso($transmision, $_SESSION['id_registrado'], $progreso);

        echo $progreso . ' ID_Tr: ' . $transmision;
    }


    public function savePregunta()
    {
        $pregunta = $_POST['txt_pregunta'];
        $salapre = $_POST['salapre'];
        $id_tipopre = $_POST['id_tipopre'];

      

        $data = new \stdClass();
        $data->_id_registrado = $_SESSION['id_registrado'];
        $data->_pregunta = $pregunta;
        $data->_tipopre = 1;
        $data->_id_tipopre = $id_tipopre;
        $data->_salapre = $salapre;


        $id = TransmisionDao::insertPregunta($data);

        if ($id) {
            echo "success";
        } else {
            echo "fail";
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
        $data->_tipo = 1;
        $data->_id_tipo = $id_tipo;
        $data->_sala = $sala;


        $id = TransmisionDao::insertChat($data);

        if ($id) {
            echo "success";
        } else {
            echo "fail";
        }
    }

    public function updateProgressWithDate()
    {
        $progreso = $_POST['segundos'];
        $transmision = $_POST['transmision'];

        TransmisionDao::updateProgresoFecha($transmision, $_SESSION['id_registrado'], $progreso);

        echo $progreso . ' ID_Tr: ' . $transmision;
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

            $id = TransmisionDao::insert($documento);

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
