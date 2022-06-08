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
        $modalComprar = '';

        $permisos_congreso = $data_user['congreso'] != '1' ? "style=\"display:none;\"" : "";

        // $usuarios = HomeDao::getAllUsers();
        // $free_courses = HomeDao::getFreeCourses();


        // foreach ($free_courses as $key => $value) {
        //     // HomeDao::insertCursos($_SESSION['id_registrado'],$value['id_curso']);
        //     $hay = HomeDao::getAsignaCursoByUser($_SESSION['id_registrado'],$value['id_curso']);
        //     // var_dump($hay);
        //     if ($hay == NULL || $hay == 'NULL ') {
        //       HomeDao::insertCursos($_SESSION['id_registrado'],$value['id_curso']);
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
            

            
            
            <div class="col-12 col-md-3 mt-3">
                <div class="card card-body card-course p-0 border-radius-15" style="height:600px;">
                    <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                    <div class="caratula-content">
                        <a href="/Talleres/Video/{$value['clave']}">
                            <img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">
                        </a>
                        <!--<div class="duracion"><p>{$value['duracion']}</p></div>-->
                        <!--button class="btn btn-outline-danger"></button-->
                        
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
                        <!--<div class="row">
                            <div class="col-11 m-auto" id="">
                                <progress class="barra_progreso_small mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                            </div>
                        </div>-->
                    </div>
                    <a href="/Talleres/Video/{$value['clave']}">
                        <h6 class="text-left mx-3 mt-2" style="color: black;">{$value['nombre']}</h3>
                        <p class="badge badge-success" style="margin-left: 5px;">
                          Este curso ya lo compraste.
                        </p>
                        

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

            $card_cursos .= <<<html
            
            
            <div class="col-12 col-md-3 mt-3">
                <div class="card card-body card-course p-0 border-radius-15" style="height:600px;">
                    <input class="curso" hidden type="text" value="{$value['clave']}" readonly>
                    <div class="caratula-content">
                        <a href="/Talleres/Video/{$value['clave']}">
                            <img class="caratula-img border-radius-15" src="/caratulas/{$value['caratula']}" style="object-fit: cover; object-position: center center; height: auto;">
                        </a>
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
                        <h6 class="text-left mx-3 mt-2" style="color: black;">{$value['nombre']}</h3>
                        <div style = "display: flex; justify-content:start">
                            <button class="btn btn-primary" style="margin-right: 5px;margin-left: 5px;" data-toggle="modal" data-target="#comprar-curso{$value['id_curso']}">Comprar</button>
                           
                        </div>
                        

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

        //CURSOS SIN COMPRAR

        // $modalComprar = '';
        // foreach (TalleresDao::getAll() as $key => $value) {
        //     $modalComprar .= $this->generateModalComprar($value);
        // }

        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('permisos_congreso',$permisos_congreso);
        View::set('datos',$data_user);
        View::set('card_cursos', $card_cursos);
        View::set('modalComprar',$modalComprar);
        //View::set('tabla',$tabla);
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
