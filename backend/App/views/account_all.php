<?php echo $header; ?>
<link id="pagestyle" href="/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg position-sticky mt-4 top-1 px-0 mx-4 border-radius-xl z-index-sticky blur shadow-blur left-auto" id="navbarBlur" data-scroll="true">
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
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;" disabled>Datos Personales</a></li>
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
    <div class="container-fluid py-0">
        <div class="row mt-lg-5 mt-2">
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8 mt-lg-0 mt-0">
                <!-- Card Profile -->
                <div class="card card-body" id="profile">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-sm-auto col-4">
                        <form method="POST" enctype="multipart/form-data" id="form_upload_image">
                            <input type="hidden" id="email_" name="email_" value="<?= $userData['email'] ?>" readonly>
                            <div class="image-upload">
                                <label for="file-input" id="lbl-image">
                                    <div class="avatar avatar-xl position-relative">
                                        <?php echo $imgUser; ?>
                                        <?php echo $userData['especialidad'];?>
                                    </div>
                                    <span id="btn-edit" class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center">
                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                    </span> 
                                </label>
                                
                                <input id="file-input" name="file-input" type="file" style="display:none;" />
                            </div>
                        </form>    



                        </div>
                        <div class="col-sm-auto col-8 my-auto">
                            <div class="h-100">
                                <h5 class="mb-1 font-weight-bolder">
                                    <?= $userData['title'] . " " . $userData['name_user'] . " " . $userData['middle_name'] . " " . $userData['surname']. " " . $userData['second_surname'] ?>
                                </h5>
                                <p class="mb-0 font-weight-bold text-sm">
                                    <span class="badge badge-info"><?php echo $userData['nombre_modalidad']; ?></span>
                                </p>
                            </div>
                        </div>
                       
                        <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">
                            <label class="form-check-label mb-0">
                                
                            </label>
                        </div>
                    </div>
                    
                </div>


                <!-- Card Basic Info -->
                <div class="card mt-4" id="basic-info">
                    <div class="card-header">
                        <h5>INFORMACIÓN BÁSICA</h5>
                        
                    </div>
                    <form class="form-horizontal" id="update_form" action="" method="POST">
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <!-- <input type="text" id="id_registro" name="id_registro" value="<?= $userData['id_registro'] ?> "> -->
                                    <label class="form-label">Primer nombre *</label>
                                    <div class="input-group">
                                        <input id="nombre" name="nombre" maxlength="29" pattern="[a-zA-Z ÑñáÁéÉíÍóÚ]*" class="form-control" type="text" placeholder="Alec" required="" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['name_user'] ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label class="form-label">Segundo nombre </label>
                                    <div class="input-group">
                                        <input id="segundo_nombre" name="segundo_nombre" maxlength="49" pattern="[a-zA-Z ÑñáÁéÉíÍóÚ]*" class="form-control" type="text" placeholder="Alec" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['middle_name'] ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label class="form-label">Apellido paterno *</label>
                                    <div class="input-group">
                                        <input id="apellido_paterno" name="apellido_paterno" maxlength="29" pattern="[a-zA-Z ÑñáÁéÉíÍóÚ]*" class="form-control" type="text" placeholder="Thompson" required="required" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['surname'] ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                    </div>
                                </div>

                                <div class="col-12 col-lg-4">
                                    <label class="form-label">Apellido materno *</label>
                                    <div class="input-group">
                                        <input id="apellido_materno" name="apellido_materno" maxlength="29" pattern="[a-zA-Z ÑñáÁéÉíÍóÚ]*" class="form-control" type="text" placeholder="Thompson" required="required" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['second_surname'] ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-sm-6 col-12 col-lg-6">
                                    <label class="form-label mt-4">País *</label>
                                    <select class="multisteps-form__select form-control all_input_select" name="pais" id="pais_edit" required>
                                        <?php echo $select_pais;?>
                                    </select>
                                    <!-- <input class="form-control" id="pais" maxlength="149" required name="pais" data-color="dark" type="text" value="<?= $userData['pais'] ?>" placeholder="Ej: México" readonly/> -->
                                </div>

                                <div class="col-sm-6 col-12 col-lg-6">
                                    <label class="form-label mt-4">Estado *</label>
                                    <select class="multisteps-form__select form-control all_input_select" name="estado" id="estado_edit" required>
                                        <?php echo $select_estado;?>
                                    </select>
                                    <!-- <input class="form-control" id="estado" maxlength="149" required name="estado" data-color="dark" type="text" value="<?= $userData['estado'] ?>" placeholder="Ej: México" readonly/> -->
                                </div>

                                <div class="col-lg-5 col-12">
                                    <label class="form-label mt-4">Correo electrónico *</label>
                                    <div class="input-group">
                                        <input id="email" name="email" maxlength="49" class="form-control" type="email" placeholder="example@email.com" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['usuario'] ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-12">
                                    <label class="form-label mt-4">Código de País</label>
                                    <div class="input-group">
                                        <input id="cod_telefono" name="cod_telefono" maxlength="10" pattern="[0-9]" class="form-control" type="number" placeholder="+52" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['international_code'] ?>">
                                    </div>
                                </div>

                                <div class="col-lg-5 col-12">
                                    <label class="form-label mt-4">Número de teléfono</label>
                                    <div class="input-group">
                                        <input id="telefono" name="telefono" maxlength="10" pattern="[0-9]" class="form-control" type="number" placeholder="+40 735 631 620" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['telephone'] ?>">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                   
                                    
                                    <div class="col-lg-4 col-12">
                                        <label class="form-label mt-4">Especialidad *</label>
                                        
                                            <!-- <select class="form-control" style="cursor: pointer;" name="especialidad" id="especialidad" tabindex="-1" data-choice="active" disabled>
                                                <?php echo $select_especialidad; ?>
                                            </select> -->
                                          <input class="form-control" id="especialidad" maxlength="149"  name="especialidad" data-color="dark" type="text" value="<?= $userData['specialties'] ?>" placeholder="Ej: México" readonly/> 
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-md-3 align-self-center" hidden>
                                        <label class="form-label mt-4">Actividad</label>
                                        <input class="form-control" id="actividad" name="actividad" type="text" value="<?= $userData['actividad'] ?>" readonly />
                                    </div>
                                    <div class="col-md-3 align-self-center" hidden>
                                        <label class="form-label mt-4">Talla de Playera</label>
                                        <input class="form-control" id="talla" name="talla" type="text" value="<?= $userData['talla_playera'] ?>" readonly />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label mt-4">Restricciones alimenticias</label>
                                        <input class="form-control" id="alergias" maxlength="149" name="alergias" data-color="dark" type="text" value="<?= $userData['alergias'] ?>" placeholder="Enter something" />
                                    </div>
                                </div> -->

                                <div class="row">
                                        
                                    <!-- <div class="col-md-6">
                                        <label class="form-label mt-4">Restricciones alimenticias *</label>
                                        <input class="form-control" id="alergia" maxlength="149" required name="alergia" data-color="dark" type="text" value="<?= $userData['alergia'] ?>" placeholder="Escribe las restricciones alimenticias" readonly/>
                                        <?php echo $restricciones; ?>
                                    </div> -->
                                    <br>
                                </div>

                                <div class="row">
                                    <div class="button-row d-flex mt-4 col-12">
                                        <a class="btn bg-gradient-light mb-0 js-btn-prev" href="/Home/" title="Prev">Regresar</a>
                                        <button class="btn bg-gradient-dark ms-auto mb-0" type="submit" title="Actualizar">Actualizar</button>
                                    </div>
                                </div>
                        </div>
                    </form>
                </div>


                <!-- Card Basic Info -->
                <div class="card mt-4" id="fiscal-info">
                    <div class="card-header">
                            <h5>INFORMACIÓN FISCAL</h5>
                            
                        </div>

                        <form class="form-horizontal" id="update_form_fiscal" action="" method="POST">
                            <div class="card-body pt-0">
                                <div class="row">
                                <input id="email_user" name="email_user" maxlength="49" class="form-control" type="hidden" placeholder="example@email.com" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['usuario'] ?>">

                                    <div class="col-12 col-sm-4">
                                        <label>Razón Social *</label>
                                        <input class="multisteps-form__input form-control" type="text" id="business_name_iva" name="business_name_iva" placeholder="eg. Christopher Prior Jones" maxlength="49" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['business_name_iva'] ?>">
                                    </div>                             
                            

                                    <div class="col-12 col-sm-4 mt-1 mt-sm-0">
                                        <label>RFC *</label>
                                        <input class="multisteps-form__input form-control" type="text" id="code_iva" name="code_iva" placeholder="eg. CPJ41250AS" maxlength="13" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['code_iva'] ?>">
                                    </div>

                                    <div class="col-12 col-sm-4 mt-1 mt-sm-0">
                                        <label>Metodo de Pago *</label>
                                        <input class="multisteps-form__input form-control" type="text" id="payment_method_iva" name="payment_method_iva" placeholder="eg. CPJ41250AS" maxlength="13" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['payment_method_iva'] ?>">
                                        <!-- <select class="multisteps-form__select form-control all_input_select" name="payment_method_iva" id="payment_method_iva">
                                            <option value="" disabled selected>Selecciona una Opción</option>
                                            <option value="ELECTRONIC TRANSFER">ELECTRONIC TRANSFER</option>
                                            <option value="CREDIT OR DEBIT CARD">CREDIT OR DEBIT CARD</option>
                                        </select> -->
                                    </div>

                                    <div class="col-12 col-sm-5">
                                        <label>Correo Electrónico facturación * </label>
                                        <input class="multisteps-form__input form-control" type="text"  id="email_receipt_iva" name="email_receipt_iva" placeholder="eg. user@domain.com" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['email_receipt_iva'] ?>">
                                        <span class="mb-0 text-sm" id="error_email_send" style="display:none;color:red;">Wrong email</span>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label>C.P *</label>
                                        <input class="multisteps-form__input form-control" type="text" id="postal_code_iva" name="postal_code_iva" maxlength="5" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" placeholder="eg. 50398"  value="<?= $userData['postal_code_iva'] ?>">
                                    </div>

                                    <div class="row">
                                        <div class="button-row d-flex mt-4 col-12">
                                            <a class="btn bg-gradient-light mb-0 js-btn-prev" href="/Home/" title="Prev">Regresar</a>
                                            <button class="btn bg-gradient-dark ms-auto mb-0" type="submit" title="Actualizar">Actualizar</button>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </form>
                                                            
                                                            

                </div>


                

                <div class="card mt-4" id="adicional-info">
                    <div class="card-header">
                        <h5>INFORMACIÓN ADICIONAL</h5>
                        
                    </div>

                    <form class="form-horizontal" id="form_1" action="" method="POST">
                        <div class="card-body pt-0">
                            <div class="row mt-3">
                                    <div class="col">
                                        <label>Organización *</label>
                                        <input class="multisteps-form__input form-control all_input_second" type="text" maxlength="35" id="organization" name="organization" placeholder="eg. Associated APM"  value="<?= $userData['organization'] ?>" readonly>
                                    </div>
                                    <div class="col">
                                        <label>Puesto *</label>
                                        <input class="multisteps-form__input form-control all_input_second" type="text" maxlength="25" id="position" name="position" placeholder="eg. Associated"  value="<?= $userData['position_organization'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 col-sm-6">
                                        <label>Dirección</label>
                                        <input class="multisteps-form__input form-control" type="text" id="address" maxlength="50" name="address" placeholder="eg. 1388 Sutter Street
                                                San Francisco 94109 California USA"  value="<?= $userData['address'] ?>" readonly>
                                    </div>
                                    <div class="col-6 col-sm-3 mt-3 mt-sm-0">
                                        <label>País *</label>
                                        <input class="multisteps-form__input form-control" type="text" id="organization_country" maxlength="50" name="organization_country"   value="<?= $pais_fiscal['pais'] ?>" readonly>
                                     
                                        <!-- <select class="multisteps-form__select form-control all_input_second_select" id="organization_country" name="organization_country">
                                            <option value="" disabled selected>Selecciona una Opción</option>
                                            <?php echo $idCountry; ?>
                                        </select> -->
                                    </div>
                                    <div class="col-6 col-sm-3 mt-3 mt-sm-0">
                                        <div class="col-12 col-sm-6">
                                            <label>C.P *</label>
                                            <input class="multisteps-form__input form-control" type="text" id="organization_postal_code" name="organization_postal_code" maxlength="5" value="<?= $userData['organization_postal_code'] ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <br>

                        <div class="card-header">
                        <h5 class="font-weight-bolder">ACERCA DE SUS SUSCRIPCIONES</h5>
                        
                        </div>

                        <form class="form-horizontal" id="form_2" action="" method="POST">
                            <div class="card-body pt-0">
                                <div class="row mt-3">  
                                    <div class="col-4">
                                        <label>¿Eres miembro de la WADD? *</label>
                                        <!-- <select class="multisteps-form__select form-control all_input_second_select" id="wadd_member" name="wadd_member">
                                            <option value="" disabled selected>Selecciona una Opción</option>
                                            <option value="1">Si</option>
                                            <option value="2">No</option>
                                        </select> -->
                                       
                                        <input class="multisteps-form__input form-control" type="text" id="wadd_member" name="wadd_member" maxlength="5" value="<?=  $wadd_member = $userData['wadd_member'] == '1' ? "SI" : "NO";?>" readonly>
                                    </div>
                                    <div class="col-4">
                                        <label>¿Eres socio de la APM? *</label>
                                        <input class="multisteps-form__input form-control" type="text" id="apm_member" name="apm_member" maxlength="5" value="<?=  $apm_member = $userData['apm_member'] == '1' ? "SI" : "NO";?>" readonly>
                                        <!-- <select class="multisteps-form__select form-control all_input_second_select" id="apm_member" name="apm_member">
                                            <option value="" disabled selected>Selecciona una Opción</option>
                                            <option value="1">Si</option>
                                            <option value="2">No</option>
                                        </select> -->
                                    </div>
                                    <div class="col-4">
                                        <label>¿Eres miembro de alguna otra asociación?</label>
                                        <?php echo $radio ?>
                                        <!-- <div class="form-check">
                                            <input class="form-check-input" type="radio" name="APM_radio" id="APAL" value="1" aria-label="APAL">
                                            <label class="form-check-label" for="APAL">APAL</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="APM_radio" id="AILANCYP" value="1" aria-label="AILANCYP">
                                            <label class="form-check-label" for="APAL">AILANCYP</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="APM_radio" id="AMPI" value="1" aria-label="AMPI">
                                            <label class="form-check-label" for="AMPI">AMPI</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="APM_radio" id="LC" value="1" aria-label="LC">
                                            <label class="form-check-label" for="LC">Países de América Latina y el Caribe</label>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="button-row d-flex mt-4 col-12">
                                        <a class="btn bg-gradient-light mb-0 js-btn-prev" href="/Home/" title="Prev">Regresar</a>
                                       
                                    </div>
                                </div>
                            </div>    
                        </form>
                        

                    
                    
                </div>

        </div>
        <?php echo $footer; ?>
</main>

<script>
    $("#pais_edit").on("change", function() {
            var pais = $(this).val();
            // alert(pais);
            $.ajax({
                url: "/Account/getEstadoPais",
                type: "POST",
                data: {
                    pais
                },
                dataType: "json",
                beforeSend: function() {
                    console.log("Procesando....");
                    $('#estado_edit')
                        .find('option')
                        .remove()
                        .end();

                },
                success: function(respuesta) {
                    console.log(respuesta);

                    $('#estado_edit').removeAttr('disabled');

                    $('#estado_edit')
                        .append($('<option>', {
                                value: ''
                            })
                            .text('Selecciona una opción'));

                    $.each(respuesta, function(key, value) {
                        //console.log(key);
                        console.log(value);
                        $('#estado_edit')
                            .append($('<option>', {
                                    value: value.id_estado
                                })
                                .text(value.estado));
                    });

                },
                error: function(respuesta) {
                    console.log(respuesta);
                }

            });
        });

        
        $("#update_form_fiscal").on("submit", function(event) {
            event.preventDefault();

            var formData = new FormData(document.getElementById("update_form_fiscal"));
            for (var value of formData.values()) {
               console.log(value);
            }

            $.ajax({
                url: "/Account/ActualizarFiscal",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    console.log("Procesando....");


                },
                success: function(respuesta) {
                    console.log(respuesta);
                    if (respuesta == 'success') {
                        swal("¡Se actualizaron tus datos correctamente!", "", "success").
                        then((value) => {
                            window.location.replace("/Home/");
                        });
                    } else {
                        swal("¡Usted No Actualizo Nada!", "", "warning").
                        then((value) => {
                            window.location.replace("/Account/")
                        });
                    }
                },
                error: function(respuesta) {
                    console.log(respuesta);
                }

            });
        });
</script>