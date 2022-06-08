<?php
namespace App\controllers;
defined("APPPATH") OR die("Access denied");

use \Core\View;
use \Core\MasterDom;
use \App\models\Register AS RegisterDao;

class Register{
    private $_contenedor;

    public function index() {
        $extraHeader =<<<html
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/favicon.ico">
        <link rel="icon" type="image/vnd.microsoft.icon" href="/assets//img/favicon.ico">
        <title>
            APM Register
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
        <link id="pagestyle" href="../../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
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
        window.addEventListener("keypress", function(event){
            if (event.keyCode == 13){
                event.preventDefault();
            }
        }, false);
        
          window.onload = function() {
          var myInput = document.getElementById('confirm_email');
          var myInput_conf = document.getElementById('confirm_email_iva');
          myInput.onpaste = function(e) {
            e.preventDefault();
          }
          myInput_conf.onpaste = function(e) {
            e.preventDefault();
          }
          
          myInput.oncopy = function(e) {
            e.preventDefault();
          }
          myInput_conf.oncopy = function(e) {
            e.preventDefault();
          }
        }
        
        $('#email').on('keypress', function() {
            var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(this.value);
            if(!re) {
                $('#error').show();
                 document.getElementById('confirm_email').disabled = true;
                 
            } else {
                $('#error').hide();
                document.getElementById('confirm_email').disabled = false;
                
            }
        })
        
        
        $('#confirm_email').on('keypress', function() {
            document.getElementById('email').disabled = true;
            var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(this.value);
            if(!re) {
                $('#error_confirm').show();
            } else {
                $('#error_confirm').hide();
            }
        })
        
         $("#confirm_email").on("keyup", function() 
        {
    	    var email_uno = document.getElementById('email').value;
            var email_dos = document.getElementById('confirm_email').value;
                  
            if(email_uno == email_dos)
            {
                document.getElementById('confirm_email').disabled = true;
                document.getElementById('title').disabled = false;
                document.getElementById('middle_name').disabled = false;
                document.getElementById('surname').disabled = false;
                document.getElementById('second_surname').disabled = false;
                document.getElementById('telephone').disabled = false;
                document.getElementById('telephone_code').disabled = false;
                document.getElementById('nationality').disabled = false;
                document.getElementById('state').disabled = false;
                document.getElementById('residence').disabled = false;
                document.getElementById('name_user').disabled = false;
                document.getElementById('modality').disabled = false;
                document.getElementById('specialties').disabled = false;
                document.getElementById("email_validado").value = email_uno;

            }
        });
     
        $('#email_receipt_iva').on('keypress', function() {
            var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(this.value);
            if(!re) {
                $('#error_email_send').show();
            } else {
                $('#error_email_send').hide();
            }
        })
        $('#confirm_email_iva').on('keypress', function() {
            var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(this.value);
            if(!re) {
                $('#error_email_send_confirm').show();
            } else {
                $('#error_email_send_confirm').hide();
            }
        })
        
        let button_active  = document.getElementById("next_one")
        let input_require = document.querySelectorAll(".all_input")
        let input_require_select = document.querySelectorAll(".all_input_select")
    
       input_require[3].addEventListener("keyup", () => 
       {
          if(input_require[0].value != "" && input_require[1].value != "" && input_require[2].value != "" && input_require[3].value != "") 
          {
               input_require_select[3].addEventListener("change", () => 
               {
                  document.getElementById("next_one").disabled = false
               })
          } 
          else 
          {
              document.getElementById("next_one").disabled = true
          }
        })
        
        button_active.addEventListener("click", (event) => {
              event.preventDefault()
        })
        
        let button_active_two  = document.getElementById("next_two")
        let input_require_two = document.querySelectorAll(".all_input_second")
        let input_require_second_select = document.querySelectorAll(".all_input_second_select")
    
       input_require_two[1].addEventListener("keyup", () => 
       {
          if(input_require_two[0].value != "" && input_require_two[1].value != "") 
          {
               input_require_second_select[2].addEventListener("change", () => 
               {
                  document.getElementById("next_two").disabled = false
               })
          } 
          else 
          {
              document.getElementById("next_two").disabled = true
          }
        })
        
        button_active_two.addEventListener("click", (event) => {
              event.preventDefault()
        })
        
        function myFunction() 
        {
            var one = document.getElementById("card_one");
            var two = document.getElementById("card_two");
            var three = document.getElementById("card_three");
            var four = document.getElementById("card_four");
            var five = document.getElementById("card_five");
            var card_progress = document.getElementById("card_progress");
            var Menu_Two = document.getElementById("Menu_Two");
            
            if (five.style.display === 'none') 
            {
                one.style.display = 'none';
                two.style.display = 'none';
                three.style.display = 'none';
                four.style.display = 'none';
                card_progress.style.display = 'none';
                five.style.display = 'block';
                Menu_Two.style.display = 'block';
                 $("#ModalPayOne").modal('hide');
            }
        }
        
        function myFunctionDiscardVAT() 
        {
            var one = document.getElementById("card_one");
            var two = document.getElementById("card_two");
            var three = document.getElementById("card_three");
            var four = document.getElementById("card_four");
            var six = document.getElementById("card_six");
            var card_progress = document.getElementById("card_progress");
            var Menu_Two = document.getElementById("Menu_Two");
            
            if (six.style.display === 'none') 
            {
                one.style.display = 'none';
                two.style.display = 'none';
                three.style.display = 'none';
                four.style.display = 'none';
                card_progress.style.display = 'none';
                six.style.display = 'block';
                Menu_Two.style.display = 'block';
            }

            
        }
        
        function myFunction_TermsConditions() 
        {
            var five = document.getElementById("card_five");
            var six = document.getElementById("card_six");
             
            if (six.style.display === 'none') 
            {
                six.style.display = 'block';
                five.style.display = 'none';
            }
        }
        
        function actualizaEdos() {
        var pais = $('#nationality').val();
        $.ajax({
          url: '/Register/ObtenerEstado',
          type: 'POST',
          dataType: 'json',
          data: {pais:pais},
    
        })
        .done(function(json) {
            if(json.success)
            {
                $("#state").html(json.html);
            }
        })
        .fail(function() 
        {
          alert("Ocurrio un error al actualizar el estado intenta de nuevo");
        })
      }
        
        $(document).ready(function(){
                
                $('input[type="checkbox"]').on('change', function() 
                {
                    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
                    $('#ModalPayOne').show();
                });
                
                $.validator.addMethod("checkUserName",function(value, element) {
                  var response = false;
                    $.ajax({
                        type:"POST",
                        async: false,
                        url: "/Login/isUserValidate",
                        data: {usuario: $("#usuario").val()},
                        success: function(data) {
                            if(data=="true"){
                                $('#btnEntrar').attr("disabled", false);
                                response = true;
                            }else{
                                $('#btnEntrar').attr("disabled", true);
                            }
                        }
                    });

                    return response;
                },"El usuario no es correcto");
            });
      </script>
html;
        View::set('header',$extraHeader);
        View::set('footer',$extraFooter);
        View::set('idCountry',$this->getCountry());
        View::render("Register");
    }

    public function Success(){

        $register = new \stdClass();

        $name = MasterDom::getDataAll('name_user');
        $name = MasterDom::procesoAcentosNormal($name);
        $register->_name = $name;

        $correo = $_REQUEST['email_validado'];

        $email = MasterDom::getDataAll('email_validado');
        $register->_email = $email;

        $title = MasterDom::getDataAll('title');
        $title = MasterDom::procesoAcentosNormal($title);
        $register->_title = $title;

        $middle_name = MasterDom::getDataAll('middle_name');
        $middle_name = MasterDom::procesoAcentosNormal($middle_name);
        $register->_middle_name = $middle_name;

        $surname = MasterDom::getDataAll('surname');
        $surname = MasterDom::procesoAcentosNormal($surname);
        $register->_surname = $surname;

        $second_surname = MasterDom::getDataAll('second_surname');
        $second_surname = MasterDom::procesoAcentosNormal($second_surname);
        $register->_second_surname = $second_surname;

        $telephone = MasterDom::getDataAll('telephone');
        $register->_telephone = $telephone;

        $international_code = MasterDom::getDataAll('telephone_code');
        $register->_international_code = $international_code;

        $nationality = MasterDom::getDataAll('nationality');
        $register->_nationality = $nationality;

        $specialties = MasterDom::getDataAll('specialties');
        $register->_specialties = $specialties;

        $modality = MasterDom::getDataAll('modality');
        $register->_modality = $modality;

        $state = MasterDom::getDataAll('state');
        $register->_state = $state;

        foreach($_POST['group1'] as $opcion){
            $register->_pay = $opcion;
            $method_pay = $opcion;

            $residence = $method_pay;
            $register->_method_pay = $residence;
        }


        $residence = MasterDom::getDataAll('residence');
        $register->_residence = $residence;

        $organization = MasterDom::getDataAll('organization');
        $organization = MasterDom::procesoAcentosNormal($organization);
        $register->_organization = $organization;

        $position = MasterDom::getDataAll('position');
        $register->_position = $position;

        $address = MasterDom::getDataAll('address');
        $address = MasterDom::procesoAcentosNormal($address);
        $register->_address = $address;

        $organization_country = MasterDom::getDataAll('organization_country');
        $register->_organization_country = $organization_country;

        $organization_postal_code = MasterDom::getDataAll('organization_postal_code');
        $register->_organization_postal_code = $organization_postal_code;

        $wadd_member = MasterDom::getDataAll('wadd_member');
        $register->_wadd_member = $wadd_member;

        $apm_member = MasterDom::getDataAll('apm_member');
        $register->_apm_member = $apm_member;

        $APM_radio = $_POST["APM_radio"];

        ///1 = SOCIO; 2= NO SOCIO

        if ($APM_radio == 'APAL')
        {
            $APAL = 1;//ES SOCIO
        }
        else
        {
            $APAL = 2;//NO ES SOCIO
        }
        $register->_APAL = $APAL;

        if ($APM_radio == 'AILANCYP')
        {
            $AILANCYP = 1;//ES SOCIO
        }
        else
        {
            $AILANCYP = 2;//NO ES SOCIO
        }
        $register->_AILANCYP = $AILANCYP;


        if ($APM_radio == 'AMPI')
        {
            $AMPI = 1;//ES SOCIO
        }
        else
        {
            $AMPI = 2;//NO ES SOCIO
        }
        $register->_AMPI = $AMPI;

        if ($APM_radio == 'LC')
        {
            $LC = 1;//ES SOCIO
        }
        else
        {
            $LC = 2;//NO ES SOCIO
        }
        $register->_LC = $LC;

        if ($APM_radio == 'APAL')
        {
            $register->_APAL = '1';
            $register->_AILANCYP = '2';
            $register->_AMPI = '2';
            $register->_LC = '2';
        }
        if ($APM_radio == '$AILANCYP')
        {
            $register->_APAL = '2';
            $register->_AILANCYP = '1';
            $register->_AMPI = '2';
            $register->_LC = '2';
        }
        if ($APM_radio == 'AMPI')
        {
            $register->_APAL = '2';
            $register->_AILANCYP = '2';
            $register->_AMPI = '1';
            $register->_LC = '2';
        }
        if ($APM_radio == 'LC')
        {
            $register->_APAL = '2';
            $register->_AILANCYP = '2';
            $register->_AMPI = '2';
            $register->_LC = '1';
        }

        if ($APM_radio == 'NULL')
        {
            $register->_APAL = '2';
            $register->_AILANCYP = '2';
            $register->_AMPI = '2';
            $register->_LC = '2';
        }



        $scholarship = MasterDom::getDataAll('scholarship');
        $register->_scholarship = $scholarship;

        $business_name_iva = MasterDom::getDataAll('business_name_iva');
        $register->_business_name_iva = $business_name_iva;

        $code_iva = MasterDom::getDataAll('code_iva');
        $register->_code_iva = $code_iva;

        $payment_method_iva = MasterDom::getDataAll('payment_method_iva');
        $register->_payment_method_iva = $payment_method_iva;

        $email_receipt_iva = MasterDom::getDataAll('email_receipt_iva');
        $register->_email_receipt_iva = $email_receipt_iva;

        $postal_code_iva = MasterDom::getDataAll('postal_code_iva');
        $register->_postal_code_iva = $postal_code_iva;

        $name_register = $name." ".$middle_name." ".$surname;

        $fecha_actual = date("d-m-Y");
        $fecha_limite_pago =  date("d-m-Y",strtotime($fecha_actual."+ 5 days"));

        $dia =date("d");
        $mes = date("m");
        $año = date("y");
        $sub_name =  substr($name, 0, 2);  // abcd
        $sub_name_sur =  substr($surname, 0, 2);  // abcd

        $reference_user = $sub_name.$sub_name_sur.$dia.$mes.$año;
        $register->_reference_user = $reference_user;



        if($register->_specialties == 'Students')
        {
            $costo = '250'; //Costo estudiante para Mexico e Internacional
        }
        else
        {
            if($register->_specialties == 'Residents')
            {
                if($register->_wadd_member == '1' ||  $register->_apm_member == '1' || $register->_APAL == '1' || $register->_AILANCYP == '1' || $register->_AMPI = $AMPI == '1')
                {
                    if($register->_LC = $LC == '2')
                    {
                        $costo = '250'; //Costo Residente si es socio
                    }
                    else
                    {
                        $costo = '250'; //Costo Residente si es socio
                    }

                }
                else
                {
                    $costo = '300'; //Costo residente si no es socio
                }
            }
            else
            {
                if($register->_specialties == 'Psychiatrist' || $register->_specialties == 'Child_Psychiatry' || $register->_specialties == 'Neurology'
                    || $register->_specialties == 'Pediatric_Neurology' || $register->_specialties == 'Paidapsychiatry' || $register->_specialties == 'Pedagogy'
                    || $register->_specialties == 'Psychogeriatrics' || $register->_specialties == 'Psychology' || $register->_specialties == 'Clinical_psychology'
                )
                {
                    if($register->_wadd_member == '1' ||  $register->_apm_member == '1' || $register->_APAL == '1' || $register->_AILANCYP == '1' || $register->_AMPI = $AMPI == '1' || $register->_LC = $LC == '1')
                    {
                        $costo = '450'; //Costo para socios de especialidades
                    }
                    else
                    {
                        if($register->_nationality == '156')
                        {
                            $costo = '600';
                        }
                        else
                        {
                            $res_costo = RegisterDao::getByCost($register->_nationality);
                            $costo = $res_costo['cost_abril_junio'];//costo para no socios de otras especialidades

                            if($register->_nationality == '156')
                            {
                                $costo = '600';
                            }
                        }

                    }

                }
                else
                {
                    if($register->_specialties == 'Others')
                    {
                        if($register->_nationality != '156')
                        {
                            if($register->_wadd_member == '2' ||  $register->_apm_member == '2' || $register->_APAL == '2' || $register->_AILANCYP == '2' || $register->_AMPI = $AMPI == '2' || $register->_LC = $LC == '2')
                            {
                                $costo = $res_costo['cost_abril_junio'];//costo para no socios de otras especialidades

                            }
                            else
                            {
                                if($register->_wadd_member == '1' ||  $register->_apm_member == '1' || $register->_APAL == '1' || $register->_AILANCYP == '1' || $register->_AMPI = $AMPI == '1' || $register->_LC = $LC == '1')
                                {
                                    $costo = '450'; //Costo para otros socios internacionales
                                }
                            }
                        }
                        else
                        {
                            if($register->_nationality == '156')
                            {
                                if($register->_wadd_member == '2' ||  $register->_apm_member == '2' || $register->_APAL == '2' || $register->_AILANCYP == '2' || $register->_AMPI = $AMPI == '2' || $register->_LC = $LC == '2')
                                {
                                    $costo = '600'; //Costo para otros no socios Mexicanos
                                }
                                else
                                {
                                    if($register->_wadd_member == '1' ||  $register->_apm_member == '1' || $register->_APAL == '1' || $register->_AILANCYP == '1' || $register->_AMPI = $AMPI == '1' || $register->_LC = $LC == '1')
                                    {
                                        $costo = '450'; //Costo para otros socios Mexicanos
                                    }

                                }
                            }
                        }
                    }
                }

            }
        }



        $register->_costo = $costo;
        

        $id = RegisterDao::insert($register);
        if($id >= 1)
        {
            $this->alerta($id,'add',$method_pay, $name_register, $costo, $fecha_limite_pago,$reference_user, $modality,$email);

        }else
        {
            $this->alerta($id,'error',$method_pay, $name_register,"","","", "","");
        }
    }

    public function alerta($id, $parametro, $type_deposit, $name_register, $costo, $limit_pay, $reference_user){
        $regreso = "/Login/";
        $pay = '';
        $name = $name_register;

        if($parametro == 'add')
        {

            if($type_deposit == 'paypal')
            {
                $pay = 'CREDIT OR DEBIT CARD';
                $name = $name_register;
                $message_pay = 'Important note: Please include the reference provided by this system in the field "Concepto 
                de pago" as per instructions above. The payment reference must be entered in capital 
                letters. Do not add any spaces between names or include any other punctuation marks, as 
                this may affect your bank transfer confirmation.';
                $amount = $costo;
                $date_pay = $limit_pay;
                $reference = $reference_user;
                $account_number = '021180040158530967';
                $bank = 'HSBC';
                $name_association = 'Asociacion Psiquiatrica Mexicana A.C';
                $swift_account = 'BIMEMXMM';
                $estilo = 'style="display: none;"';
                $estilo_boton = 'style="display: block;"';
            }
            if($type_deposit == 'electronic')
            {
                $pay = 'ELECTRONIC TRANSFER';
                $name = $name_register;
                $addres = 'Periferico Sur No. 4194, Int. 104, Col.Jardines del Pedregal, CDMX, CP.01900 ';
                $message_pay = '';
                $amount = $costo;
                $date_pay = $limit_pay;
                $reference = $reference_user;
                $account_number = '4015853096';
                $bank = 'HSBC';
                $name_association = 'Asociacion Psiquiatrica Mexicana A.C';
                $swift_account = 'BIMEMXMM';
                $estilo = 'style="display: block;"';
                $estilo_boton = 'style="display: none;"';
            }

        }

        if($parametro == "error")
        {
            $mensaje = "Al parecer ha ocurrido un problema";
        }

        View::set('regreso',$regreso);
        View::set('pay',$pay);
        View::set('message_pay',$message_pay);
        View::set('amount',$amount);
        View::set('reference',$reference);
        View::set('account_number',$account_number);
        View::set('bank',$bank);
        View::set('name_association',$name_association);
        View::set('reference',$reference);
        View::set('date_pay',$date_pay);
        View::set('name',$name);
        View::set('swift',$swift_account);
        View::set('estilo',$estilo);
        View::set('estilo_boton',$estilo_boton);
        View::set('address',$addres);
        View::render("alerta");
    }

    public function getCountry(){
        $country = '';
        foreach (RegisterDao::getCountryAll() as $key => $value) {
            $country.=<<<html
        <option value="{$value['id_pais']}">{$value['country']}</option>
html;
        }
        return $country;
    }

    public function ObtenerEstado(){
        $pais=$_POST['pais'];

        if($pais != 156)
        {
            $estados = RegisterDao::getState($pais);
            $html="";
            foreach ($estados as $estado){
                $html.='<option value="'.$estado['id_estado'].'">'.$estado['estado'].'</option>';
            }
        }
        else
        {
            $html="";
            $html.='
                <option value="" disabled selected>Selecciona una Opción</option>
                <option value="2537">Aguascalientes</option>
                <option value="2538">Baja California</option>
                <option value="2539">Baja California Sur</option>
                <option value="2540">Campeche</option>
                <option value="2541">Chiapas</option>
                <option value="2542">Chihuahua</option>
                <option value="2543">Coahuila de Zaragoza</option>
                <option value="2544">Colima</option>
                <option value="2545">Ciudad de Mexico</option>
                <option value="2546">Durango</option>
                <option value="2547">Guanajuato</option>
                <option value="2548">guerrero</option>
                <option value="2549">Hidalgo</option>
                <option value="2550">Jalisco</option>
                <option value="2551">Estado de Mexico</option>
                <option value="2552">Michoacan de Ocampo</option>
                <option value="2553">Morelos</option>
                <option value="2554">Nayarit</option>
                <option value="2555">Nuevo Leon</option>
                <option value="2556">Oaxaca</option>
                <option value="2557">Puebla</option>
                <option value="2558">Queretaro de Artiaga</option>
                <option value="2559">Quinta Roo</option>
                <option value="2560">San Lusi Potosi</option>
                <option value="2561">Sonora</option>
                <option value="2562">Tabasco</option>
                <option value="2563">Tamaulipas</option>
                <option value="2564">Tlaxcala</option>
                <option value="2565">Veracruz-Llave</option>
                <option value="2566">Yucatan</option>
                <option value="2567">Zacatecas</option>
                ';
        }


        $respuesta = new respuesta();
        $respuesta->success = true;
        $respuesta->html = $html;

        echo json_encode($respuesta);
    }

}
class respuesta {
    public $success;
    public $html;
}
