<?php
namespace App\controllers;

use \Core\View;
use \Core\Controller;
use \App\models\Programa AS ProgramaDao;

class Programa extends Controller{

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
                      url:"/Programa/uploadComprobante",
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
                              window.location.replace("/Programa/");
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

        // ----- Variables para la primer fecha ----- //
        $info_fecha1 = ProgramaDao::getSectionByDate('2022-05-18');
        $programa_fecha1 = '';

        $programa_fecha1 = <<<html
        
        <br>     
        <br>       
html;

        foreach ($info_fecha1 as $key => $value) {
            $progreso = ProgramaDao::getProgreso($_SESSION['id_registrado'],$value['id_programa']);

            $hora_inicio =substr($value['hora_inicio'],0,strlen($value['hora_inicio'])-3);
            $hora_fin = substr($value['hora_fin'],0,strlen($value['hora_fin'])-3);

            $max_time = $value['duracion'];
            $duracion_sec = substr($max_time,strlen($max_time)-2,2);
            $duracion_min = substr($max_time,strlen($max_time)-5,2);
            $duracion_hrs = substr($max_time,0,strpos($max_time,':'));

            $secs_totales = (intval($duracion_hrs)*3600)+(intval($duracion_min)*60)+intval($duracion_sec);

            $porcentaje = round(($progreso['segundos']*100)/$secs_totales);


            if($value['id_coordinador'] != '' || $value['id_coordinador'] != 0){
                $coordinador_1 = <<<html
                <span class="color-vine font-14 text-bold">
                    Coordinador:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador']} {$value['nombre_coordinador']}
                </span>
                <br>
html;

            }else{
                $coordinador_1 = '';
            }


            $programa_fecha1 .= <<<html
                <div class="row mb-3">
                    <div class="col-12 col-md-2">
                        <span class="color-yellow text-bold">
                            {$hora_inicio} - {$hora_fin}
                        </span>
                    </div>
                    <div class="col-12 col-md-6">
                        <!--<a href="/Programa/Video/{$value['clave']}">-->
                            <span class="color-green text-bold font-20 text-lg">
                                {$value['descripcion']}
                            </span>
                            <br><br>
                            <span class="text-bold font-14 text-lg">
                            {$value['subtitulo']}
                            </span>
                            <br><br>
                            <span class="text-bold font-14 text-lg">
                                {$value['descripcion_subtitulo']}
                            </span>
                            <br><br>
                            <!--<span class="mt-4">
                                <b>Progreso: $porcentaje %</b>
                                <progress class="barra_progreso_small_green mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                            </span>-->
                        <!--</a>-->
                    </div>
                    <div class="col-12 col-md-4">
                        {$coordinador_1}
                        <span class="color-vine font-14 text-bold">
                            Profesor:
                        </span>
                        <br>
                        <span class="color-vine font-14 text-bold">
                            {$value['prefijo']} {$value['nombre_profesor']}
                        </span>
                        <p class="color-vine font-12 mb-0 text-sm">
                            {$value['desc_profesor']}
                        </p>
                    </div>
                </div>
html;
        }

        // ----- Variables para la segunda fecha ----- //
        $info_fecha2 = ProgramaDao::getSectionByDate('2022-05-19');
        $programa_fecha2 = <<<html
        
        <h5 class="mb-3 text-center">Jueves 19 de Mayo</h5>    
html;

        foreach ($info_fecha2 as $key => $value) {
            $progreso = ProgramaDao::getProgreso($_SESSION['id_registrado'],$value['id_programa']);

            $hora_inicio =substr($value['hora_inicio'],0,strlen($value['hora_inicio'])-3);
            $hora_fin = substr($value['hora_fin'],0,strlen($value['hora_fin'])-3);

            $max_time = $value['duracion'];
            $duracion_sec = substr($max_time,strlen($max_time)-2,2);
            $duracion_min = substr($max_time,strlen($max_time)-5,2);
            $duracion_hrs = substr($max_time,0,strpos($max_time,':'));

            $secs_totales = (intval($duracion_hrs)*3600)+(intval($duracion_min)*60)+intval($duracion_sec);

            $porcentaje = round(($progreso['segundos']*100)/$secs_totales);

            $coordinador_1 = '';

            if($value['id_coordinador'] != 0){
                $coordinador_1 = <<<html
                <span class="color-vine font-14 text-bold">
                    {$value['tipo_coordinador']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador']} {$value['nombre_coordinador']}
                </span>
                <br>
html;

            }

            $coordinador_2 = '';

            if($value['id_coordinador_2'] != 0){
                $coordinador_2 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_coordinador_2']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador_2']} {$value['nombre_coordinador_2']}
                </span>
                <br>
html;

            }

            $coordinador_3 = '';

            if($value['id_coordinador_3'] != 0){
                $coordinador_3 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_coordinador_3']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador_3']} {$value['nombre_coordinador_3']}
                </span>
                <br>
html;

            }


            $profesor_1 = '';

            if($value['id_profesor'] != 0){
                $profesor_1 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_profesor']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo']} {$value['nombre_profesor']}
                </span>
                <p class="color-vine font-12 mb-0 text-sm">
                    {$value['desc_profesor']}
                </p>
html;

            }

            $profesor_2 = '';

            if($value['id_profesor_2'] != 0){
                $profesor_2 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_profesor_2']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_2']} {$value['nombre_profesor_2']}
                </span>
                <p class="color-vine font-12 mb-0 text-sm">
                    {$value['desc_profesor_2']}
                </p>
html;

            }

            $profesor_3 = '';

            if($value['id_profesor_3'] != 0){
                $profesor_3 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_profesor_3']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_3']} {$value['nombre_profesor_3']}
                </span>
                <p class="color-vine font-12 mb-0 text-sm">
                    {$value['desc_profesor_3']}
                </p>
html;

            }


            if($value['id_programa'] == '108'){
                $simposio = <<<html
                <span class="color-yellow text-bold">
                            {$hora_inicio}
                </span>
                <br>
html;
            }
            else{
                $simposio = <<<html
                <span class="color-yellow text-bold">
                            {$hora_inicio} - {$hora_fin}
                </span>
                <br>
html;
            }


            $programa_fecha2 .= <<<html
                <div class="row mb-3">
                    <div class="col-12 col-md-2">
                        {$simposio}
                    </div>
                    <div class="col-12 col-md-6">
                    <!--<a href="/Programa/Video/{$value['clave']}">-->
                            <span class="color-green text-bold font-20 text-lg">
                                {$value['descripcion']}
                            </span>
                            <br><br>
                            <span class="text-bold font-14 text-lg">
                            {$value['subtitulo']}
                            </span>
                            <br><br>
                            <span class="text-bold font-14 text-lg">
                                {$value['descripcion_subtitulo']}
                            </span>
                            <br><br>
                            <!--<span class="mt-4">
                                <b>Progreso: $porcentaje %</b>
                                <progress class="barra_progreso_small_green mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                            </span>-->
                    <!--</a>-->
                    </div>
                    <div class="col-12 col-md-4">
                        {$coordinador_1}
                        {$coordinador_2}
                        {$coordinador_3}
                        {$profesor_1}
                        {$profesor_2}
                        {$profesor_3}
                    </div>
                </div>
html;
        }

        // ----- Variables para la tercer fecha ----- //
        $info_fecha3 = ProgramaDao::getSectionByDate('2022-05-20');
        $programa_fecha3 = <<<html
        
        <h5 class="mb-3 text-center">Viernes 20 de Mayo</h5>      
html;

        foreach ($info_fecha3 as $key => $value) {
            $progreso = ProgramaDao::getProgreso($_SESSION['id_registrado'],$value['id_programa']);

            $hora_inicio =substr($value['hora_inicio'],0,strlen($value['hora_inicio'])-3);
            $hora_fin = substr($value['hora_fin'],0,strlen($value['hora_fin'])-3);

            $max_time = $value['duracion'];
            $duracion_sec = substr($max_time,strlen($max_time)-2,2);
            $duracion_min = substr($max_time,strlen($max_time)-5,2);
            $duracion_hrs = substr($max_time,0,strpos($max_time,':'));

            $secs_totales = (intval($duracion_hrs)*3600)+(intval($duracion_min)*60)+intval($duracion_sec);

            $porcentaje = round(($progreso['segundos']*100)/$secs_totales);

            $coordinador_1 = '';

            if($value['id_coordinador'] != 0){
                $coordinador_1 = <<<html
                <span class="color-vine font-14 text-bold">
                    {$value['tipo_coordinador']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador']} {$value['nombre_coordinador']}
                </span>
                <br>
html;

            }

            $coordinador_2 = '';

            if($value['id_coordinador_2'] != 0){
                $coordinador_2 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_coordinador_2']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador_2']} {$value['nombre_coordinador_2']}
                </span>
                <br>
html;

            }

            $coordinador_3 = '';

            if($value['id_coordinador_3'] != 0){
                $coordinador_3 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_coordinador_3']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador_3']} {$value['nombre_coordinador_3']}
                </span>
                <br>
html;

            }


            $profesor_1 = '';

            if($value['id_profesor'] != 0){
                $profesor_1 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_profesor']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo']} {$value['nombre_profesor']}
                </span>
                <p class="color-vine font-12 mb-0 text-sm">
                    {$value['desc_profesor']}
                </p>
html;

            }

            $profesor_2 = '';

            if($value['id_profesor_2'] != 0){
                $profesor_2 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_profesor_2']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_2']} {$value['nombre_profesor_2']}
                </span>
                <p class="color-vine font-12 mb-0 text-sm">
                    {$value['desc_profesor_2']}
                </p>
html;

            }

            $profesor_3 = '';

            if($value['id_profesor_3'] != 0){
                $profesor_3 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_profesor_3']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_3']} {$value['nombre_profesor_3']}
                </span>
                <p class="color-vine font-12 mb-0 text-sm">
                    {$value['desc_profesor_3']}
                </p>
html;

            }

            $programa_fecha3 .= <<<html
                <div class="row mb-3">
                    <div class="col-12 col-md-2">
                        <span class="color-yellow text-bold">
                            {$hora_inicio} - {$hora_fin}
                        </span>
                    </div>
                    <div class="col-12 col-md-6">
                        <!--<a href="/Programa/Video/{$value['clave']}">-->
                            <span class="color-green text-bold font-20 text-lg">
                                {$value['descripcion']}
                            </span>
                            <br><br>
                            <span class="text-bold font-14 text-lg">
                            {$value['subtitulo']}
                            </span>
                            <br><br>
                            <span class="text-bold font-14 text-lg">
                                {$value['descripcion_subtitulo']}
                            </span>
                            <br><br>
                            <!--<span class="mt-4">
                                <b>Progreso: $porcentaje %</b>
                                <progress class="barra_progreso_small_green mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                            </span>-->
                        <!--</a>-->
                    </div>
                    <div class="col-12 col-md-4">
                        {$coordinador_1}
                        {$coordinador_2}
                        {$coordinador_3}
                        {$profesor_1}
                        {$profesor_2}
                        {$profesor_3}
                    </div>
                </div>
html;
        }

        // ----- Variables para la tercer fecha ----- //
        $info_fecha4 = ProgramaDao::getSectionByDate('2022-05-21');
        $programa_fecha4 = <<<html
        <h5 class="mb-3 text-center">Sábado 21 de Mayo</h5> 
           
html;

        if ($info_fecha4) {
            foreach ($info_fecha4 as $key => $value) {
            $progreso = ProgramaDao::getProgreso($_SESSION['id_registrado'],$value['id_programa']);

            $hora_inicio =substr($value['hora_inicio'],0,strlen($value['hora_inicio'])-3);
            $hora_fin = substr($value['hora_fin'],0,strlen($value['hora_fin'])-3);

            $max_time = $value['duracion'];
            $duracion_sec = substr($max_time,strlen($max_time)-2,2);
            $duracion_min = substr($max_time,strlen($max_time)-5,2);
            $duracion_hrs = substr($max_time,0,strpos($max_time,':'));

            $secs_totales = (intval($duracion_hrs)*3600)+(intval($duracion_min)*60)+intval($duracion_sec);

            $porcentaje = round(($progreso['segundos']*100)/$secs_totales);

            $coordinador_1 = '';

            if($value['id_coordinador'] != 0){
                $coordinador_1 = <<<html
                <span class="color-vine font-14 text-bold">
                    {$value['tipo_coordinador']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador']} {$value['nombre_coordinador']}
                </span>
                <br>
html;

            }

            $coordinador_2 = '';

            if($value['id_coordinador_2'] != 0){
                $coordinador_2 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_coordinador_2']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador_2']} {$value['nombre_coordinador_2']}
                </span>
                <br>
html;

            }

            $coordinador_3 = '';

            if($value['id_coordinador_3'] != 0){
                $coordinador_3 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_coordinador_3']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador_3']} {$value['nombre_coordinador_3']}
                </span>
                <br>
html;

            }


            $profesor_1 = '';

            if($value['id_profesor'] != 0){
                $profesor_1 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_profesor']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo']} {$value['nombre_profesor']}
                </span>
                <p class="color-vine font-12 mb-0 text-sm">
                    {$value['desc_profesor']}
                </p>
html;

            }

            $profesor_2 = '';

            if($value['id_profesor_2'] != 0){
                $profesor_2 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_profesor_2']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_2']} {$value['nombre_profesor_2']}
                </span>
                <p class="color-vine font-12 mb-0 text-sm">
                    {$value['desc_profesor_2']}
                </p>
html;

            }

            $profesor_3 = '';

            if($value['id_profesor_3'] != 0){
                $profesor_3 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_profesor_3']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_3']} {$value['nombre_profesor_3']}
                </span>
                <p class="color-vine font-12 mb-0 text-sm">
                    {$value['desc_profesor_3']}
                </p>
html;

            }


            if($value['id_programa'] == '172'){
                $simposio = <<<html
                <span class="color-yellow text-bold" style="border:solid 15px red; display:none; color: orange; background-color: blue; cursor: pointer; ">
                            {$hora_inicio} - {$hora_fin}
                </span>
                <br>
html;
            }
            else{
                $simposio = <<<html
                <span class="color-yellow text-bold">
                            {$hora_inicio} - {$hora_fin}
                </span>
                <br>
html;
            }

            $programa_fecha4 .= <<<html
                <div class="row mb-3">
                    <div class="col-12 col-md-2">
                            {$simposio}
                    </div>
                    <div class="col-12 col-md-6">
                        <!--<a href="/Programa/Video/{$value['clave']}">-->
                            <span class="color-green text-bold font-20 text-lg">
                                {$value['descripcion']}
                            </span>
                            <br><br>
                            <span class="text-bold font-14 text-lg">
                            {$value['subtitulo']}
                            </span>
                            <br><br>
                            <span class="text-bold font-14 text-lg">
                                {$value['descripcion_subtitulo']}
                            </span>
                            <br><br>
                            <!--<span class="mt-4">
                                <b>Progreso: $porcentaje %</b>
                                <progress class="barra_progreso_small_green mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                            </span>-->
                        <!--</a>-->
                    </div>
                    <div class="col-12 col-md-4">
                        {$coordinador_1}
                        {$coordinador_2}
                        {$coordinador_3}
                        {$profesor_1}
                        {$profesor_2}
                        {$profesor_3}
                    </div>
                </div>
html;
            }
        }

        

        View::set('programa_fecha1',$programa_fecha1);
        View::set('programa_fecha2',$programa_fecha2);
        View::set('programa_fecha3',$programa_fecha3);
        View::set('programa_fecha4',$programa_fecha4);
        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$this->_contenedor->footer($extraFooter));
        View::render("programa");
    }

    public function sala_uno(){

        // ----- Variables para la primer fecha ----- //
        $info_fecha1 = ProgramaDao::getSectionByDateSala('2022-05-18',1);
        $programa_fecha1 = '';

        $programa_fecha1 = <<<html
        <h5 class="mb-1 mt-1 text-center">Miércoles 18 de Mayo</h5>
        <br>     
        <br>       
html;

        foreach ($info_fecha1 as $key => $value) {
            $progreso = ProgramaDao::getProgreso($_SESSION['id_registrado'],$value['id_programa']);

            $hora_inicio =substr($value['hora_inicio'],0,strlen($value['hora_inicio'])-3);
            $hora_fin = substr($value['hora_fin'],0,strlen($value['hora_fin'])-3);

            $max_time = $value['duracion'];
            $duracion_sec = substr($max_time,strlen($max_time)-2,2);
            $duracion_min = substr($max_time,strlen($max_time)-5,2);
            $duracion_hrs = substr($max_time,0,strpos($max_time,':'));

            $secs_totales = (intval($duracion_hrs)*3600)+(intval($duracion_min)*60)+intval($duracion_sec);

            $porcentaje = round(($progreso['segundos']*100)/$secs_totales);

            $coordinador_1 = '';

            if($value['id_coordinador'] != 0){
                $coordinador_1 = <<<html
                <span class="color-vine font-14 text-bold">
                    {$value['tipo_coordinador']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador']} {$value['nombre_coordinador']}
                </span>
                <br>
html;

            }

            $coordinador_2 = '';

            if($value['id_coordinador_2'] != 0){
                $coordinador_2 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_coordinador_2']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador_2']} {$value['nombre_coordinador_2']}
                </span>
                <br>
html;

            }

            $coordinador_3 = '';

            if($value['id_coordinador_3'] != 0){
                $coordinador_3 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_coordinador_3']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador_3']} {$value['nombre_coordinador_3']}
                </span>
                <br>
html;

            }


            $profesor_1 = '';

            if($value['id_profesor'] != 0){
                $profesor_1 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_profesor']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo']} {$value['nombre_profesor']}
                </span>
                <p class="color-vine font-12 mb-0 text-sm">
                    {$value['desc_profesor']}
                </p>
html;

            }

            $profesor_2 = '';

            if($value['id_profesor_2'] != 0){
                $profesor_2 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_profesor_2']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_2']} {$value['nombre_profesor_2']}
                </span>
                <p class="color-vine font-12 mb-0 text-sm">
                    {$value['desc_profesor_2']}
                </p>
html;

            }

            $profesor_3 = '';

            if($value['id_profesor_3'] != 0){
                $profesor_3 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_profesor_3']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_3']} {$value['nombre_profesor_3']}
                </span>
                <p class="color-vine font-12 mb-0 text-sm">
                    {$value['desc_profesor_3']}
                </p>
html;

            }


            $programa_fecha1 .= <<<html
                <div class="row mb-3">
                    <div class="col-12 col-md-2">
                        <span class="color-yellow text-bold">
                            {$hora_inicio} - {$hora_fin}
                        </span>
                    </div>
                    <div class="col-12 col-md-6">
                        <!--<a href="/Programa/Video/{$value['clave']}">-->
                            <span class="color-green text-bold font-20 text-lg">
                                {$value['descripcion']}
                            </span>
                            <br><br>
                            <span class="text-bold font-14 text-lg">
                            {$value['subtitulo']}
                            </span>
                            <br><br>
                            <span class="text-bold font-14 text-lg">
                                {$value['descripcion_subtitulo']}
                            </span>
                            <br><br>
                            <!--<span class="mt-4">
                                <b>Progreso: $porcentaje %</b>
                                <progress class="barra_progreso_small_green mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                            </span>-->
                        <!--</a>-->
                    </div>
                    <div class="col-12 col-md-4">
                        {$coordinador_1}
                        {$coordinador_2}
                        {$coordinador_3}
                        {$profesor_1}
                        {$profesor_2}
                        {$profesor_3}
                    </div>
                </div>
html;
        }

        View::set('programa_fecha1',$programa_fecha1);
        View::render("programa_sala_uno");
    }

    public function sala_dos(){
        // ----- Variables para la primer fecha ----- //
        $info_fecha1 = ProgramaDao::getSectionByDateSala('2022-05-18',2);
        $programa_fecha1 = '';

        $programa_fecha1 = <<<html
        <h5 class="mb-1 mt-1 text-center">Miércoles 18 de Mayo</h5>
        <h4 class="mb-1 mt-1 text-center">Módulo de Investigación</h4>
        <p class="mb-1 mt-1 text-center">Sesión de "Fronteras de la investigación: De lo básico a lo clínico."</p>
        <p class="mb-1 mt-1 text-center"><strong>Coordinador: Dr. Guillermo Vargas López</strong></p>
        
        <br>     
        <br>       
html;

        foreach ($info_fecha1 as $key => $value) {
            $progreso = ProgramaDao::getProgreso($_SESSION['id_registrado'],$value['id_programa']);

            $hora_inicio =substr($value['hora_inicio'],0,strlen($value['hora_inicio'])-3);
            $hora_fin = substr($value['hora_fin'],0,strlen($value['hora_fin'])-3);

            $max_time = $value['duracion'];
            $duracion_sec = substr($max_time,strlen($max_time)-2,2);
            $duracion_min = substr($max_time,strlen($max_time)-5,2);
            $duracion_hrs = substr($max_time,0,strpos($max_time,':'));

            $secs_totales = (intval($duracion_hrs)*3600)+(intval($duracion_min)*60)+intval($duracion_sec);

            $porcentaje = round(($progreso['segundos']*100)/$secs_totales);

            $coordinador_1 = '';

            if($value['id_coordinador'] != 0){
                $coordinador_1 = <<<html
                <span class="color-vine font-14 text-bold">
                    {$value['tipo_coordinador']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador']} {$value['nombre_coordinador']}
                </span>
                <br>
html;

            }

            $coordinador_2 = '';

            if($value['id_coordinador_2'] != 0){
                $coordinador_2 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_coordinador_2']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador_2']} {$value['nombre_coordinador_2']}
                </span>
                <br>
html;

            }

            $coordinador_3 = '';

            if($value['id_coordinador_3'] != 0){
                $coordinador_3 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_coordinador_3']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_coordinador_3']} {$value['nombre_coordinador_3']}
                </span>
                <br>
html;

            }


            $profesor_1 = '';

            if($value['id_profesor'] != 0){
                $profesor_1 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_profesor']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo']} {$value['nombre_profesor']}
                </span>
                <p class="color-vine font-12 mb-0 text-sm">
                    {$value['desc_profesor']}
                </p>
html;

            }

            $profesor_2 = '';

            if($value['id_profesor_2'] != 0){
                $profesor_2 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_profesor_2']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_2']} {$value['nombre_profesor_2']}
                </span>
                <p class="color-vine font-12 mb-0 text-sm">
                    {$value['desc_profesor_2']}
                </p>
html;

            }

            $profesor_3 = '';

            if($value['id_profesor_3'] != 0){
                $profesor_3 = <<<html
                <span class="color-vine font-14 text-bold">
                {$value['tipo_profesor_3']}:
                </span>
                <br>
                <span class="color-vine font-14 text-bold">
                    {$value['prefijo_3']} {$value['nombre_profesor_3']}
                </span>
                <p class="color-vine font-12 mb-0 text-sm">
                    {$value['desc_profesor_3']}
                </p>
html;

            }


            $programa_fecha1 .= <<<html
                <div class="row mb-3">
                    <div class="col-12 col-md-2">
                        <span class="color-yellow text-bold">
                            {$hora_inicio} - {$hora_fin}
                        </span>
                    </div>
                    <div class="col-12 col-md-6">
                        <!--<a href="/Programa/Video/{$value['clave']}">-->
                            <span class="color-green text-bold font-20 text-lg">
                                {$value['descripcion']}
                            </span>
                            <br><br>
                            <span class="text-bold font-14 text-lg">
                            {$value['subtitulo']}
                            </span>
                            <br><br>
                            <span class="text-bold font-14 text-lg">
                                {$value['descripcion_subtitulo']}
                            </span>
                            <br><br>
                            <!--<span class="mt-4">
                                <b>Progreso: $porcentaje %</b>
                                <progress class="barra_progreso_small_green mt-2" max="$secs_totales" value="{$progreso['segundos']}"></progress>
                            </span>-->
                        <!--</a>-->
                    </div>
                    <div class="col-12 col-md-4">
                        {$coordinador_1}
                        {$coordinador_2}
                        {$coordinador_3}
                        {$profesor_1}
                        {$profesor_2}
                        {$profesor_3}
                    </div>
                </div>
html;
        }
        
        View::set('programa_fecha1',$programa_fecha1);
        View::render("programa_sala_dos");
    }

    public function Video($clave) {
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
                      url:"/Programa/uploadComprobante",
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
                              window.location.replace("/Programa/");
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

        // ----- Variables para la primer fecha ----- //
        $info_video = ProgramaDao::getProgramByClave($clave);
        $video_programa = '';

        $id_programa = $info_video['id_programa'];
        $nombre_programa = $info_video['descripcion'];
        $hora_inicio = $info_video['hora_inicio'];
        $hora_fin = $info_video['hora_fin'];
        $url = $info_video['url'];
        $duracion = $info_video['duracion'];

        $coordinador = $info_video['prefijo_coordinador'].' '.$info_video['nombre_coordinador'];
        $profesor = $info_video['prefijo'].' '.$info_video['nombre_profesor'];
        $desc_profesor = $info_video['desc_profesor'];

        $duracion_sec = substr($duracion,strlen($duracion)-2,2);
        $duracion_min = substr($duracion,strlen($duracion)-5,2);
        $duracion_hrs = substr($duracion,0,strpos($duracion,':'));
        
        $secs_totales = (intval($duracion_hrs)*3600)+(intval($duracion_min)*60)+intval($duracion_sec);
        $programa = ProgramaDao::getProgramByClave($clave);

        $progreso_curso = ProgramaDao::getProgreso($_SESSION['id_registrado'],$programa['id_programa']);
        if ($progreso_curso) {
            $progreso_curso = ProgramaDao::getProgreso($_SESSION['id_registrado'],$programa['id_programa']);
        } else {
            ProgramaDao::insertProgreso($_SESSION['id_registrado'],$programa['id_programa']);
            $progreso_curso = ProgramaDao::getProgreso($_SESSION['id_registrado'],$programa['id_programa']);
        }

        $porcentaje = round(($progreso_curso['segundos']*100)/$secs_totales);


        $video_programa = <<<html
        <!--h4 class="mb-1 mt-1 text-center">Video</h4-->      
html;

        $video_programa .= <<<html
            <div class="row mb-3 mt-0 m-auto">
                <div class="col-12 col-md-12 m-auto">
                    <div class="row">
                        <iframe id="iframe" class="bg-gradient-warning iframe-course" src="{$url}" width="640" height="521" frameborder="0">a</iframe>
                    </div>
                </div>
            </div>
html;



        View::set('video_programa',$video_programa);
        View::set('nombre_programa',$nombre_programa);
        View::set('hora_inicio',$hora_inicio);
        View::set('hora_fin',$hora_fin);
        View::set('id_programa',$id_programa);
        View::set('url',$url);
        View::set('porcentaje',$porcentaje);
        View::set('coordinador',$coordinador);
        View::set('profesor',$profesor);
        View::set('desc_profesor',$desc_profesor);
        View::set('progreso_curso',$progreso_curso);
        View::set('secs_totales',$secs_totales);
        View::set('header',$this->_contenedor->header($extraHeader));
        View::set('footer',$this->_contenedor->footer($extraFooter));
        View::render("programa_video");
    }

    public function updateProgress(){
        $progreso = $_POST['segundos'];
        $programa = $_POST['programa'];

        ProgramaDao::updateProgresoFecha($programa, $_SESSION['id_registrado'],$progreso);

        echo 'minuto '.$progreso.' '.$programa;
    }

    // public function Vistas(){
    //     $clave = $_POST['clave_video'];
    //     $vistas = ProgramaDao::getProgramByClave($clave)['vistas'];
    //     $vistas++;

    //     ProgramaDao::updateVistasByClave($clave,$vistas);

    //     echo $clave;
    // }

    public function Likes(){
        $clave = $_POST['clave'];
        $id_curso = ProgramaDao::getProgramByClave($clave)['id_curso'];

        $hay_like = ProgramaDao::getlike($id_curso,$_SESSION['id_registrado']);
        // var_dump($hay_like);

        if ($hay_like) {
            $status = 0;
            if ($hay_like['status'] == 1) {
                $status = 0;
            } else if ($hay_like['status'] == 0){
                $status = 1;
            }
            ProgramaDao::updateLike($id_curso,$_SESSION['id_registrado'],$status);
            // echo 'siuu '.$clave;
        } else {
            ProgramaDao::insertLike($id_curso,$_SESSION['id_registrado']);
            // echo 'nooouuu '.$clave;
        }
    }

    public function uploadComprobante(){

        $documento = new \stdClass();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $marca_ = '';
            $usuario = $_POST["user_"];
            $numero_dosis = $_POST['numero_dosis'];
            foreach($_POST['checkbox_marcas'] as $selected){
                $marca_ = $selected."/ ";
            }
            $marca = $marca_;
            $file = $_FILES["file_"];

            $pdf = $this->generateRandomString();

            move_uploaded_file($file["tmp_name"], "comprobante_vacunacion/".$pdf.'.pdf');

            $documento->_url = $pdf.'.pdf';
            $documento->_user = $usuario;
            $documento->_numero_dosis = $numero_dosis;
            $documento->_marca_dosis = $marca;

            $id = ProgramaDao::insert($documento);

            if ($id) {
                echo 'success';

            } else {
                echo 'fail';
            }
        } else {
            echo 'fail REQUEST';
        }
    }

    function generateRandomString($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

}