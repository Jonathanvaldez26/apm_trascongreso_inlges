<?php
namespace App\controllers;

use \Core\View;
use \Core\MasterDom;
use \App\models\Register AS RegisterDao;
use \App\models\LineaGeneral AS LineaGeneralDao;
use \App\models\Data AS DataDao; 
use \App\controllers\Mailer;
use \App\controllers\Contenedor;
use Core\Controller;

class Register{
    private $_contenedor;

    public function getUsuario(){
        return $this->__usuario;
    }

    public function index() {
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">
        <title>
            Registro Conave
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
        <!--script src="../../../assets/js/plugins/choices.min.js"></script-->

        
        
        

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
          <script src="../../../assets/js/plugins/choices.min.js"></script>
          <script type="text/javascript" wfd-invisible="true">
            if (document.getElementById('choices-button')) {
                var element = document.getElementById('choices-button');
                const example = new Choices(element, {});
            }
            var choicesTags = document.getElementById('choices-tags');
            var color = choicesTags.dataset.color;
            if (choicesTags) {
                const example = new Choices(choicesTags, {
                delimiter: ',',
                editItems: true,
                maxItemCount: 5,
                removeItemButton: true,
                addItems: true,
                classNames: {
                    item: 'badge rounded-pill choices-' + color + ' me-2'
                }
                });
            }
        </script>
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
           

        <script>
            $(document).ready(function(){
              $('#confirm_email').attr("disabled", true);
              $.validator.addMethod("checkUserCorreo",function(value, element) {
                var response = false;
                  $.ajax({
                      type:"POST",
                      async: false,
                      url: "/Register/isUserValidateUser",
                      data: {email: $("#email").val()},
                      success: function(data) {
                          if(data=="true"){
                              $('#btn_registro_email').attr("disabled", false);
                              $('#confirm_email').attr("disabled", false);
                              $('#email').attr("disabled", true);

                              response = true;
                          }else{
                              $('#btn_registro_email').attr("disabled", true);
                              $('#confirm_email').attr("disabled", true);
                              document.getElementById("confirm_email").value = "";
                          }
                      }
                  });

                  return response;
              },"<b>Usted ya se encuentra registrado en la plataforma verifique su información.<b>");


              $("#email_form").validate({
                 rules:{
                      email:{
                          required: true,
                          checkUserCorreo: true
                      },
                      confirm_email:{
                          required: true,
                          equalTo:"#email"
                      }
                  },
                  messages:{
                      email:{
                          required: "Este campo es requerido",
                      },
                      confirm_email:{
                          required: "Este campo es requerido",
                          equalTo: "El Correo Eléctronico no coincide",
                      }
                  }
              });
              

          });
          
        </script>
       
html;
        View::set('header',$extraHeader);
        View::set('footer',$extraFooter);
        View::render("Register");
    }

    public function Success(){


        $register = new \stdClass();

        $email = $_POST['confirm_email'];
        $register->_email = $email;

        $codigo_rand = $this->generateRandomString();
        $register->_code = $codigo_rand;

        $id = RegisterDao::update($register);
        if($id >= 1)
        {
            $msg = [
                'email' => $register->_email,
                'code' =>  $register->_code
            ];

            $mailer = new Mailer();
            $mailer->mailer($msg);

            $this->code($register->_email);
        }
        else
        {
            // echo "holaaaaa";
            // exit();
            $this->code500();
            //$this->Success();
            //$this->alerta($id,'error',$method_pay, $name_register);
        }
    }

    public function code($email , $alerta = null){
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/Musa0-01.png">
        <title>
            Registro - MUSA
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
          <script>
            $(document).ready(function(){
                $.validator.addMethod("checkUserCorreo",function(value, element) {
                  var response = false;
                    $.ajax({
                        type:"POST",
                        async: false,
                        url: "/Register/isUserValidate",
                        data: {email: $("#email").val()},
                        success: function(data) {
                            if(data=="true"){
                                $('#btn_registro_email').attr("disabled", false);
                                $('#confirm_email').attr("disabled", false);
                                $('#email').attr("disabled", true);
                                response = true;
                            }else{
                                $('#btn_registro_email').attr("disabled", true);
                                $('#confirm_email').attr("disabled", true);
                                document.getElementById("confirm_email").value = "";
                            }
                        }
                    });

                    return response;
                },"Usted no está registrado en la Base de Datos MUSA 2022, verifique con su área y reintente.");

                $("#email_form").validate({
                   rules:{
                        email:{
                            required: true,
                            checkUserCorreo: true
                        },
                        confirm_email:{
                            required: true,
                            equalTo:"#email"
                        }
                    },
                    messages:{
                        email:{
                            required: "Este campo es requerido",
                        },
                        confirm_email:{
                            required: "Este campo es requerido",
                            equalTo: "El Correo Eléctronico no coincide",
                        }
                    }
                });

            });
          
            var uno = document.getElementById("uno"),
                dos = document.getElementById("dos"),
                tres = document.getElementById("tres"),
                cuatro = document.getElementById("cuatro");

            uno.onkeyup = function() {
                if (this.value.length === parseInt(this.attributes["maxlength"].value)) {
                    dos.focus();
                }
            }

            dos.onkeyup = function() {
                if (this.value.length === parseInt(this.attributes["maxlength"].value)) {
                    tres.focus();
                }
            }
            tres.onkeyup = function() {
                if (this.value.length === parseInt(this.attributes["maxlength"].value)) {
                    cuatro.focus();
                }
            }
           
        </script>
      
html;

       
        $code = $email;
        View::set('header',$extraHeader);
        View::set('footer',$extraFooter);
        View::set('code',$code);
        View::set('alerta',$alerta);
        View::render("code");
    }

    public function ValidationEmail($email){
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/Musa0-01.png">
        <title>
            Registro - MUSA
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
        <!--script src="../../../assets/js/plugins/choices.min.js"></script-->

        
        
        

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
          <script src="../../../assets/js/plugins/choices.min.js"></script>
          <script type="text/javascript" wfd-invisible="true">
            if (document.getElementById('choices-button')) {
                var element = document.getElementById('choices-button');
                const example = new Choices(element, {});
            }
            var choicesTags = document.getElementById('choices-tags');
            var color = choicesTags.dataset.color;
            if (choicesTags) {
                const example = new Choices(choicesTags, {
                delimiter: ',',
                editItems: true,
                maxItemCount: 5,
                removeItemButton: true,
                addItems: true,
                classNames: {
                    item: 'badge rounded-pill choices-' + color + ' me-2'
                }
                });
            }
        </script>
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
          <script>
            $(document).ready(function(){
                $.validator.addMethod("checkUserCorreo",function(value, element) {
                  var response = false;
                    $.ajax({
                        type:"POST",
                        async: false,
                        url: "/Register/isUserValidate",
                        data: {email: $("#email").val()},
                        success: function(data) {
                            if(data=="true"){
                                $('#btn_registro_email').attr("disabled", false);
                                $('#confirm_email').attr("disabled", false);
                                $('#email').attr("disabled", true);

                                response = true;
                            }else{
                                $('#btn_registro_email').attr("disabled", true);
                                $('#confirm_email').attr("disabled", true);
                                document.getElementById("confirm_email").value = "";
                            }
                        }
                    });

                    return response;
                },"Usted no está registrado en la Base de Datos MUSA 2022, verifique con su área y reintente.");

                $("#email_form").validate({
                   rules:{
                        email:{
                            required: true,
                            checkUserCorreo: true
                        },
                        confirm_email:{
                            required: true,
                            equalTo:"#email"
                        }
                    },
                    messages:{
                        email:{
                            required: "Este campo es requerido",
                        },
                        confirm_email:{
                            required: "Este campo es requerido",
                            equalTo: "El Correo Eléctronico no coincide",
                        }
                    }
                });

            });
            
          
        </script>
      
html;
        $code = $email;
        View::set('header',$extraHeader);
        View::set('footer',$extraFooter);
        View::set('code',$code);
        View::render("formulario");
    }

    public function Data(){
        $extraHeader =<<<html
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
            <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/Musa0-01.png">
            <title>
                Registro - MUSA
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
            <!--script src="../../../assets/js/plugins/choices.min.js"></script-->


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
            <script src="../../../assets/js/plugins/choices.min.js"></script>
            <script type="text/javascript" wfd-invisible="true">
                if (document.getElementById('choices-button')) {
                    var element = document.getElementById('choices-button');
                    const example = new Choices(element, {});
                }
                var choicesTags = document.getElementById('choices-tags');
                var color = choicesTags.dataset.color;
                if (choicesTags) {
                    const example = new Choices(choicesTags, {
                    delimiter: ',',
                    editItems: true,
                    maxItemCount: 5,
                    removeItemButton: true,
                    addItems: true,
                    classNames: {
                        item: 'badge rounded-pill choices-' + color + ' me-2'
                    }
                    });
                }
            </script>
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
            <script>
                $(document).ready(function(){
                    $.validator.addMethod("checkUserCorreo",function(value, element) {
                    var response = false;
                        $.ajax({
                            type:"POST",
                            async: false,
                            url: "/Register/isUserValidate",
                            data: {email: $("#email").val()},
                            success: function(data) {
                                if(data=="true"){
                                    $('#btn_registro_email').attr("disabled", false);
                                    $('#confirm_email').attr("disabled", false);
                                    $('#email').attr("disabled", true);
                                    response = true;
                                }else{
                                    $('#btn_registro_email').attr("disabled", true);
                                    $('#confirm_email').attr("disabled", true);
                                    document.getElementById("confirm_email").value = "";
                                }
                            }
                        });

                        return response;
                    },"Usted no está registrado en la Base de Datos MUSA 2022, verifique con su área y reintente.");

                    $("#email_form").validate({
                    rules:{
                            email:{
                                required: true,
                                checkUserCorreo: true
                            },
                            confirm_email:{
                                required: true,
                                equalTo:"#email"
                            }
                        },
                        messages:{
                            email:{
                                required: "Este campo es requerido",
                            },
                            confirm_email:{
                                required: "Este campo es requerido",
                                equalTo: "El Correo Eléctronico no coincide",
                            }
                        }
                    });

                });
                
            
            </script>
      
html;
        if (strlen((date('y')-18))!=1) {
            $fecha_min = '20'.(date('y')-18).'-'.date('m').'-'.date('d');
        } else {
            $fecha_min = '200'.(date('y')-18).'-'.date('m').'-'.date('d');
        }

        $fecha_max = '20'.date('y').'-'.date('m').'-'.date('d');
        

        $email = $_POST['email'];
        $digit1 =  $_POST['uno'];
        $digit2 =  $_POST['dos'];
        $digit3 =  $_POST['tres'];
        $digit4 =  $_POST['cuatro'];
        $code_received  = $digit1.$digit2.$digit3.$digit4;
        $optionsGenero = '';
        $optionsLineaPrincipal = '';
        $especialidad = '';

        $lineaGeneral = LineaGeneralDao::getLineaPrincialAll();

        foreach ($lineaGeneral as $key => $value) {

            
            if ($value['id_linea_principal'] == 1 ) {
                $optionsLineaPrincipal.=<<<html
                    <option value="" disabled >Selecciona una opción</option>
                    <option value="{$value['id_linea_principal']}"selected>{$value['nombre']}</option>
html;
            } else {
                $optionsLineaPrincipal.=<<<html
                <option value="" disabled selected>Selecciona una opción</option>
                <option value="{$value['id_linea_principal']}" >{$value['nombre']}</option>
html;
            }
        }   
        
        $userData = RegisterDao::getUserRegister($email)[0];

        if($userData['genero'] == 'Hombre'){
            $optionsGenero =<<<html
                <option value="Hombre" selected>Hombre</option>
                <option value="Mujer">Mujer</option>
                <option value="Otro">Otro</option>
html;

        }elseif($userData['genero'] == 'Mujer'){
            $optionsGenero =<<<html
                <option value="Hombre">Hombre</option>
                <option value="Mujer" selected>Mujer</option>
                <option value="Otro">Otro</option>
html;

        }else{
            $optionsGenero =<<<html
                <option value="Hombre">Hombre</option>
                <option value="Mujer">Mujer</option>
                <option value="Otro" selected>Otro</option>
html;

        }


        if($userData['code'] === $code_received){
            //echo "Se verifico codigo correctamente";
            View::set('optionsLineaPrincipal',$optionsLineaPrincipal);
            View::set('userData', $userData);
            View::set('fecha_min', $fecha_min);
            View::set('fecha_max', $fecha_max);
            View::set('optionsGenero',$optionsGenero);
           // View::set('optionActividad',$optionActividad);
            View::set('email',$email);
            View::set('header',$extraHeader);
            View::set('footer',$extraFooter);
            View::render('update_data_register');
        }else{

            $alerta =<<<html
            <div class="alert alert-danger text-white" role="alert" >
                ¡El código de verificación no coincide, Intenta nuevamente!
            </div>
html;
            $this->code($email,$alerta);
        }

        // print_r($user_register);

    }

    public function Politicas(){

        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/Musa0-01.png">
        <title>
            Registro - MUSA
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
        <!--script src="../../../assets/js/plugins/choices.min.js"></script-->
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>  

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
          <script src="../../../assets/js/plugins/choices.min.js"></script>
          <script type="text/javascript" wfd-invisible="true">
            if (document.getElementById('choices-button')) {
                var element = document.getElementById('choices-button');
                const example = new Choices(element, {});
            }
            var choicesTags = document.getElementById('choices-tags');
            var color = choicesTags.dataset.color;
            if (choicesTags) {
                const example = new Choices(choicesTags, {
                delimiter: ',',
                editItems: true,
                maxItemCount: 5,
                removeItemButton: true,
                addItems: true,
                classNames: {
                    item: 'badge rounded-pill choices-' + color + ' me-2'
                }
                });
            }
        </script>
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
          <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
           

          <script>
            $(document).ready(function(){
                $("#pass_form").validate({
                   rules:{
                        password:{
                            required: true,
                            minlength: 6
                            
                            
                        },
                        confirm_password:{
                            required: true,
                            equalTo:"#password"
                        }
                    },
                    messages:{
                        password:{
                            required: "Este campo es requerido",
                            minlength: "El password debe tener al menos 6 caracteres"
                        },
                        confirm_password:{
                            required: "Este campo es requerido",
                            equalTo: "El password no coincide",
                        }
                    }
                });

                


            });
        </script>
       
html;
        

        $documento = new \stdClass();
  
  
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {

              $id_registro = $_POST['id_registro'];
              $nombre = $_POST['nombre'];
              $segundo_nombre = $_POST['segundo_nombre'];
              $apellido_paterno = $_POST['apellido_paterno'];
              $apellido_materno = $_POST['apellido_materno'];
              $genero = $_POST['genero'];
              $pais = $_POST['pais'];
              $email = $_POST['email'];
              $telefono = $_POST['telefono'];
              $especialidad = $_POST['especialidad'];
              $alergia = $_POST['alergia'];
              $alergia_cual = $_POST['alergia_cual'];
  
              $documento->_nombre = $nombre;
              $documento->_segundo_nombre = $segundo_nombre;
              $documento->_apellido_paterno = $apellido_paterno;
              $documento->_apellido_materno = $apellido_materno;
              $documento->_genero = $genero;
              $documento->_pais = $pais;
              $documento->_email = $email;
              $documento->_telefono = $telefono;
              $documento->_especialidad = $especialidad;
              $documento->_alergia = $alergia;
              $documento->_alergia_cual = $alergia_cual;


              $id = DataDao::update($documento);
  
              if ($id) {
                  View::set('email',$email);
                  View::set('header',$extraHeader);
                  View::set('footer',$extraFooter);
                  View::render('politicas');
                  //echo 'success';
              } else {

                //quitar esta parte
                
                  View::set('email',$email);
                  View::set('header',$extraHeader);
                  View::set('footer',$extraFooter);
                  View::render('politicas');
               // print_r($id);
                 // $this->code500();
                  //echo 'fail';
              }
          } else {
              echo 'fail REQUEST';
          }

    }

    public function DataPassword(){
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/Musa0-01.png">
        <title>
            Registro - MUSA
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
        <!--script src="../../../assets/js/plugins/choices.min.js"></script-->

        
        
        

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
          <script src="../../../assets/js/plugins/choices.min.js"></script>
          <script type="text/javascript" wfd-invisible="true">
            if (document.getElementById('choices-button')) {
                var element = document.getElementById('choices-button');
                const example = new Choices(element, {});
            }
            var choicesTags = document.getElementById('choices-tags');
            var color = choicesTags.dataset.color;
            if (choicesTags) {
                const example = new Choices(choicesTags, {
                delimiter: ',',
                editItems: true,
                maxItemCount: 5,
                removeItemButton: true,
                addItems: true,
                classNames: {
                    item: 'badge rounded-pill choices-' + color + ' me-2'
                }
                });
            }
        </script>
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
          <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
           

          <script>
            $(document).ready(function(){
                $("#pass_form").validate({
                   rules:{
                        password:{
                            required: true,
                            minlength: 6
                            
                            
                        },
                        confirm_password:{
                            required: true,
                            equalTo:"#password"
                        }
                    },
                    messages:{
                        password:{
                            required: "Este campo es requerido",
                            minlength: "El password debe tener al menos 6 caracteres"
                        },
                        confirm_password:{
                            required: "Este campo es requerido",
                            equalTo: "El password no coincide",
                        }
                    }
                });

            });
        </script>
       
html;

$documento = new \stdClass();
  
  
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {

              $id_registro = $_POST['id_registro'];
              $nombre = $_POST['nombre'];
              $segundo_nombre = $_POST['segundo_nombre'];
              $apellido_paterno = $_POST['apellido_paterno'];
              $apellido_materno = $_POST['apellido_materno'];
              $genero = $_POST['genero'];
              $pais = $_POST['pais'];
              $email = $_POST['email'];
              $telefono = $_POST['telefono'];
              $especialidad = $_POST['especialidad'];
              $alergia = $_POST['alergia'];
              $alergia_cual = $_POST['alergia_cual'];
              $btn_politicas = 1;
  
              $documento->_nombre = $nombre;
              $documento->_segundo_nombre = $segundo_nombre;
              $documento->_apellido_paterno = $apellido_paterno;
              $documento->_apellido_materno = $apellido_materno;
              $documento->_genero = $genero;
              $documento->_pais = $pais;
              $documento->_email = $email;
              $documento->_telefono = $telefono;
              $documento->_especialidad = $especialidad;
              $documento->_alergia = $alergia;
              $documento->_alergia_cual = $alergia_cual;


               //$id = DataDao::update($documento);
  
            //   if ($id) {
                View::set('politica',$btn_politicas);
                View::set('email',$email);
                View::set('header',$extraHeader);
                View::set('footer',$extraFooter);
                View::set('data',$documento);
                View::render('confirm_pass');
                //   //echo 'success';
            //   } else {

            //     //quitar esta parte
                
            //     View::set('politica',$btn_politicas);
            //     View::set('email',$email);
            //     View::set('header',$extraHeader);
            //     View::set('footer',$extraFooter);
            //     View::render('confirm_pass');
            //    // print_r($id);
            //      // $this->code500();
            //       //echo 'fail';
            //   }
          } else {
              echo 'fail REQUEST';
          }
        
    }

    public function finalize(){

        $register = new \stdClass();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $password = $_POST['password'];
                $email = $_POST['email'];
                $politica = $_POST['politica'];
               

                $userData = RegisterDao::getUserRegister($email)[0];
                
                
                $id_registro_acceso = $userData['id_registro_acceso'];
                
                // $register->_password = md5($password);
                $register->_password = $password;
                $register->_email = $email;
                $register->_politica = $politica;
                $register->_id_registro_acceso = $id_registro_acceso;

                $id = DataDao::insert($register);


                $nombre = $_POST['nombre'];
                $segundo_nombre = $_POST['segundo_nombre'];
                $apellido_paterno = $_POST['apellido_paterno'];
                $apellido_materno = $_POST['apellido_materno'];
                $genero = $_POST['genero'];
                $pais = $_POST['pais'];
                $email = $_POST['email'];
                $telefono = $_POST['telefono'];
                $especialidad = $_POST['especialidad'];
                $alergia = $_POST['alergia'];
                $alergia_cual = $_POST['alergia_cual'];
                $politica = 1;

                $documento = new \stdClass();
                $documento->_nombre = $nombre;
                $documento->_segundo_nombre = $segundo_nombre;
                $documento->_apellido_paterno = $apellido_paterno;
                $documento->_apellido_materno = $apellido_materno;
                $documento->_genero = $genero;
                $documento->_pais = $pais;
                $documento->_email = $email;
                $documento->_telefono = $telefono;
                $documento->_especialidad = $especialidad;
                $documento->_alergia = $alergia;
                $documento->_alergia_cual = $alergia_cual;
                $documento->_politica = $politica;

                if ($id) {

                   DataDao::update($documento);                    
                   //RegisterDao::updatePolitica($register);
                    
                    $msg = [
                        'email' => $email,
                        'name' =>  $userData['nombre']
                    ];
        
                    $mailer = new Mailer();
                    $mailer->mailerRegister($msg);

                    echo 'success';
                    

                } else {

                
                    echo 'fail';
                }
        }    
      

    }
    
    public function code500(){
        View::render("500");
    }

    public function isUserValidate(){
        echo (count(RegisterDao::getUserRegister($_POST['email']))>=1)? 'true' : 'false';
    }

    public function isUserValidateRegistrate(){
        echo (count(RegisterDao::getUserRegistrate($_POST['email']))>=1)? 'true' : 'false';
    }

    public function isUserValidateUser(){
        echo (count(RegisterDao::getUserRegisterTrue($_POST['email']))>=1)? 'true' : 'false';
    }

    function generateRandomString($length = 4) {
        return substr(str_shuffle("0123456789"), 0, $length);
    }

}


