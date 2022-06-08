<!--<title>
    Home 
</title>-->
<?php echo $header; ?>
<link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
<body class="bg-body" id="body-home">

<!-- <div id="content"> -->
    
    <main>
        <!-- <video class="video-fondo" autoplay="true" muted="false" loop="true" src="/videos/dfic.mp4" type="video/mp4">
        </video> -->

        <!-- <div class="barra-amarilla"></div> -->

        <div class="barra-verde"></div>

        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg bg-gradient-yellow position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
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
                        <li class="breadcrumb-item text-sm"><a class="opacity-10 text-dark" href="javascript:;">Inicio</a></li>
                    </ol>
                </nav>

                <input type="hidden" name="datos" id="datos" value="<?php echo $datos;?>">
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group"></div>
                    </div>

                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="/Account" class="nav-link text-body font-weight-bold mx-lg-4 mx-0  px-0">
                                <i class="fa fa-user me-sm-0"></i>
                                <!-- <span class="d-sm-inline d-none">Mi Cuenta</span> -->
                                <?php
                                    $apellido = $datos['surname'];                                    
                                    $arr1 = str_split($apellido);                         
                                   
                                ?>
                                <span class="d-sm-inline d-none"><?php echo $datos['name_user'] ." ".$arr1[0].".";?></span>
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
        <div class="container-fluid py-0">

        <div class="row mt-3">
                <?php //echo $card_cursos;?>
        </div>        
            <div class="row">
                <div class="col-xl-12 mt-xl-0 mt-0">
                    <div class="row mt-md-4 mt-0">

                        <!-- <div class="col-6 m-auto m-md-0 col-lg-3 col-md-4 my-md-3 mt-4">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <a href="#">
                                        <div class="card card-link btn-menu-home m-auto"  style="background-image: url(/img/SMNP_Iconos/1.png)">
                                            <div class="card-body mt-md-3 text-center content-card-home">
                                                <div class="col-12 text-center">
                                                   
                                                </div>

                                                
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div> -->

                        <div class="col-6 m-auto m-md-0 col-lg-3 col-md-4 my-md-3 mt-4">
                            <a href="/Talleres/">
                                <div class="card card-link btn-menu-home m-auto"  style="background-image: url(/img/SMNP_Iconos/9_1.png); background-size: contain;">
                                    <div class="card-body mt-md-3 text-center content-card-home">
                                        <div class="col-12 text-center">
                                            
                                            
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6 m-auto m-md-0 col-lg-3 col-md-4 my-md-3 mt-4">
                            <a href="/ComprobantePago/">
                                <div class="card card-link btn-menu-home m-auto"  style="background-image: url(/img/SMNP_Iconos/11.png); background-size: contain;">
                                    <div class="card-body mt-md-3 text-center content-card-home">
                                        <div class="col-12 text-center">
                                          
                                        
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <!-- <div class="col-6 m-auto m-md-0 col-lg-3 col-md-4 my-md-3 mt-4">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <a href="/Transmission/">
                                        <div class="card card-link btn-menu-home m-auto"  style="background-image: url(/img/SMNP_Iconos/7.png); background-size: contain;">
                                            <div class="card-body mt-md-3 text-center content-card-home">
                                                <div class="col-12 text-center">
                                                  
                                                </div>                                               
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div> -->

                       

                       

                        <div class="col-6 m-auto m-md-0 col-lg-3 col-md-4 my-md-3 mt-4">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <a href="/Account/">
                                        <div class="card card-link btn-menu-home m-auto"  style="background-image: url(/img/SMNP_Iconos/6.png); background-size: contain;  object-position: center center;">
                                            <div class="card-body mt-md-3 text-center content-card-home">
                                                <div class="col-12 text-center">
                                               
                                                </div>

                                             
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 m-auto m-md-0 col-lg-3 col-md-4 my-md-3 mt-4">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <a href="#">
                                        <div class="card card-link btn-menu-home m-auto"  style="background-image: url(/img/SMNP_Iconos/15.png); background-size: contain;  object-position: center center;">
                                            <div class="card-body mt-md-3 text-center content-card-home">
                                                <div class="col-12 text-center">
                                               
                                                </div>

                                             
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        
                        <!-- <div class="col-6 m-auto m-md-0 col-lg-3 col-md-4 my-md-3 mt-4">
                            <a href="/Programa/">
                                <div class="card card-link btn-menu-home m-auto"  style="background-image: url(/img/SMNP_Iconos/13.png)">
                                    <div class="card-body mt-md-3 text-center content-card-home">
                                        <div class="col-12 text-center">
                                            
                                        </div>
                                     
                                    </div>
                                </div>
                            </a>
                        </div> -->
                        <!-- <div class="col-6 m-auto m-md-0 col-lg-3 col-md-4 my-md-3 mt-4">
                            <a href="#">
                                <div class="card card-link btn-menu-home m-auto"  style="background-image: url(/img/SMNP_Iconos/5.png)">
                                    <div class="card-body mt-md-3 text-center content-card-home">
                                        <div class="col-12 text-center">
                                            <img class="w-30 btn-img-home" src="../../assets/img/icons/iCONOS_Mesa de trabajo 1.png">
                                            <span class="color-yellow fas fa-spinner text-large"></span>
                                        </div>
                                        
                                        <h6 class="mb-0 mt-2 mt-md-4 font-weight-bolder text-btn color-green">Avances</h6>
                                        <p class="opacity-8 mb-0 text-sm">Disponible <i class="fa fa-clock me-sm-0" style="color: #8a6d3b"></i></p>
                                    </div>
                                </div>
                            </a>
                        </div> -->
                        <!-- <div class="col-6 m-auto m-md-0 col-lg-3 col-md-4 my-md-3 mt-4">
                            <a href="/Profesores/">
                                <div class="card card-link btn-menu-home m-auto"  style="background-image: url(/img/SMNP_Iconos/15.png)">
                                    <div class="card-body mt-md-3 text-center content-card-home">
                                        <div class="col-12 text-center">
                                           
                                        </div>
                                        
                                   
                                    </div>
                                </div>
                            </a>
                        </div> -->
                        <!-- <div class="col-6 m-auto m-md-0 col-lg-3 col-md-4 my-md-3 mt-4">
                            <a href="/TrabajosLibres/">
                                <div class="card card-link btn-menu-home m-auto"  style="background-image: url(/img/SMNP_Iconos/7.png)">
                                    <div class="card-body mt-md-3 text-center content-card-home">
                                        <div class="col-12 text-center">
                                           
                                        </div>
                                        
                                    </div>
                                </div>
                            </a>
                        </div> -->
                        <!-- <div class="col-6 m-auto m-md-0 col-lg-3 col-md-4 my-md-3 mt-4">
                            <a href="/Patrocinadores/">
                                <div class="card card-link btn-menu-home m-auto"  style="background-image: url(/img/SMNP_Iconos/12.png)">
                                    <div class="card-body mt-md-3 text-center content-card-home">
                                        <div class="col-12 text-center">
                                            
                                        </div>
                                        
                                      
                                    </div>
                                </div>
                            </a>
                        </div> -->
                        <!-- <div class="col-6 m-auto m-md-0 col-lg-3 col-md-4 my-md-3 mt-4">
                            <a href="#">
                                <div class="card card-link btn-menu-home m-auto"  style="background-image: url(/img/SMNP_Iconos/9.png)">
                                    <div class="card-body mt-md-3 text-center content-card-home">
                                        <div class="col-12 text-center">
                                            <img class="w-30 btn-img-home" src="../../assets/img/icons/iCONOS-07.png">
                                            <span class="color-yellow fas fa-tasks text-large"></span>
                                        </div>
                                        
                                        <h6 class="mb-0 mt-2 mt-md-4 font-weight-bolder text-btn color-green">Plenarias</h6>
                                        <p class="opacity-8 mb-0 text-sm">A un click</p>
                                    </div>
                                </div>
                            </a>
                        </div> -->
                        <!-- <div class="col-6 m-auto m-md-0 col-lg-3 col-md-4 my-md-3 mt-4">
                            <a href="/AreaComercial/">
                                <div class="card card-link btn-menu-home m-auto"  style="background-image: url(/img/SMNP_Iconos/11.png)">
                                    <div class="card-body mt-md-3 text-center content-card-home">
                                        <div class="col-12 text-center">
                                            
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div> -->
                    </div>
                        
                </div>
            </div>

        </div>

         <?php //echo $footer; ?> 
    </main>
<!-- </div> -->
    <?php echo $modalComprar?>




    <script type='text/javascript'>

        getData($("#datos").val());
        function getData(datos){
            $.ajax({
                    url:"/Home/getData",
                    type: "POST",
                    data: {datos},                   
                    beforeSend: function(){
                        console.log("Procesando....");

                    
                    },
                    success: function(respuesta){

                        console.log(respuesta);
                        if(respuesta == 0){
                            Swal.fire({
                            title: '¡Es necesario que actualice sus datos.!',
                            text: "",
                            icon: 'info',
                            showCancelButton: true,
                            showCancelButton: false,
                            // allowOutsideClick: false,
                            confirmButtonColor: '#3085d6'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.replace("/Account/");
                                }
                            })
                        }

                    },
                    error:function (respuesta)
                    {
                        
                        console.log(respuesta);
                    }

                });
        }
    $(function(){
        
        $(document).bind("contextmenu",function(e){
            return true;
        });

        $('.heart-not-like').on('click', function(){
            let clave = $(this).attr('data-clave');
            let heart = $(this);

            if (heart.hasClass('heart-like')) {
                heart.removeClass('heart-like').addClass('heart-not-like');
            } else {
                heart.removeClass('heart-not-like').addClass('heart-like');
            }
            console.log('se cambió a like: '+clave);
            $.ajax({
                url: "/Talleres/Likes",
                type: "POST",
                data: {clave},
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
        })

        $('.heart-like').on('click', function(){
            let clave = $(this).attr('data-clave');
            let heart = $(this);

            if (heart.hasClass('heart-like')) {
                heart.removeClass('heart-like').addClass('heart-not-like');
            } else {
                heart.removeClass('heart-not-like').addClass('heart-like');
            }
            console.log('se cambió a like: '+clave);
            $.ajax({
                url: "/Talleres/Likes",
                type: "POST",
                data: {clave},
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
        })
    });

   

    </script>
</body>


