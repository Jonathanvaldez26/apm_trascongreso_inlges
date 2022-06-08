<?php
echo $header;
?>
<script src="/backend/public/assets/js/plugins/choices.min.js"></script>

<body class="">
    <main class="main-content mt-0 ps">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('../../../assets/img/curved-images/musa (1).jpeg');">
            <span class="mask bg-gradient-dark opacity-1"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-dark mb-2 mt-5">¡Bienvenido!</h1>
                        <p class="text-lead text-dark">MUSA, Mujer Salud 2022. </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 mx-auto">

                    <div class="card z-index-0" id="basic-info">
                        <div class="card-header">
                            <h5>Información Básica</h5>

                            <?php //$userData; 
                            ?>
                        </div>
                        <form class="form-horizontal" id="update_form" action="/Register/DataPassword" method="POST">
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-12 col-lg-4">
                                        <!-- <input type="text" id="id_registro" name="id_registro" value="<?= $userData['id_registro'] ?> "> -->
                                        <label class="form-label"> Primer nombre *</label>
                                        <div class="input-group">
                                            <input id="nombre" name="nombre" maxlength="29" pattern="[a-zA-Z ÑñáÁéÉíÍóÚ]*" class="form-control" type="text" placeholder="Alec" required="" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['nombre'] ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label class="form-label">Segundo nombre </label>
                                        <div class="input-group">
                                            <input id="segundo_nombre" name="segundo_nombre" maxlength="49" pattern="[a-zA-Z ÑñáÁéÉíÍóÚ]*" class="form-control" type="text" placeholder="Alec" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['segundo_nombre'] ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label class="form-label">Apellido paterno *</label>
                                        <div class="input-group">
                                            <input id="apellido_paterno" name="apellido_paterno" maxlength="29" pattern="[a-zA-Z ÑñáÁéÉíÍóÚ]*" class="form-control" type="text" placeholder="Thompson" required="required" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['apellido_paterno'] ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-12 col-lg-4">
                                        <label class="form-label mt-4">Apellido materno *</label>
                                        <div class="input-group">
                                            <input id="apellido_materno" name="apellido_materno" maxlength="29" pattern="[a-zA-Z ÑñáÁéÉíÍóÚ]*" class="form-control" type="text" placeholder="Thompson" required="required" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['apellido_materno'] ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-12">
                                        <label class="form-label mt-4">Me identifico como: *</label>
                                        <select class="form-control" style="cursor: pointer;" name="genero" id="genero" placeholder="Genero">
                                            <option value="" selected disabled>Selecciona una opción</option>
                                            <!-- <option value="Mujer">Mujer</option>
                                            <option value="Otro">Otro</option> -->
                                            <?php echo $optionsGenero; ?>
                                        </select>
                                        <!-- <input type="text" class="form-control" value="<?= $userData['genero'] ?>" disabled> -->
                                    </div>
                                    <div class="col-sm-4 col-12">

                                        <label class="form-label mt-4">País de procedencia * </label>

                                        <select class="form-control" style="cursor: pointer;" name="pais" id="pais" tabindex="-1" data-choice="active" required>
                                            <option value="" selected disabled>Selecciona una opción</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Bolivia">Bolivia</option>
                                            <option value="Brasil">Brasil</option>
                                            <option value="Chile">Chile</option>
                                            <option value="Colombia">Colombia</option>
                                            <option value="Costa Rica">Costa Rica</option>
                                            <option value="Cuba">Cuba</option>
                                            <option value="Ecuador">Ecuador</option>
                                            <option value="El Salvador">El Salvador</option>
                                            <option value="Guatemala">Guatemala</option>
                                            <option value="Honduras">Honduras</option>
                                            <option value="México">México</option>
                                            <option value="Nicaragua">Nicaragua</option>
                                            <option value="Panamá">Panamá</option>
                                            <option value="Paraguay">Paraguay</option>
                                            <option value="Perú">Perú</option>
                                            <option value="Puerto Rico">Puerto Rico</option>
                                            <option value="República Dominicana">República Dominicana</option>
                                            <option value="Uruguay">Uruguay</option>
                                            <option value="Venezuela">Venezuela</option>
                                        </select>


                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5 col-12">
                                            <label class="form-label mt-4">Correo electrónico</label>
                                            <div class="input-group">
                                                <input id="email" name="email" maxlength="49" class="form-control" type="email" placeholder="example@email.com" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['email'] ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-12">
                                            <label class="form-label mt-4">Número de teléfono</label>
                                            <div class="input-group">
                                                <input id="telefono" name="telefono" maxlength="10" pattern="[0-9]" class="form-control" type="number" placeholder="+40 735 631 620" onfocus="focused(this)" onfocusout="defocused(this)" value="<?= $userData['telefono'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 align-self-center">
                                            <label class="form-label mt-4">Especialidad *</label>
                                            <select class="form-control" style="cursor: pointer;" name="especialidad" id="especialidad" tabindex="-1" data-choice="active" required>
                                                <!-- <option value="" selected disabled>Selecciona una opción</option> -->
                                                <?php echo $optionsLineaPrincipal; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-3 col-sm-12">
                                            <label class="form-label mt-4">Restricciones Alimentarias *</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="alergia" id="res_ali_1" value="Vegetariano">
                                                <label class="form-check-label" for="res_ali_1">
                                                    Vegetariano
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="alergia" id="res_ali_2" value="Vegano">
                                                <label class="form-check-label" for="res_ali_2">
                                                    Vegano
                                                </label>
                                            </div>
                                            <!-- <div class="form-check">
                                                <input class="form-check-input" type="radio" name="alergia" id="res_ali_3" value="kosher">
                                                <label class="form-check-label" for="res_ali_3">
                                                    Kosher
                                                </label>
                                            </div> -->
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="alergia" id="res_ali_4" value="Ninguna" checked>
                                                <label class="form-check-label" for="res_ali_4">
                                                    Ninguna
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="alergia" id="res_ali_5" value="Otro">
                                                <label class="form-check-label" for="res_ali_5">
                                                    Otro
                                                </label>
                                            </div>
                                            <div class="col-md-12 col-sm-12 alergia" style="display: none!important;">
                                                <label class="form-label mt-4">¿Cual?</label>
                                                <input id="alergia_cual" name="alergia_cual" maxlength="45" class="form-control" type="text" placeholder="Escriba su restricción" value="">

                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <p> Los campos marcados con (*) son obligatorios.</p>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <label class="form-label mt-4"><b>TÉRMINOS Y CONDICIONES</b></label>
                                            <div class="card z-index-0">

                                                <div class="card-body pt-1">

                                                    <!-- <input type="hidden" id="id_registro" name="id_registro" value="<?= $id_registro ?>"> -->
                                                    <input type="hidden" id="email" name="email" value="<?= $email ?>">
                                                    <div id="terminos" class="card-header pt-4 text-scroll " style="text-align: justify;">
                                                        <!-- <p>Aquí van los terminos y condiciones</p> -->
                                                        <span>

                                                            Términos y Condiciones de Uso del sitio Foro LATAM MUSA
                                                            <br><br>
                                                            Los siguientes términos y condiciones (los "Términos y Condiciones") rigen el uso
                                                            que usted le dé al sitio web Foro LATAM MUSA y a cualquiera de los contenidos
                                                            disponibles en ella, incluyendo cualquier contenido derivado de la misma ("La
                                                            página"). Asofarma de México S.A. de C.V. ("Asofarma" o "nosotros") ha puesto a
                                                            su disposición el sitio web. Podemos cambiar los Términos y Condiciones de vez en
                                                            cuando, en cualquier momento sin ninguna notificación, sólo publicando los cambios
                                                            en la plataforma. AL USAR EL SITIO, USTED ACEPTA Y ESTÉ DE ACUERDO
                                                            CON ESTOS TÉRMINOS Y CONDICIONES EN LO QUE SE REFIERE A SU USO
                                                            DE LA PÁGINA. Si usted no está de acuerdo con estos Términos y Condiciones, no
                                                            puede tener acceso al mismo ni usar la página de ninguna otra manera.<br><br>
                                                            1. Derechos de Propiedad. Entre usted y Asofarma, Asofarma es dueño único
                                                            y exclusivo, de todos los derechos, título e intereses en y de la página, de todo el
                                                            contenido (incluyendo, por ejemplo, audio, fotografías, ilustraciones, gráficos, otros
                                                            medios visuales, videos, copias, textos, software, títulos, archivos, etc.), códigos,
                                                            datos y materiales del mismo, el aspecto y el ambiente, el diseño y la organización
                                                            del sitio y la compilación de los contenidos, códigos, datos y los materiales en el
                                                            sitio, incluyendo, pero no limitado a, cualesquiera derechos de autor, derechos de
                                                            marca, derechos de patente, derechos de base de datos, derechos morales,
                                                            derechos sui generis y otras propiedades intelectuales y derechos patrimoniales del
                                                            mismo. Su uso del sitio web no le otorga propiedad de ninguno de los contenidos,
                                                            códigos, datos o materiales a los que pueda acceder en o a través del sitio web.
                                                            <br><br>
                                                            2. Licencia Limitada. Usted puede acceder y ver el contenido de la página
                                                            desde su dispositivo móvil o desde cualquier otro aparato y, a menos de que se
                                                            indique de otra manera en estos Términos y Condiciones o en el sitio, sacar copias
                                                            o impresiones individuales del contenido del sitio para su uso personal, interno
                                                            únicamente. El uso del sitio y de los servicios que se ofrecen en o a través del sitio,
                                                            son sólo para su uso personal y de apoyo en la práctica médica del profesional de
                                                            la salud.
                                                            <br><br>
                                                            3. Uso Prohibido. Cualquier distribución, publicación o explotación comercial o
                                                            promocional del sitio o de cualquiera de los contenidos, códigos, datos o materiales
                                                            en el sitio está estrictamente prohibida, a menos de que usted haya recibido el
                                                            previo permiso expreso por escrito del personal autorizado de Asofarma o de algún
                                                            otro poseedor de derechos aplicable. A no ser como está expresamente permitido
                                                            en el presente documento, usted no puede descargar, informar, exponer, publicar,
                                                            copiar, reproducir, distribuir, transmitir, modificar, ejecutar, difundir, transferir, crear
                                                            trabajos derivados de, vender o de cualquier otra manera explotar cualquiera de los
                                                            contenidos, códigos, datos o materiales en o disponibles a través del sitio. Usted se
                                                            obliga además a no alterar, editar, borrar, quitar, o de otra manera cambiar el
                                                            significado o la apariencia de, o cambiar el propósito de, cualquiera de los
                                                            contenidos, códigos, datos o materiales en o disponibles a través del sitio,
                                                            incluyendo, sin limitación, la alteración o retiro de cualquier marca comercial, marca
                                                            registrada, logo, marca de servicios o cualquier otro contenido de propiedad o
                                                            notificación de derechos de propiedad. Usted reconoce que no adquiere ningún
                                                            derecho de propiedad al descargar algún material con derechos de autor de o a
                                                            través del sitio. Si usted hace otro uso del sitio, o de los contenidos, códigos, datos
                                                            o materiales que ahí se encuentren o que estén disponibles a través del sitio, a no
                                                            ser como se ha estipulado anteriormente, usted puede violar las leyes de derechos
                                                            de autor y otras leyes en México y de otros países, así como las leyes estatales
                                                            aplicables, y puede ser sujeto a responsabilidad legal por dicho uso no autorizado.
                                                            <br><br>
                                                            4. Marcas Comerciales. Las marcas comerciales, logos, marcas de servicios,
                                                            marcas registradas (conjuntamente las "Marcas Comerciales") expuestas en el sitio
                                                            o en los contenidos disponibles a través del sitio son Marcas Comerciales de
                                                            Asofarma registradas y no registradas y otras, y no pueden ser usadas con respecto
                                                            a productos y/o servicios que no estén relacionados, asociados o patrocinados por
                                                            sus poseedores de derechos y que puedan causar confusión a los clientes, o de
                                                            alguna manera que denigre o desacredite a sus poseedores de derechos. Todas las
                                                            Marcas Comerciales que no sean de Asofarma que aparezcan en el sitio o en o a
                                                            través de los servicios del sitio, si las hubiera, son propiedad de sus respectivos
                                                            dueños. Nada que esté contenido en el sitio deberá ser interpretado como
                                                            otorgando, por implicación, desestimación, o de otra manera, alguna licencia o
                                                            derecho para usar alguna Marca Comercial expuesta en el sitio sin el permiso
                                                            escrito de Asofarma o de terceros que puedan ser dueños de dicha Marca
                                                            Comercial. El mal uso de las Marcas Comerciales expuestas en el sitio o en o a
                                                            través de cualquiera de los servicios del sitio está estrictamente prohibido.
                                                            <br><br>
                                                            5. Información del Usuario. En el curso del uso que usted haga del sitio y/o de
                                                            los servicios puestos a su disposición en o a través del sitio, se le puede pedir que
                                                            nos proporcione cierta información personalizada (dicha información en lo sucesivo
                                                            "Información del Usuario"). Las políticas de uso y recopilación de información de
                                                            Asofarma con respecto a la privacidad de dicha Información del Usuario se
                                                            establecen en el Aviso de Privacidad que podrás consultar en
                                                            www.asofarma.com.mx.
                                                            <br><br>
                                                            6. Materiales Presentados. A menos que se solicite específicamente, no
                                                            pedimos ni deseamos recibir ninguna información confidencial, secreta o
                                                            patrimonial, ni otro material de usted a través del sitio, por correo electrónico o de
                                                            cualquier otra manera. Cualquier información, trabajos creativos, demostración,
                                                            ideas, sugerencias, conceptos, métodos, sistemas, diseños, planes, técnicas u otros
                                                            materiales que nos haya mandado o presentado (incluyendo, por ejemplo y sin
                                                            limitación, aquello que usted presenta o envía a nuestros grupos de chateo, tablas
                                                            de mensajes y/o a nuestros ‘blogs’, o que nos manda vía correo electrónico)
                                                            ("Materiales Presentados") se considerará como no confidencial o secreto y que
                                                            puede ser usado por nosotros de cualquier manera consistente con el aviso de
                                                            privacidad del sitio. Al presentarnos o mandarnos Materiales Presentados, usted: (i)
                                                            representa y garantiza que los Materiales Presentados son originales suyos, que
                                                            ninguna otra persona tiene ningún derecho sobre ellos, y (ii) usted nos concede, a
                                                            nosotros y a nuestros afiliados, derecho y licencia libres de regalías, sin
                                                            restricciones, mundiales, perpetuos, irrevocables, no exclusivos y totalmente
                                                            transferibles, que pueden ser cedidos y sub-licenciados, para usar, copiar,
                                                            reproducir, modificar, adaptar, publicar, traducir, crear trabajos derivados de,
                                                            distribuir, ejecutar, exponer e incorporar en otros trabajos cualquiera de los
                                                            Materiales Presentados (todos o en parte) en cualquier forma, medio o tecnología
                                                            no conocida o por desarrollar, incluyendo propósitos promocionales y/o
                                                            comerciales. No podemos ser responsables de conservar ningún Material
                                                            Presentado proporcionado por usted y podemos borrar o destruir dicho Material
                                                            Presentado en cualquier momento.
                                                            <br><br>
                                                            7. Conducta Prohibida del Usuario. Usted garantiza y está de acuerdo en que,
                                                            mientras use el sitio web y los diversos servicios y artículos que se ofrecen en o a
                                                            través del sitio, usted no: (a) personalizará a ninguna persona o entidad ni
                                                            desvirtuará su afiliación con alguna otra persona o entidad; (b) insertará su propio
                                                            anuncio, posicionamiento de marca o algún otro contenido promocional o el de un
                                                            tercero en cualquiera de los contenidos, materiales o servicios o materiales del sitio
                                                            web ni usará, redistribuirá, republicará o explotará dichos contenidos o servicios con
                                                            cualquier otro propósito adicional comercial o promocional; ni (c) intentará ganar
                                                            acceso no autorizado a otros sistemas de cómputo a través del sitio web. Usted no:
                                                            (i) participará en navegar por la red, en "raspar (scraping) la pantalla", "raspar
                                                            (scraping) la base de datos", en recolectar direcciones de correo electrónico,
                                                            direcciones inalámbricas u otra información personal o de contactos, o cualquier
                                                            otro medio automático de obtener listas de usuarios u otra información de o a través
                                                            del sitio web o de los servicios ofrecidos en o a través del sitio web, incluyendo, sin
                                                            limitación, cualquier información que se encuentre en algún servidor o base de datos
                                                            relacionada con el sitio web o los servicios ofrecidos en o a través del sitio web; (ii)
                                                            obtendrá o intentará obtener acceso no autorizado a los sistemas de cómputo,
                                                            materiales o información por cualquier medio; (iii) usará el sitio web o los servicios
                                                            puestos a su disposición en o a través del sitio web de alguna manera con la
                                                            intención de interrumpir, dañar, deshabilitar, sobrecargar o deteriorar el sitio web o
                                                            dichos servicios, incluyendo, sin limitación, mandar mensajes masivos no
                                                            solicitados o "inundar" servidores con solicitudes; (iv) usará el sitio web o los
                                                            servicios o artículos del sitio web en violación de la propiedad intelectual o de otros
                                                            derechos legales o patrimoniales de Asofarma o de algún tercero; ni (v) usará el
                                                            sitio web o los servicios del sitio web en violación de cualquier ley aplicable. Usted
                                                            se obliga, además, a no intentar (o alentar o apoyar el intento de otro) a embaucar,
                                                            destruir, decodificar, o de otro modo alterar o interferir con el sitio web o con los
                                                            servicios del sitio web, o con cualquier contenido del mismo, o hacer cualquier uso
                                                            no autorizado del mismo. Usted se obliga a no usar el sitio web de alguna manera
                                                            que pudiera dañar, deshabilitar, sobrecargar o deteriorar el sitio web o interferir con
                                                            que cualquier otra persona pueda usar o disfrutar del sitio web o de cualquiera de
                                                            sus servicios. Usted no obtendrá ni intentará obtener algún material o información a
                                                            través de cualquier medio que no haya sido estipulado o puesto a la disposición del
                                                            público intencionalmente a través del sitio web.
                                                            <br><br>
                                                            8. Foros Públicos. Asofarma puede tener servicios de mensajería, servicios de
                                                            chateo, tableros de noticias, blogs, otros foros y otros servicios disponibles en o a
                                                            través del sitio web. Además de cualquier otra normatividad y regulación que
                                                            podamos publicar con respecto a un servicio en particular, usted se obliga a no
                                                            cargar, informar, transmitir, distribuir o de otra manera publicar a través del sitio web
                                                            o del sitio web, cualquier material que (i) restrinja o inhiba a cualquier otro usuario
                                                            de usar y disfrutar del sitio web o de los servicios del sitio web, (ii) sea fraudulento,
                                                            ilegal, amenazante, abusivo, hostigante, calumnioso, difamatorio, obsceno, vulgar,
                                                            ofensivo, pornográfico, profano, sexualmente explícito o indecente, (iii) constituya o
                                                            aliente conductas que pudieran constituir una ofensa criminal, dar lugar a
                                                            responsabilidad civil o de otro modo violar cualquier ley local, estatal, nacional o
                                                            internacional, (iv) viole, plagie o infrinja los derechos de terceros incluyendo, sin
                                                            limitación, derechos de autor, marcas comerciales, secretos comerciales,
                                                            confidencialidad, contratos, patentes, derechos de privacidad o publicidad o
                                                            cualquier otro derecho de propiedad, (v) contenga un virus, elemento de espionaje
                                                            u otro componente dañino, (vi) contenga enlaces fijos, publicidad, cartas de cadenas
                                                            o esquemas de pirámides de cualquier tipo, o (vii) constituya o contenga
                                                            indicaciones de origen, endosos o declaraciones de hechos falsos o engañosos.
                                                            Usted además se obliga a no personificar a cualquier otra persona o entidad, ya sea
                                                            real o ficticia, incluyendo cualquier persona de Asofarma. Usted tampoco puede
                                                            ofrecer comprar o vender algún producto o servicio en o a través de sus comentarios
                                                            presentados en nuestros foros. Solamente usted es responsable del contenido y de
                                                            las consecuencias de cualquiera de sus actividades.
                                                            <br><br>
                                                            9. Derecho de Monitoreo y Control de la Información. Asofarma se reserva el
                                                            derecho, pero no tiene la obligación, de monitorear y/o revisar todos los materiales
                                                            publicados en el sitio web o a través de los servicios o artículos del sitio web por los
                                                            usuarios, y Asofarma no es responsable de dichos materiales enviados por los
                                                            usuarios. Sin embargo, Asofarma se reserva el derecho en todo momento de
                                                            divulgar cualquier información que sea necesaria para satisfacer cualquier ley,
                                                            reglamento o solicitud gubernamental, o de editar, rehusarse a colocar o a quitar
                                                            cualquier información o materiales, todos o en parte, que a discreción únicamente
                                                            de Asofarma sean censurables o en violación de estos Términos de Uso, de las
                                                            políticas de Asofarma o de la ley aplicable. También podemos imponer límites sobre
                                                            ciertos artículos de los foros o restringir su acceso a parte o a todos los foros sin
                                                            notificación o sanción, si creemos que usted está en incumplimiento de las
                                                            directrices establecidas en este párrafo, nuestros términos y condiciones o la ley
                                                            aplicable, o por cualquier otra razón sin notificación o responsabilidad.
                                                            <br><br>
                                                            10. Información Privada o Delicada en Foros Públicos. Es importante que tenga
                                                            usted cuidado y sea selectivo acerca de la información personal que divulgue acerca
                                                            de usted y de otros, y en especial, no debe divulgar información delicada,
                                                            patrimonial o confidencial en sus comentarios en nuestros foros públicos.
                                                            <br><br>
                                                            11. Enlaces con el Sitio Web. Usted está de acuerdo en que si incluye un enlace
                                                            (link) de cualquier otro sitio web dentro del sitio web, dicho enlace se abrirá en una
                                                            nueva ventana navegadora y se enlazará con la versión completa de una página
                                                            formateada HTML de este Sitio Web. Usted no tiene permitido enlazarse
                                                            directamente a ninguna imagen almacenada en el sitio web o en nuestros servicios,
                                                            como sería usar un método de enlace "en-línea" para provocar que la imagen
                                                            almacenada por nosotros fuera expuesta en otro sitio web. Usted se obliga a no
                                                            descargar o usar imágenes almacenadas en este sitio web, en otro sitio web, con
                                                            cualquier propósito, incluyendo, sin limitación, publicar dichas imágenes en otro sitio
                                                            web. Usted se obliga a no enlazarse de cualquier otro sitio web a esta del sitio web
                                                            de tal manera que el sitio web, o cualquier página del sitio web, esté "enmarcado",
                                                            rodeado u ofuscado por los contenidos, materiales o posicionamientos de marca de
                                                            cualquier tercero. Nos reservamos todos nuestros derechos bajo la ley para insistir
                                                            en que cualquier enlace del sitio web sea descontinuado y a revocar su derecho a
                                                            enlazarse al sitio web a cualquier otro sitio web, en cualquier momento en el que le
                                                            mandemos notificación por escrito.
                                                            <br><br>
                                                            12. Indemnización. Usted se obliga a defender, indemnizar y a sacar a Asofarma
                                                            y a los directores, funcionarios, empleados y agentes de Asofarma y sus afiliados
                                                            en paz y a salvo de cualquier demanda, responsabilidad, costos y gastos, de
                                                            cualquier naturaleza, incluyendo honorarios de abogados, en que incurriera como
                                                            resultado del uso del sitio web, su colocación o transmisión de cualquier mensaje,
                                                            contenido, información, software u otros materiales a través del sitio web, o su
                                                            incumplimiento o violación de la ley o de estos Términos y Condiciones. Asofarma
                                                            se reserva el derecho, a su propio costo, de asumir la defensa y control exclusivos
                                                            de cualquier asunto de otra manera sujeto a indemnización por parte suya, y en
                                                            dicho caso, usted se obliga a cooperar con Asofarma en la defensa de dicha
                                                            demanda.
                                                            <br><br>
                                                            13. Sitios Web de Terceros. Usted puede enlazar (link) del sitio web a sitios web
                                                            de terceros. Usted reconoce y está de acuerdo en que nosotros no tenemos
                                                            responsabilidad sobre la información, contenido, productos, servicios, anuncios,
                                                            códigos u otros materiales que puedan o no puedan ser proporcionados por o a
                                                            través de los Sitios Enlazados, aún si son propiedad de o son dirigidos por afiliados
                                                            nuestros. Los enlaces (links) a Sitios Enlazados no constituyen un aval o patrocinio
                                                            nuestro de dichos sitios web o de la información, contenido, productos, servicios,
                                                            anuncios, códigos u otros materiales presentados en o a través de dichos sitios web.
                                                            La inclusión de cualquier enlace a dichos sitios en nuestro sitio web, no implica el
                                                            aval, patrocinio o recomendación de ese sitio de Asofarma. Asofarma rechaza
                                                            cualquier responsabilidad por los enlaces (1) de otro sitio web a esta aplicación y
                                                            (2) a otro sitio web de esta aplicación. Asofarma no puede garantizar los estándares
                                                            de cualquier sitio web al cual se le proporcionen enlaces en este sitio web, ni será
                                                            Asofarma responsable de los contenidos de dichos sitios, o de cualquier enlace
                                                            subsecuente. Asofarma no representa o garantiza que los contenidos del sitio web
                                                            de algún tercero sean exactos, que cumplan con la ley estatal o federal, o que
                                                            cumplan con las leyes de derechos de autor o con otras leyes de propiedad
                                                            intelectual. Asofarma tampoco es responsable de cualquier forma de transmisión
                                                            recibida de cualquier sitio web enlazado. Cualquier confianza depositada en los
                                                            contenidos de un sitio web de terceros es hecha por su propio riesgo y usted asume
                                                            todas las responsabilidades y consecuencias que resulten de dicha confianza.
                                                            <br><br>
                                                            14. Agente de Derechos de Autor.
                                                            Respetamos los derechos de propiedad intelectual de otros y requerimos que las
                                                            personas que usen el sitio web o los servicios o artículos puestos a su disposición
                                                            en o a través del sitio web, hagan lo mismo. Si usted cree que su trabajo ha sido
                                                            copiado de un modo que constituya una infracción a los derechos de autor, por favor
                                                            mande la siguiente información a Asofarma a través de la dirección electrónica
                                                            atencion_clientes@asofarma.com.mx
                                                            <br><br>
                                                            15. RENUNCIA DE GARANTÍAS. EL SITIO WEB INCLUYENDO, SIN
                                                            LIMITACIÓN, TODOS LOS SERVICIOS, CONTENIDOS, FUNCIONES Y
                                                            MATERIALES PROPORCIONADOS A TRAVÉS DFEL SITIO WEB SON
                                                            PROPORCIONADOS "TAL COMO ESTÉN", "COMO SE PONEN A LA
                                                            DISPOSICIÓN", SIN GARANTÍA DE NINGÚN TIPO, YA SEA EXPRESA O
                                                            IMPLÍCITA, INCLUYENDO, SIN LIMITACIÓN, CUALQUIER GARANTÍA DE
                                                            INFORMACIÓN, DATOS, SERVICIOS DE PROCESAMIENTO DE DATOS,
                                                            ACCESO ILIMITADO O ININTERRUMPIDO, CUALQUIER GARANTÍA CON
                                                            RESPECTO A LA DISPONIBILIDAD, INTERPRETABILIDAD, NO
                                                            INTERPRETABILIDAD, EXACTITUD, PRECISIÓN, RECTITUD, PERFECCIÓN,
                                                            CONCLUSIÓN, UTILIDAD, O CONTENIDO DE LA INFORMACIÓN, Y CUALQUIER
                                                            GARANTÍA DE TÍTULO, NO-INFRACCIÓN, COMERCIABILIDAD O APTITUD
                                                            PARA UN PROPÓSITO EN PARTICULAR, Y EN EL PRESENTE RENUNCIAMOS
                                                            A CUALQUIERA Y A TODAS DICHAS GARANTÍAS, EXPRESAS E IMPLÍCITAS.
                                                            NO GARANTIZAMOS QUE EL SITIO WEB O LOS SERVICIOS, CONTENIDOS,
                                                            FUNCIONES O MATERIALES PROPORCIONADOS A TRAVÉS DEL SITIO WEB
                                                            SERÁN OPORTUNOS, SEGUROS, ININTERRUMPIDOS O LIBRES DE ERROR,
                                                            O QUE LOS DEFECTOS SERÁN CORREGIDOS. NO DAMOS GARANTÍA DE
                                                            QUE EL SITIO WEB O DE QUE LOS SERVICIOS PROPORCIONADOS
                                                            CUMPLIRÁN CON LOS REQUERIMIENTOS DE LOS USUARIOS. NINGÚN
                                                            CONSEJO, RESULTADOS O INFORMACIÓN, YA SEA ORAL O ESCRITO, QUE
                                                            USTED OBTENGA DE NOSOTROS A TRAVÉS DEL SITIO WEB CREARÁ
                                                            ALGUNA GARANTÍA QUE NO HAYA SIDO ESTABLECIDA EXPRESAMENTE EN
                                                            EL PRESENTE. ASOFARMA TAMPOCO ASUME NINGUNA RESPONSABILIDAD,
                                                            Y NO SERÉ RESPONSABLE DE CUALQUIER DAÑO A, O DE CUALQUIER VIRUS
                                                            QUE PUDIERA INFECTAR SU EQUIPO A CAUSA DE SU ACCESO A, USO DE, O
                                                            NAVEGACIÓN EN EL SITIO WEB O POR DESCARGAR CUALQUIERA DE LOS
                                                            MATERIALES, DATOS, TEXTOS, IMÁGENES, CONTENIDOS DE VIDEO O
                                                            CONTENIDOS DE AUDIO DEL SITIO WEB. SI USTED NO ESTÁ SATISFECHO
                                                            CON EL SITIO WEB, SU ÚNICA SOLUCIÓN ES DESCONTINUAR USANDO EL
                                                            SITIO WEB.
                                                            TRATAMOS DE ASEGURAR QUE LA INFORMACIÓN PUBLICADA EN EL SITIO
                                                            WEB ES CORRECTA Y ACTUALIZADA. NOS RESERVAMOS EL DERECHO DE
                                                            CAMBIAR O HACER CORRECCIONES A CUALQUIER INFORMACIÓN
                                                            PROPORCIONADA EN EL SITIO WEB EN CUALQUIER MOMENTO Y SIN
                                                            NINGÚN AVISO PREVIO. ASOFARMA NI AVALA NI ES RESPONSABLE DE LA
                                                            EXACTITUD O VERACIDAD DE CUALQUIER OPINIÓN, CONSEJO O
                                                            DECLARACIÓN EN EL SITIO WEB, NI DE CUALQUIER PUBLICACIÓN
                                                            OFENSIVA, DIFAMATORIA, OBSCENA, INDECENTE, ILEGAL O VIOLATORIA
                                                            HECHA EN EL MISMO POR CUALQUIER PERSONA A NO SER UN EMPLEADO
                                                            PORTAVOZ AUTORIZADO POR ASOFARMA EN SU CARÁCTER OFICIAL
                                                            (INCLUYENDO, SIN LIMITACIÓN, OTROS USUARIOS D EL SITIO WEB. ES SU
                                                            RESPONSABILIDAD EVALUAR LA EXACTITUD, CONCLUSIÓN O UTILIDAD DE
                                                            CUALQUIER INFORMACIÓN, OPINIÓN, CONSEJO U OTRO CONTENIDO
                                                            DISPONIBLE A TRAVÉS D EL SITIO WEB. POR FAVOR BUSQUE EL CONSEJO
                                                            DE PROFESIONALES, SEGÚN SEA APROPIADO, CON RESPECTO A LA
                                                            EVALUACIÓN DE CUALQUIER INFORMACIÓN, OPINIÓN, CONSEJO U OTRO
                                                            CONTENIDO ESPECÍFICO, INCLUYENDO PERO NO LIMITADO A,
                                                            INFORMACIÓN, OPINIÓN, CONSEJO U OTRO CONTENIDO FINANCIERO, DE
                                                            SALUD O DE ESTILO DE VIDA.
                                                            SIN LIMITACIÓN DE LO ANTES MENCIONADO EN ESTA SECCIÓN,
                                                            ASOFARMA, Y SUS AFILIADOS, PROVEEDORES Y PERSONAS QUE
                                                            OTORGAN LAS LICENCIAS NO DAN GARANTÍAS NI REPRESENTACIONES
                                                            CON RESPECTO A CUALQUIER SERVICIO ORDENADO O PROPORCIONADO
                                                            VÍA EL SITIO WEB, Y EN EL PRESENTE RENUNCIAN, Y USTED EN EL
                                                            PRESENTE DESISTE, DE CUALQUIERA Y DE TODAS LAS GARANTÍAS Y
                                                            REPRESENTACIONES HECHAS A LITERATURA EN PRODUCTOS O
                                                            SERVICIOS, A PREGUNTAS HECHAS FRECUENTEMENTE EN DOCUMENTOS
                                                            Y DE ALGUNA OTRA MANERA EN EL SITIO WEB O EN CORRESPONDENCIA
                                                            CON ASOFARMA O CON SUS AGENTES. CUALQUIER PRODUCTO O
                                                            SERVICIO ORDENADO O PROPORCIONADO VÍA EL SITIO WEB ES
                                                            PROPORCIONADO POR ASOFARMA "TAL COMO ESTÉ", EXCEPTO AL
                                                            GRADO, SI SE DIERA EL CASO, DE ESTAR DE OTRO MODO ESTABLECIDO
                                                            POR ESCRITO, EN UN CONTRATO DE LICENCIA O VENTA CELEBRADO POR
                                                            SEPARADO ENTRE USTED Y ASOFARMA O SU PROVEEDOR O LA PERSONA
                                                            QUE OTORGA LA LICENCIA.
                                                            <br><br>
                                                            16. LÍMITE DE RESPONSABILIDAD. EN NINGÚN CASO, INCLUYENDO PERO
                                                            NO LIMITADO A NEGLIGENCIA, SERÁ RESPONSABLE ASOFARMA, O
                                                            CUALQUIERA DE SUS DIRECTORES, FUNCIONARIOS, EMPLEADOS,
                                                            AGENTES O PROVEEDORES, DEL CONTENIDO O DE LOS SERVICIOS
                                                            (CONJUNTAMENTE, LAS "ENTIDADES PROTEGIDAS") DE CUALQUIER DAÑO
                                                            DIRECTO, INDIRECTO, ESPECIAL, INCIDENTAL, CONSECUENTE, EJEMPLAR
                                                            O PUNITIVO COMO RESULTADO DE, O DIRECTA O INDIRECTAMENTE
                                                            RELACIONADO CON, EL USO DE, O LA INCAPACIDAD DE USAR EL SITIO WEB
                                                            O LOS CONTENIDOS, MATERIALES Y FUNCIONES RELACIONADOS CON EL
                                                            MISMO, SU PROVISIÓN DE INFORMACIÓN VÍA EL SITIO WEB, NEGOCIOS
                                                            PERDIDOS O VENTAS PERDIDAS, AÚN CUANDO DICHA ENTIDAD
                                                            PROTEGIDA HAYA SIDO ASESORADA SOBRE LA POSIBILIDAD DE DICHOS
                                                            DAÑOS. ALGUNAS JURISDICCIONES NO PERMITEN LA LIMITACIÓN O
                                                            EXCLUSIÓN DE RESPONSABILIDAD POR DAÑOS INCIDENTALES O
                                                            INDIRECTOS ASÍ QUE ALGUNOS DE LAS LIMITACIONES ARRIBA
                                                            MENCIONADAS NO APLICAN A ALGUNOS USUARIOS. EN NINGÚN CASO
                                                            SERÁN RESPONSABLES LAS ENTIDADES PROTEGIDAS POR O EN
                                                            RELACIÓN CON CUALQUIER CONTENIDO PUBLICADO, TRANSMITIDO,
                                                            INTERCAMBIADO O RECIBIDO POR O EN NOMBRE DE CUALQUIER USUARIO
                                                            O DE OTRA PERSONA EN O A TRAVÉS DEL SITIO WEB. EN NINGÚN CASO LA
                                                            SUMA TOTAL DE LAS RESPONSABILIDADES DE LAS ENTIDADES
                                                            PROTEGIDAS HACIA USTED, POR TODOS LOS DAÑOS, PÉRDIDAS Y CAUSAS
                                                            DE ACCIÓN PENAL (YA SEA POR CONTRATO O POR AGRAVIO, INCLUYENDO,
                                                            PERO NO LIMITADO A, NEGLIGENCIA O DE ALGUNA OTRA MANERA) QUE
                                                            RESULTEN DE LOS TÉRMINOS Y CONDICIONES O DEL USO QUE USTED
                                                            HAGA DEL SITIO WEB, DEBERÁ EXCEDER EN LA SUMA TOTAL, LA CANTIDAD,
                                                            SI LA HUBIERA, PAGADA POR USTED A ASOFARMA POR EL USO DEL SITIO
                                                            WEB.
                                                            <br><br>
                                                            17. Ataques Fotosensibles. Un muy pequeño porcentaje de personas pueden
                                                            experimentar un ataque al ser expuestas a ciertas imágenes visuales, como luces
                                                            o dibujos intermitentes que pueden aparecer en juegos de video o en otros
                                                            contenidos electrónicos o en línea. Aún personas que no tienen historia de ataques
                                                            o de epilepsia pueden tener una condición no diagnosticada que puede causar estos
                                                            "ataques epilépticos fotosensibles" al estar viendo juegos de video u otros
                                                            contenidos electrónicos. Estos ataques tienen una variedad de síntomas,
                                                            incluyendo mareos, desorientación, confusión, pérdida momentánea de conciencia,
                                                            crispación de ojos o cara, visión alterada o tirones o sacudidas de brazos o piernas.
                                                            Si usted experimenta cualquiera de los síntomas anteriormente mencionados, o si
                                                            usted o su familia tiene historia de ataques o epilepsia, debe de dejar
                                                            inmediatamente de usar el sitio web y consultar un doctor.
                                                            <br><br>
                                                            18. Leyes Aplicables. Nosotros controlamos y operamos el sitio web desde
                                                            nuestras oficinas en México. No representamos a los materiales en el sitio web
                                                            como apropiados o disponibles para su uso en otros lugares. Las personas que
                                                            escojan acceder al sitio web desde otros lugares lo harán por su propia iniciativa y
                                                            son responsables del cumplimiento de las leyes locales, si y al grado en que las
                                                            leyes locales sean aplicables. Todas las partes sujetas a estos términos y
                                                            condiciones renuncian a sus derechos respectivos a un juicio con jurado.
                                                            <br><br>
                                                            19. Término. Asofarma puede terminar, cambiar, suspender o descontinuar
                                                            cualquier aspecto del sitio web o de los servicios del sitio web en cualquier
                                                            momento. Asofarma puede restringir, suspender o terminar su acceso al sitio web
                                                            y/o a sus servicios si creemos que usted está en incumplimiento de nuestros
                                                            términos y condiciones o de la ley aplicable, o por cualquier otra razón sin
                                                            notificación o responsabilidad. Asofarma mantiene una política que estipula la
                                                            terminación, en circunstancias apropiadas, de los privilegios de uso del sitio web
                                                            para usuarios que son violadores repetitivos de los derechos de propiedad
                                                            intelectual.
                                                            <br><br>
                                                            20. Cambios de Términos de Uso. Asofarma se reserva el derecho, a su sola
                                                            discreción, de cambiar, modificar, añadir o quitar cualquier porción de los Términos
                                                            y Condiciones, toda o en parte, en cualquier momento. Los cambios en los Términos
                                                            y Condiciones serán efectivos cuando se publiquen. La continuación del uso del sitio
                                                            web y/o de los servicios puestos a disposición en o a través del sitio web después
                                                            de haber sido publicado cualquier cambio, será considerado como aceptación de
                                                            esos cambios.
                                                            <br><br>
                                                            21. Misceláneos. Los Términos y Condiciones y la relación entre usted y
                                                            nosotros, serán regidos por las leyes de México, sin consideración a conflictos de
                                                            disposiciones de ley. Usted se obliga a que cualquier causa de acción legal que
                                                            resulte bajo los Términos y Condiciones será iniciada en México. Usted se obliga a
                                                            someterse a la jurisdicción personal y exclusiva de las cortes localizadas dentro del
                                                            en México. Nuestra falla al ejercer y hacer valer cualquier derecho o disposición de
                                                            los Términos y Condiciones no constituirá una renuncia a dicho derecho o
                                                            disposición. Si cualquier disposición de los Términos y Condiciones es encontrada
                                                            inválida por una corte de jurisdicción competente, las partes, sin embargo, están de
                                                            acuerdo en que la corte deberá esforzarse en aplicar las intenciones de las partes
                                                            como están reflejadas en la disposición, y las otras disposiciones de los Términos y
                                                            Condiciones permanecen vigentes.
                                                            <br><br>
                                                            Estos Términos y Condiciones fueron actualizados el 27/08/2021
                                                        </span>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="1" id="terminos" name="terminos" required>
                                                                <label class="form-check-label" for="terminos">
                                                                    <b>He leído y acepto los términos y condiciones de Farmacovigilancia</b>
                                                                </label>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br><br>

                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <label class="form-label mt-4"><b>AVISO DE PRIVACIDAD</b></label>
                                            <div class="card z-index-0">

                                                <div class="card-body pt-1">

                                                    <!-- <input type="hidden" id="id_registro" name="id_registro" value="<?= $id_registro ?>"> -->
                                                    <input type="hidden" id="email" name="email" value="<?= $email ?>">
                                                    <div id="terminos" class="card-header pt-4 text-scroll" style="text-align: justify;">
                                                        <!-- <p>Aquí van los terminos y condiciones</p> -->
                                                        <span>

                                                            I. IDENTIDAD Y DOMICILIO DEL RESPONSABLE:
                                                            <br> <br>
                                                            El Responsable del tratamiento, uso, y protección de sus datos personales es Asofarma de México, S.A. de C.V., (en lo sucesivo “Asofarma”) con domicilio fiscal ubicado en Calzada México Xochimilco No. 43, Col. San Lorenzo Huipulco, Alcaldía Tlalpan, C.P.14370, Ciudad de México, y oficinas corporativas en Avenida Santa Fe 485, Col. Lomas de Santa Fe, Contadero, Alcaldía Cuajimalpa de Morelos, CP 01219, Ciudad de México .Para todo lo relacionado con este Aviso de Privacidad Integral, favor de contactarnos a través del correo electrónico avisoprivacidad@asofarma.com.mx o bien, dirigir un escrito a los domicilios establecidos anteriormente. Lo anterior, de conformidad con lo dispuesto en la Ley Federal de Protección de Datos Personales en Posesión de los Particulares y demás disposiciones aplicables.
                                                            <br> <br>
                                                            II. DATOS PERSONALES QUE SERÁN TRATADOS POR EL RESPONSABLE:
                                                            Los datos personales, tales como: Nombre completo, teléfono fijo y/o celular, correo electrónico, dirección, RFC y/o CURP entre otros, que recabamos de usted, en los términos de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, son necesarios para el servicio, adquisición o contratación que solicita, los cuales utilizaremos para alguna de las siguientes finalidades:
                                                            <br> <br>
                                                            I) Para fines de identificación;
                                                            <br> <br>
                                                            II) Para fines estadísticos, y;
                                                            <br> <br>
                                                            III) Para fines de estudio, investigación médica o farmacológica.
                                                            <br> <br>
                                                            IV) Para fines laborales.
                                                            <br> <br>
                                                            V) Para fines de proveeduría o prestación de servicios.
                                                            <br> <br>
                                                            Adicionalmente, le comunicamos que sus datos o información personal, de contacto, laboral o patrimonial, que usted nos proporcione, la utilizaremos para fines mercadotécnicos, publicitarios o de prospección, que no son necesarios para el servicio, adquisición o contratación solicitados, pero que nos permiten y facilitan brindarle una mejor atención.
                                                            <br> <br>
                                                            En caso de que no desee que sus datos personales o sus datos personales sensibles sean utilizados para estos efectos, agradeceremos se sirva notificar dicha decisión mediante escrito enviado a cualquiera de nuestros domicilios ya señalados, dirigido al(a) responsable del manejo de dichos datos en Asofarma de Mexico, S.A. de C.V.
                                                            <br> <br>
                                                            La negativa para el uso de sus datos personales con los fines antes descritos, no podrá ser un motivo para que le neguemos los servicios o productos que solicita, adquiere o contrata con nosotros.
                                                            <br> <br>
                                                            A. DATOS SENSIBLES QUE SERÁN TRATADOS POR EL RESPONSABLE:
                                                            <br> <br>
                                                            Para los fines descritos en el presente aviso de privacidad, utilizaremos los siguientes datos personales considerados como sensibles, que requieren de especial protección, tales como: enfermedades que padece, alergias, medicamentos o preferencia sexual.
                                                            <br> <br>
                                                            III. TRANSFERENCIA DE DATOS:
                                                            Le informamos que sus datos personales son compartidos dentro y fuera del país con personas, empresas, organizaciones o autoridades distintas a nosotros, con quien tenemos una relación corporativa, de proveeduría, prestación de servicios, investigación o de gestiones administrativas, para los fines establecidos en el presente aviso, por lo que su aceptación para este tratamiento usted la otorga al proporcionarnos dichos datos y al aceptar o utilizar nuestros servicios o productos que solicita, adquiere o contrata.
                                                            <br> <br>
                                                            Usted tiene el derecho de negar su consentimiento para que sus datos personales o datos personales sensibles sean transferidos en la forma indicada en el párrafo anterior, para tal efecto agradeceremos se sirva notificar dicha decisión a Asofarma de Mexico SA de CV mediante escrito enviado a cualquiera de nuestros domicilios señalados.
                                                            <br> <br>
                                                            En caso de transferencia de sus datos, Asofarma de México, S.A de C.V, dará a conocer el presente Aviso de Privacidad a los terceros a quienes se les transfiera, quienes en ese acto adquirirán el carácter de Encargados y deberán respetar en todo momento su contenido.
                                                            <br> <br>
                                                            IV. MEDIOS PARA EJERCICIO DE LOS DERECHOS DE ACCESO, RECTIFICACIÓN, CANCELACIÓN U OPOSICIÓN (“DERECHOS ARCO”):
                                                            <br> <br>
                                                            Asimismo, usted tiene derecho a: i) conocer qué datos personales tenemos de usted, para qué los utilizamos y las condiciones del uso que les damos (Acceso); ii) solicitar la corrección de su información personal en caso de que esté desactualizada, sea inexacta o incompleta (Rectificación); iii) que la eliminemos de nuestros registros o bases de datos cuando considere que la misma no está siendo utilizada conforme a los principios, deberes y obligaciones previstas en la normativa (Cancelación) y; iv) a oponerse al uso de sus datos personales para fines específicos (Oposición). Estos derechos se conocen como derechos ARCO. Para el ejercicio de cualquiera de los derechos ARCO, usted o su representante legal, deberá presentar la solicitud respectiva, mediante el envío de un correo electrónico a la dirección electrónica avisoprivacidad@asofarma.com.mx o a través de escrito libre, dirigido a cualquiera de los dos domicilios descritos en el presente aviso.
                                                            <br> <br>
                                                            V. REVOCACIÓN DEL CONSENTIMIENTO PARA EL TRATAMIENTO DE DATOS PERSONALES:
                                                            <br> <br>
                                                            Usted puede revocar el consentimiento que, en su caso, nos haya otorgado para el tratamiento de sus datos personales o sus datos personales sensibles; sin embargo, es importante que tenga en cuenta que no en todos los casos podremos atender su solicitud o concluir el uso de forma inmediata, ya que es posible que por alguna obligación legal requiramos seguir tratando sus datos personales. Asimismo, usted deberá considerar que, para ciertos fines, la revocación de su consentimiento implicará que no le podamos seguir prestando el servicio que nos solicitó o la conclusión de su relación con nosotros.
                                                            <br> <br>
                                                            VI. USO DE COOKIES:
                                                            <br> <br>
                                                            Le informamos que en nuestra página de Internet utilizamos cookies, web beacons y otras tecnologías a través de las cuales es posible monitorear su comportamiento como usuario de Internet, brindarle un mejor servicio y experiencia de usuario al navegar en nuestra página, así como ofrecerle nuevos productos y servicios basados en sus preferencias.
                                                            <br> <br>
                                                            Sus datos personales jamás serán divulgados, ni se les dará un uso distinto al señalado en el presente Aviso de Privacidad Integral.
                                                            <br> <br>
                                                            VI. PRINCIPIOS DE TRATAMIENTO DE DATOS PERSONALES:
                                                            <br> <br>
                                                            Asofarma de México, S.A. de C.V. tratará y resguardará sus datos personales con base en los principios de licitud, calidad, consentimiento, información, finalidad, lealtad, proporcionalidad y responsabilidad establecidos en la Ley Federal de Protección de Datos Personales en Posesión de los Particulares.
                                                            <br> <br>
                                                            IX. PROCEDIMIENTO PARA EL EJERCICIO DE “DERECHOS ARCO”
                                                            <br> <br>
                                                            Respecto de sus datos personales, usted podrá ejercer los derechos de acceso, rectificación, cancelación y/u oposición (Derechos ARCO) mediante el envío de un correo electrónico a la siguiente dirección: avisoprivacidad@asofarma.com.mx. Para ser procesada su petición, ésta deberá incluir todos y cada uno de los requisitos previstos en el artículo 29 de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares.
                                                            <br> <br>
                                                            X. MODIFICACIONES AL AVISO DE PRIVACIDAD INTEGRAL
                                                            <br> <br>
                                                            El presente aviso de privacidad puede sufrir modificaciones, cambios o actualizaciones derivadas de nuevos requerimientos legales; de nuestras propias necesidades por los productos o servicios que ofrecemos; de nuestras prácticas de privacidad; de cambios en nuestro modelo de negocio, o por otras causas; por lo que Asofarma de México, S.A. de C.V. se reserva el derecho a modificar, cambiar o actualizar dicho Aviso en el futuro, lo cual se hará de su conocimiento mediante su publicación en las páginas web www.asofarma.com.mx o en www.asofarma.com.mx/Aviso_Privacidad.pdf, las cuales la cual puede usted consultar en cualquier momento.
                                                            <br> <br>
                                                            Asofarma de México, S.A. de C.V. no será responsable en el caso de que existiere algún problema en la de transmisión de datos por internet. Sin embargo, por su seguridad, el Aviso de Privacidad vigente estará disponible en todo momento en las páginas web señaladas en el punto anterior.
                                                            <br> <br>
                                                            XI. CUMPLIMIENTO DE LA LEY DE PROTECCIÓN DE DATOS PERSONALES EN POSESIÓN DE LOS PARTICULARES. Este aviso de privacidad cumple con los requisitos establecidos en la Ley Federal de Protección de Datos Personales en Posesión de los Particulares vigente y demás normatividad aplicable.
                                                            <br> <br>
                                                            Ultima actualización Diciembre 2020
                                                        </span>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="1" id="terminos1" name="terminos1" required>
                                                                <label class="form-check-label" for="terminos1">
                                                                    <b>He leído y acepto los términos y condiciones del aviso de privacidad</b>
                                                                </label>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <p> <b>Al dar clic en el botón siguiente, usted acepta que la información proporcionada es real y fidedigna.</b></p>


                                    <!-- <div class="row">
                                        
                                        
                                    </div> -->

                                    <div class="row">
                                        <div class="button-row d-flex mt-4 col-12">
                                            <a class="btn bg-gradient-light mb-0 js-btn-prev" href="/Register" title="Prev">Regresar</a>
                                            <button class="btn bg-gradient-dark ms-auto mb-0" type="submit" title="Next">Siguiente</button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </main>

</body>

<?php echo $footer; ?>

<script>
    $(document).ready(function() {
        $('input:radio[name="alergia"]').change(function() {
            if ($("#res_ali_5").is(':checked')) {
                $(".alergia").css("display", "block");
                $("#alergia_cual").val("");
                $("#alergia_cual").attr('required', 'required');
            } else {
                $(".alergia").css("display", "none");
                $('#alergia_cual').removeAttr('required');
            }

        });
    });
</script>