<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <script language="javascript" type="text/javascript">
        // function textodeiframe(){
        //     var frame = document.getElementById('iframe-video');
        //     var v = frame.contentDocument.getElementsByTagName('video');
        //     // document.getElementById('txt2').value = txt;

        //     // var v = document.getElementById("transmision_prueba");
        //     // v[0].attr('muted',true);
        //     v[0].addEventListener("timeupdate",function(ev){
        //         document.getElementById("time_2").innerHTML = v[0].currentTime;
        //         // console.log(v[0].currentTime);
        //     },true);
        // }

        function textodeiframeJQ(){
            let frame = $('#iframe-video');
            let video = frame.contents().find('video');

            video.prop('muted',true);
            video.prop('autoplay',true);

            video.on('timeupdate', function(){
                $('#time_2').html(video[0].currentTime);
            });
            // console.log(doc);
            // var frame = document.getElementById('iframe-video');
            // var v = frame.contentDocument.getElementsByTagName('video');
            // document.getElementById('txt2').value = txt;

            // var v = document.getElementById("transmision_prueba");
            // v[0].attr('muted',true);
            // v[0].addEventListener("timeupdate",function(ev){
            //     document.getElementById("time_2").innerHTML = v[0].currentTime;
            //     // console.log(v[0].currentTime);
            // },true);
        }
        function textodeiframeJQ2(){
            let frame = $('#iframe-video-2');
            let video = frame.contents().find('video');

            video.prop('muted',true);
            video.prop('autoplay',true);

            video.on('timeupdate', function(){
                $('#time_2').html(video[0].currentTime);
            });
            // console.log(doc);
            // var frame = document.getElementById('iframe-video');
            // var v = frame.contentDocument.getElementsByTagName('video');
            // document.getElementById('txt2').value = txt;

            // var v = document.getElementById("transmision_prueba");
            // v[0].attr('muted',true);
            // v[0].addEventListener("timeupdate",function(ev){
            //     document.getElementById("time_2").innerHTML = v[0].currentTime;
            //     // console.log(v[0].currentTime);
            // },true);
        }

        $(document).ready(function(){
            // textodeiframe();
            textodeiframeJQ();
        })
    </script>
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
                    <li class="breadcrumb-item text-sm">Transmisión</li>
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
        <div class="row mt-2">
            <div class="col-lg-2">
            </div>
            <div class="card col-lg-8 mt-lg-5 mt-1" >
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-1 text-center">Transmisión en Vivo</h6>
                    <!-- <p class="text-sm text-center">Su video aquí</p> -->
                </div>
                <div class="row text-center">
                    <div class="col-lg-12 col-md-12 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                                <li class="nav-item transmisiones" data-transmision="1">
                                    <a class="nav-link mb-0 px-0 py-1 active" href="#transmision_1" data-bs-toggle="tab" role="tab" aria-selected="true">
                                        <span class="fa fa-handshake-o"></span>
                                        <span class="ms-1">Transmisión 1</span>
                                    </a>
                                </li>
                                <li class="nav-item transmisiones" data-transmision="2">
                                    <a class="nav-link mb-0 px-0 py-1" href="#transmision_2" data-bs-toggle="tab" role="tab" aria-selected="false">
                                        <span class="fas fa-signal-stream"></span>
                                        <span class="ms-1">Transmisión 2</span>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" href="#transmision_3" data-bs-toggle="tab" role="tab" aria-selected="false">
                                        <span class="fa fa-times"></span>
                                        <span class="ms-1">Transmisión 3</span>
                                    </a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-1 mt-1">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show position-relative active height-350 border-radius-lg" id="transmision_1" role="tabpanel" aria-labelledby="transmision_1">
                            <div class="row mt-4">
                                <div class="card mb-4">
                                    <div class="card-header pb-0">
                                        <h4 class="text-center"><?php echo $transmision_1['nombre'];?></h4>
                                        <br>
                                        <input type="text" readonly hidden id="secs_t1" value="<?php echo $secs_t1['segundos'];?>">
                                        <input type="text" readonly hidden id="status_t1" value="<?php echo $transmision_1['status'];?>">
                                        <div class="card-body px-0 pt-0 pb-2">
                                            <div class="row text-center">                                                
                                                <!-- <h5>Este es el tiempo actual en la página:</h5> -->
                                                <span type="text" name="time_watch_1" id="time_watch_1" ></span>
                                                <section>
                                                    <iframe id="iframe-video-2" onload="textodeiframeJQ2()" src="<?php echo $transmision_1['url'];?>" width="640" height="521" frameborder="0">a</iframe>
                                                </section>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade position-relative height-350 border-radius-lg" id="transmision_2" role="tabpanel" aria-labelledby="transmision_2">
                            <div class="row mt-4">
                                <div class="card mb-4">
                                    <div class="card-header pb-0">
                                        <h4 class="text-center"><?php echo $transmision_2['nombre'];?></h4>
                                        <br>
                                        <input type="text" readonly hidden id="secs_t2" value="<?php echo $secs_t2['segundos'];?>">
                                        <input type="text" readonly hidden id="status_t2" value="<?php echo $transmision_2['status'];?>">
                                        <div class="card-body px-0 pt-0 pb-2 text-center">
                                            <!-- <h5>Este es el tiempo actual en la página:</h5> -->
                                            <span type="text" name="time_watch_2" id="time_watch_2" ></span>
                                            <section>
                                                <iframe id="iframe-video" onload="textodeiframeJQ()" src="<?php echo $transmision_2['url'];?>" width="640" height="540" frameborder="0" allowfullscreen></iframe>
                                            </section>
                                            <br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <br>
        <br>
    </div>
    <br>
    <br>

    <?php echo $iframe_doc; ?>

    <div class="fixed-bottom navbar-dark">
        <!-- <a class="navbar-brand" href="#!">Footer</a> -->
        <?php echo $footer; ?>
    </div>

</main>