<title>
    Cursos - Neuropediatría 
</title>
<?php echo $header; ?>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-2">
                    <li class="breadcrumb-item text-sm">
                        <a class="opacity-3 text-dark" href="javascript:;">
                            <svg width="12px" height="12px" class="mb-1" viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>shop </title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-1716.000000, -439.000000)" fill="#252f40" fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(0.000000, 148.000000)">
                                                <path d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                                                <path d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="/Home/">Inicio</a></li>
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="/Programa/">Programa</a></li>
                    <li class="breadcrumb-item text-sm">Video</li>
                </ol>
            </nav>

            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <div class="input-group"></div>
                </div>

                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        <a href="/Home/" class="nav-link text-body font-weight-bold mx-lg-4 mx-0 px-0">
                            <i class="fa fa-home me-sm-0"></i>
                            <span class="d-sm-inline d-none">Inicio</span>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        <a href="/Login/cerrarSession" class="nav-link text-body font-weight-bold px-0">
                            <i class="fa fa-power-off me-sm-1"></i>
                            <span class="d-sm-inline d-none">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-">
        <div class="row">
            <div class="col-12">
                <div class="card card-body" id="profile">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-sm-auto col-4">
                            <div class="avatar avatar-xl position-relative">
                            <img src="/assets/img/Logo_SMNP.png">
                            </div>
                        </div>
                        <div class="col-sm-auto col-8 my-auto">
                            <div class="h-100">
                                <h4 class="mb-3 text-center color-green"><?php echo $nombre_programa;?></h4>
                                <div class="">
                                    <span class="color-yellow ">
                                        Horario: 
                                        <?php echo $hora_inicio.' - '.$hora_fin;?>
                                    </span>
                                </div>

                                <input type="text" id="nombre_t1" value="<?php echo $transmision_1['nombre'];?>" readonly hidden>
                                <input type="text" id="nombre_t2" value="<?php echo $transmision_2['nombre'];?>" readonly hidden>
                            
                            </div>
                        </div>
                        
                        <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 me-4">
                            <a href="/Programa/">
                                <span class="text-dark"><i class="fas fa-undo"></i> Regresar</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 m-auto text-center">
                            <?php echo $video_programa;?>
                        </div>
                    </div>
                    <hr class="horizontal dark">
                    <!-- Comments -->
                    <div class="mb-1">
                        <div class="col-12 col-md-12">
                            <span class="color-vine font-18 text-bold mb-2">
                                Coordinador:
                            </span>
                            <br>
                            <span class="color-vine font-14 text-bold">
                                <?php echo $coordinador;?>
                            </span>
                            <br><br>
                            <span class="color-vine font-18 text-bold">
                                Profesor:
                            </span>
                            <br>
                            <span class="color-vine font-16 text-bold">
                                <?php echo $profesor;?>
                            </span><br><br>
                            <p class="color-vine font-14 text-sm">
                                <?php echo $desc_profesor;?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card blur shadow-blur max-height-vh-70">
            <div class="card-header shadow-lg">
                <div class="row">
                <div class="col-md-12">
                    <div class=" text-center">
                    <!-- <img alt="Image" src="../../../assets/img/bruce-mars.jpg" class="avatar"> -->
                        <div class="ms-0 text-center">
                            <!-- <h6 class="mb-0 d-block"><?php echo $info_user['prefijo'].' '.$info_user['nombre'];?></h6> -->
                            <span class="text-lg text-center text-dark opacity-8">Progreso <span id="porcentaje"><?php echo $porcentaje;?> %</span> </span>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="card-footer d-block">
                
                <progress id="barra_progreso" max="<?php echo $secs_totales;?>" value="<?php echo $progreso_curso['segundos'];?>"></progress>
                <input type="text" name="" id="id_programa" hidden readonly value="<?php echo $id_programa;?>">
            </div>
            </div>
        </div>
        </div>
    </div>

    <br>
    <br>

    <div class="fixed-bottom navbar-dark">
        <!-- <a class="navbar-brand" href="#!">Footer</a> -->
        <?php echo $footer; ?>
    </div>

</main>


<script>
    $(document).ready(function(){
        
        // setTimeout(mandarMensaje, 10000);

        // var vista = 0;
        // function mandarMensaje() {
        //     vista++;
        //     console.log("Vista nueva al video: "+vista);

        //     clave_video = $('#clave_video').val();

        //     $.ajax({
        //         url: "/Programa/Vistas",
        //         type: "POST",
        //         data: {clave_video},
        //         beforeSend: function() {
        //             console.log("Procesando....");
        //         },
        //         success: function(respuesta) {

        //             console.log(respuesta);
                    
        //         },
        //         error: function(respuesta) {
        //             console.log(respuesta);
        //         }
        //     });
        // }

        let inicio = $('#barra_progreso').val();
        let duracion = $('#barra_progreso').attr('max');

        console.log(inicio);
        console.log(duracion);
        console.log($('#id_programa').val());

        let porcentaje_num = (inicio*100)/parseInt(duracion);
        let increment = 1;

        let tiempo_total = 0;

        function countTime(){
            intervalo = setInterval(function() {
                tiempo_total++;

                if (inicio <= duracion) {
                    inicio += increment;
                }

                if (tiempo_total % 60 == 0) {
                    console.log('Ejecutamos Ajax');
                    actualizarProgreso($('#id_programa').val(),inicio);
                }

                $('#barra_progreso').val(inicio);
                porcentaje_num = (inicio*100)/parseInt(duracion);
                $('#porcentaje').html(porcentaje_num.toFixed(0)+' %');
            },1000);

            $(window).blur(function() {
                ventana = 0;
                increment = 0;
                console.log('fuera de la ventana');
            });
            $(window).focus(function() {
                ventana = 1;
                increment = 1;
                console.log('dentro de la ventana');
            });
        }

        function actualizarProgreso(programa, segundos){
            $.ajax({
                url: "/Programa/updateProgress",
                type: "POST",
                data: {programa, segundos},
                beforeSend: function() {
                    console.log("Procesando....");
                },
                success: function(respuesta) {

                    console.log(respuesta);
                    
                },
                error: function(respuesta) {
                    console.log(respuesta);
                }
            });
        }

        countTime();
    }); 
    
</script>




                <!-- <p>1</p>

                <input type="checkbox" class="btn-face-green" id="btn-check-prueba">
                <label for="btn-check-prueba" class="color-face-green">aaaaa
                    <i class="fas fa-grin-beam text-lg"></i>
                </label>

                <input type="checkbox" class="btn-face-red" id="btn-check-prueba-2">
                <label for="btn-check-prueba-2" class="color-face-red">aaaaa
                    <i class="fas fa-angry text-lg"></i>
                </label>

                <input type="checkbox" class="btn-face-yellow" id="btn-check-prueba-5">
                <label for="btn-check-prueba-5" class="color-face-yellow">aaaaa
                    <i class="fas fa-grin-beam text-lg"></i>
                </label>

                <input type="checkbox" class="btn-face-orange" id="btn-check-prueba-6">
                <label for="btn-check-prueba-6" class="color-face-orange">aaaaa
                    <i class="fas fa-grin-beam text-lg"></i>
                </label>

                <p>2</p>

                <input type="checkbox" class="btn-face-green" id="btn-check-prueba-3">
                <label for="btn-check-prueba-3" class="color-face-green">aaaaa
                    <i class="fas fa-grin-beam text-lg"></i>
                </label>

                <input type="checkbox" class="btn-face-red" id="btn-check-prueba-4">
                <label for="btn-check-prueba-4" class="color-face-red">aaaaa
                    <i class="fas fa-angry text-lg"></i>
                </label> 
                <div class="card-body p-3"-->