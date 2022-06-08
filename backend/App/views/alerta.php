<!--
=========================================================
* Soft UI Dashboard PRO - v1.0.5
=========================================================

* Product Page:  https://themes.getbootstrap.com/product/soft-ui-dashboard-pro/
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
    <title>
        Soft UI Dashboard PRO by Creative Tim
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
    <style>
        .oval {
            width: 185px;
            height: 185px;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            border-radius: 50%;
            /*background: #fff;*/
            border: 10px solid rgb(26 221 205 / 75%);
            /* opacity: 0.5;*/
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .crono {
            color: #000000;
            font-family: 'Agency FB', arial;
            font-size: 600%;
            text-shadow: 4px 4px 4px #aaa;
            /* padding-left: 49px; */

        }
    </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg  blur blur-rounded top-0  z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
            <div class="container-fluid">
                <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 ">
                    <img src="/assets/img/logos/apmn.png" style="width: 40px; height: 40px; margin-left: 5px; margin-right: 5px;">
                    <img src="/assets/img/logos/waddn.png" style="width: 40px; height: 40px; margin-left: 5px; margin-right: 5px;">
                    VI World Congress on Dual Disorders
                </a>
                <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="navigation">
                    <ul class="navbar-nav navbar-nav-hover mx-auto">
                    </ul>
                    <ul class="navbar-nav d-lg-block d-none">
                        <li class="nav-item">
                            <a href="/Login/" class="btn btn-sm  bg-gradient-info  btn-round mb-0 me-1" onclick="smoothToPricing('pricing-soft-ui')">SIGN IN</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav 
        <div class="page-header min-vh-75">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 col-lg-10 col-md-12 d-flex flex-column mx-auto">
                    <div class="card card-plain mt-7">
                        <div class="container-fluid py-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="multisteps-form">
                                        <!--form panels-->
                                        <div class="row">
                                            <div class="col-12 col-lg-12 m-auto">
                                                <div id="card_one" class="card multisteps-form__panel p-3 border-radius-xl bg-white js-active" id="card_one" data-animation="FadeIn">
                                                    <h5 class="font-weight-bolder mb-0">¡Gracias por completar su formulario de pre-registro!</h5>

                                                    <div class="multisteps-form__content">
                                                        <br>
                                                        <p class="mb-0 text-sm">
                                                            Estimado: <?php echo $name; ?>
                                                        </p>
                                                        <br>

                                                    </div>

                                                    <div>En breve sera redireccionado al inicio</div>

                                                    <div style="display: flex; justify-content: center;">
                                                        
                                                        <section class="oval">
                                                            <div id="cronometro">
                                                                <div class="crono">
                                                                    <span id="reloj_sg">00</span>
                                                                    <!-- <span id="reloj_cs">00</span> -->
                                                                </div>
                                                            </div>
                                                        </section>
                                                        
                                                        
                                                    </div>


                                                    <div id="paypal-button-container"></div>
                                                    <div id="paypal-button" <?php echo $estilo_boton; ?>></div>
                                                    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
                                                    <script>
                                                        paypal.Button.render({
                                                            env: '<?php echo PayPalENV; ?>',
                                                            client: {
                                                                <?php if (ProPayPal) { ?>
                                                                    production: '<?php echo PayPalClientId; ?>'
                                                                <?php } else { ?>
                                                                    sandbox: '<?php echo PayPalClientId; ?>'
                                                                <?php } ?>
                                                            },
                                                            payment: function(data, actions) {
                                                                return actions.payment.create({
                                                                    transactions: [{
                                                                        amount: {
                                                                            total: '<?php echo $productPrice; ?>',
                                                                            currency: '<?php echo $currency; ?>'
                                                                        }
                                                                    }]
                                                                });
                                                            },
                                                            onAuthorize: function(data, actions) {
                                                                return actions.payment.execute()
                                                                    .then(function() {
                                                                        alert("sucess");
                                                                    });
                                                            }
                                                        }, '#paypal-button');
                                                    </script>

                                                    <div class="button-row d-flex mt-4">
                                                        <a href="<?php echo ($regreso) ? $regreso : '/' ?>" class="btn btn-sm btn bg-gradient-info ms-auto mb-0 js-btn-next" type="button" title="Next">Regresar al Sitio</a>
                                                    </div>
                                                </div>
                                                <?php $redireccion ?>
                                                <?php
                                                ob_start();
                                                //header("refresh: 10; url = $regreso");
                                                //header("url = $regreso");
                                                ob_end_flush();
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row" style="display: none;">
                <div class="col">
                <form role="form" class="text-start" id="login" action="/Login/crearSession" method="POST" class="form-horizontal">                                      
                        <input type="email" name="usuario" id="usuario" class="form-control" aria-label="Email" value="">
                        <button type="submit" id="btn_crearSesion"></button>
                </form>
                </div>
            </div>
        </div>
        </div>
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="../../assets/js/core/popper.min.js"></script>
    <script src="../../assets/js/core/bootstrap.min.js"></script>
    <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <!-- Kanban scripts -->
    <script src="../../assets/js/plugins/dragula/dragula.min.js"></script>
    <script src="../../assets/js/plugins/jkanban/jkanban.js"></script>
    <script src="../../assets/js/plugins/chartjs.min.js"></script>
    <script src="../../assets/js/plugins/threejs.js"></script>
    <script src="../../assets/js/plugins/orbit-controls.js"></script>
    <script>

        var user = document.getElementById('usuario');
        user.value = localStorage.getItem("email");;

        document.onkeydown = function(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            alert(tecla)
            if (tecla == 116) {
                if (confirm("Seguro que quieres refrescar la página ") == true) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        window.onload = function() {
            // cs_visor = document.getElementById("reloj_cs"); //localizar pantalla del reloj
            sg_visor = document.getElementById("reloj_sg"); //localizar pantalla del reloj
            empezar();
        }

        //variables de inicio:
        var marcha;
        var cro = 0;

        function empezar() {
            emp = Date.now() + 4000; //fecha actual
            //emp.setMinutes(emp.getMinutes() + 10); // agrego 1 min a la fecha actual
            elcrono = setInterval(tiempo, 10); //función ejecutada cada milecima de segundo
            marcha = 1 //indicamos que se ha puesto en marcha.
        }

        

        //función del temporizador
        function tiempo() {
            actual = new Date() //fecha en el instante
            cro = emp - actual //resto fecha+60seg - fecha actual
            cr = new Date() //fecha donde guardamos el tiempo transcurrido
            cr.setTime(cro)
            cs = cr.getMilliseconds() //milisegundos del cronómetro
            cs = cs / 10; //paso a centésimas de segundo.
            cs = Math.round(cs)
            sg = cr.getSeconds(); //segundos del cronómetro
            if (cs < 10) {
                cs = "0" + cs;
            } //poner siempre 2 cifras en los números
            if (sg < 10) {
                sg = "0" + sg;
            }

            if(sg == 1){

             
                document.getElementById("btn_crearSesion").click();
                
                // let usuario = localStorage.getItem("email");
                // console.log(usuario);
                // const url = "/Login/crearSessionFinalize"
                // let xhr = new XMLHttpRequest()
                
                // xhr.open('POST', url, true)
                // xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
                // xhr.send(usuario);

                // xhr.onreadystatechange = function() {//Call a function when the state changes.
                //     if(xhr.readyState == 4 && xhr.status == 200) {
                //         console.log(xhr.response);
                        
                //         console.log("Post successfully created!");
                //         window.location.replace("/Home/");
                //     }
                // }
            
            }
            // cs_visor.innerHTML = cs; //pasar a pantalla.
            sg_visor.innerHTML = sg; //pasar a pantalla.
        }
    </script>>
</body>

</html>