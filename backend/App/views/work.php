
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/apple-icon.png">
    <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/Musa0-01.png">
    <title>
        En Proceso
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../../../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../../../assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
</head>

<body class="error-page">
<main class="main-content  mt-0">
    <div>
        <section class="min-vh-95 d-flex align-items-center">
            <div class="container">
                <div class="row mt-lg-0 mt-1">
                    <div class="col-lg-5 my-auto">
                        <h1 class="display-1 text-bolder text-gradient text-rosa fadeIn1 fadeInBottom mt-5">Disculpa</h1>
                        <h2 class="fadeIn3 fadeInBottom opacity-8">Estamos trabajando</h2>
                        <p class="lead opacity-6 fadeIn2 fadeInBottom">Le sugerimos que vaya a la página de inicio mientras terminamos esté bloque...</p>
                        <a href="/Home/" type="button" class="btn bg-gradient-info mt-4 fadeIn2 fadeInBottom">Ir a la página de inicio</a>
                    </div>
                    <div class="col-lg-7 my-auto">
                        <img class="w-100 fadeIn1 fadeInBottom" src="../../../img/error-02.png" alt="500-error">
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
<!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
<footer class="footer pt-2">
    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto text-center mt-0">
                <p class="mb-0 text-secondary">
                    Copyright © <script>
                        document.write(new Date().getFullYear())
                    </script> Grupo LAHE.
                </p>
            </div>
        </div>
    </div>
</footer>
<!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
<!--   Core JS Files   -->
<script src="../../../assets/js/core/popper.min.js"></script>
<script src="../../../assets/js/core/bootstrap.min.js"></script>
<script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
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
<script src="../../../assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
</body>

</html>