<?php
echo $header;
?>
    
    <body class="">
    <main class="main-content mt-0 ps">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('../../../assets/img/curved-images/musa (3).jpeg');">
            <span class="mask bg-gradient-dark opacity-1"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-dark mb-2 mt-5">¡Bienvenido!</h1>
                        <p class="text-lead text-dark">MUSA, Mujer Salud 2022. </p>
                        <?php //var_dump($data); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                        <div class="card z-index-0">
                            <div class="card-header text-center pt-4">
                                <p>Cree su contraeña</p>
                                <p class="text-sm font-weight-bold mb-2 text-secondary text-border d-inline z-index-2 bg-white px-3">
                                    <i class="fa fa-user-circle"></i>
                                </p>
                                <p class="text-center" style="font-weight:bold; font-size: 15px">Introduzca una contraseña con un mínimo de 6 caracteres alfanuméricos</p>
                            </div>
                            <div class="card-body pt-0">
                                <form class="form-horizontal" id="pass_form" action="" method="POST">

                                <input type="hidden" name="nombre" value="<?= $data->_nombre; ?>">
                                <input type="hidden" name="segundo_nombre" value="<?= $data->_segundo_nombre; ?>">
                                <input type="hidden" name="apellido_materno" value="<?= $data->_apellido_materno; ?>">
                                <input type="hidden" name="apellido_paterno" value="<?= $data->_apellido_paterno; ?>">
                                <input type="hidden" name="genero" value="<?= $data->_genero; ?>">
                                <input type="hidden" name="pais" value="<?= $data->_pais; ?>">                               
                                <input type="hidden" name="telefono" value="<?= $data->_telefono; ?>">
                                <input type="hidden" name="especialidad" value="<?= $data->_especialidad; ?>">
                                <input type="hidden" name="alergia" value="<?= $data->_alergia; ?>">
                                <input type="hidden" name="alergia_cual" value="<?= $data->_alergia_cual; ?>">

                                    <!-- <input type="hidden" id="id_registro" name="id_registro" value="<?=$id_registro?>"> -->
                                    <input type="hidden" id="email" name="email" value="<?=$email?>">
                                    <input type="hidden" id="politica" name="politica" value="<?=$politica?>">
                                    <div class="mb-3 form-group">
                                        <label style="font-weight:bold; font-size: 15px">Contraseña *</label>
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Ingrese su contraseña *" aria-label="Password" required="required">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label style="font-weight:bold; font-size: 15px">Confirme su contraseña *</label>
                                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirme su Contraseña" aria-label="Confirmar tu Password" required="required">
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-outline-primary w-100 my-4 mb-2 ms-auto " type="submit" id="btn_registro_password">terminar mi Registro</button>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <br>
    </main>

    </body>

<?php echo $footer; ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){
       
        $("#pass_form").on("submit",function(event){
                event.preventDefault();

                if ($("#pass_form").valid()) {
                    var formData = new FormData(document.getElementById("pass_form"));
                    console.log(formData);
                    $.ajax({
                    url:"/Register/finalize",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        console.log("Procesando....");

                    
                    },
                    success: function(respuesta){

                        console.log(respuesta);
                        
                        if(respuesta == 'success'){
                            swal("¡Se ha registrado exitosamente!", "", "success").
                            then((value) => {
                                window.location.replace("/Login");
                            });
                        }else{
                            swal("¡Hubo un error al registrarte!", "", "error").
                            then((value) => {
                                window.location.replace("/Login")
                            });
                        }

                    },
                    error:function (respuesta)
                    {
                        
                        console.log(respuesta);
                    }

                });
                }
                
                
        });
       
    });
</script>