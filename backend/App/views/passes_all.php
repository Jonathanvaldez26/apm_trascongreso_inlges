<?php echo $header; ?>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="true">
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
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Principal</a></li>
                </ol>
            </nav>

            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <div class="input-group"></div>
                </div>

                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        <a href="/Home/" class="nav-link text-body font-weight-bold px-0">
                            <i class="fa fa-home me-sm-0"></i>
                            <span class="d-sm-inline d-none">Inicio</span>
                        </a>
                    </li>
                </ul>
                <ul></ul>
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
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-7 col-lg-7 mt-lg-0 mt-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card p-3">
                            <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('../../assets/img/ivancik.png');">
                                <span class="mask bg-gradient-dark"></span>
                                <div class="card-body position-relative z-index-1 h-100 p-3">
                                    <h6 class="text-white font-weight-bolder mb-3">Hey <?php echo $nombre_completo;?> </h6>
                                    <p class="text-white mb-3">Los boletos estarán disponibles en todo momento con días de anticipación, una vez tengamos tus comprobantes de vacunación y tu prueba Covid.</p>
                                    <a class="btn btn-round btn-outline-white mb-0" href="https://api.whatsapp.com/send?phone=+5215627307605&text=¡Hola, necesito ayuda con mis pases de abordar!">
                                        ¡QUIERO CONTACTAR A SOPORTE!
                                        <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6">
                        <div class="card mt-4">
                            <div class="card-header pb-0 p-4">
                                <h6 class="mb-4">Tus Pases de Abordar</h6>
                            </div>
                            <div class="card-body p-3">
                                <ul class="list-group">
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                <svg width="12px" height="12px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="mt-1">
                                                    <title>spaceship</title>
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <g transform="translate(-1720.000000, -592.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                            <g transform="translate(1716.000000, 291.000000)">
                                                                <g transform="translate(4.000000, 301.000000)">
                                                                    <path d="M39.3,0.706666667 C38.9660984,0.370464027 38.5048767,0.192278529 38.0316667,0.216666667 C14.6516667,1.43666667 6.015,22.2633333 5.93166667,22.4733333 C5.68236407,23.0926189 5.82664679,23.8009159 6.29833333,24.2733333 L15.7266667,33.7016667 C16.2013871,34.1756798 16.9140329,34.3188658 17.535,34.065 C17.7433333,33.98 38.4583333,25.2466667 39.7816667,1.97666667 C39.8087196,1.50414529 39.6335979,1.04240574 39.3,0.706666667 Z M25.69,19.0233333 C24.7367525,19.9768687 23.3029475,20.2622391 22.0572426,19.7463614 C20.8115377,19.2304837 19.9992882,18.0149658 19.9992882,16.6666667 C19.9992882,15.3183676 20.8115377,14.1028496 22.0572426,13.5869719 C23.3029475,13.0710943 24.7367525,13.3564646 25.69,14.31 C26.9912731,15.6116662 26.9912731,17.7216672 25.69,19.0233333 L25.69,19.0233333 Z"></path>
                                                                    <path d="M1.855,31.4066667 C3.05106558,30.2024182 4.79973884,29.7296005 6.43969145,30.1670277 C8.07964407,30.6044549 9.36054508,31.8853559 9.7979723,33.5253085 C10.2353995,35.1652612 9.76258177,36.9139344 8.55833333,38.11 C6.70666667,39.9616667 0,40 0,40 C0,40 0,33.2566667 1.855,31.4066667 Z"></path>
                                                                    <path d="M17.2616667,3.90166667 C12.4943643,3.07192755 7.62174065,4.61673894 4.20333333,8.04166667 C3.31200265,8.94126033 2.53706177,9.94913142 1.89666667,11.0416667 C1.5109569,11.6966059 1.61721591,12.5295394 2.155,13.0666667 L5.47,16.3833333 C8.55036617,11.4946947 12.5559074,7.25476565 17.2616667,3.90166667 L17.2616667,3.90166667 Z" opacity="0.598539807"></path>
                                                                    <path d="M36.0983333,22.7383333 C36.9280725,27.5056357 35.3832611,32.3782594 31.9583333,35.7966667 C31.0587397,36.6879974 30.0508686,37.4629382 28.9583333,38.1033333 C28.3033941,38.4890431 27.4704606,38.3827841 26.9333333,37.845 L23.6166667,34.53 C28.5053053,31.4496338 32.7452344,27.4440926 36.0983333,22.7383333 L36.0983333,22.7383333 Z" opacity="0.598539807"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Ticket Llegada</h6>
                                                <span class="font-weight-bold text-xl" style="color: #01a31c"> Disponible para Descarga</span>
                                                <span class="text-xs">Asegurate de descargar tu boleto antes de abordar, ya esta disponible.</span>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <button class="btn btn-success btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto" data-toggle="modal" data-target="#ver-pase-llegada"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                <svg width="12px" height="12px" viewBox="0 0 40 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="mt-1">
                                                    <title>settings</title>
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <g transform="translate(-2020.000000, -442.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                            <g transform="translate(1716.000000, 291.000000)">
                                                                <g transform="translate(304.000000, 151.000000)">
                                                                    <polygon opacity="0.596981957" points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667"></polygon>
                                                                    <path d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z" opacity="0.596981957"></path>
                                                                    <path d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Ticket Salida</h6>
                                                <?php echo $modal;?>
                                            </div>
                                        </div>
                                        <?php echo $btn_salida;?>
                                    </li>
                                </ul>
                                <div class="row">
                                    <div class="button-row d-flex mt-4 col-12">
                                        <a class="btn bg-gradient-light mb-0 js-btn-prev" href="/Home/" title="Prev">Regresar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-7 mt-lg-0 mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="card widget-calendar">
                                    <div class="card-header p-3 pb-0">
                                        <h6 class="mb-0 text-center">Calendario</h6>
                                        <div hidden class="text-center">
                                            <span class="p text-sm font-weight-bold mb-0">Hoy es &nbsp;</span>
                                            <span class="p text-sm font-weight-bold mb-0 text-dark widget-calendar-num-day"></span>
                                                <span class="p text-sm font-weight-bold mb-0 widget-calendar-num-day">&nbsp; de &nbsp;</span>
                                            <span class="p text-sm font-weight-bold mb-0 text-dark widget-calendar-month"></span>
                                                <span class="p text-sm font-weight-bold mb-0 widget-calendar-num-day">&nbsp; del &nbsp;</span>
                                            <span class="p text-sm font-weight-bold mb-1 text-dark widget-calendar-year"></span>
                                        </div>
                                        <!-- <hr class="horizontal dark mb-0"> -->
                                        <div class="text-center">
                                            <span class="badge badge-info">Rumbo a la convención</span>
                                            <span class="badge badge-success">Regreso a casa</span> <br>
                                        </div>
                                    </div>
                                    <!-- Card body -->
                                    <div class="card-body p-3">
                                        <div data-toggle="widget-calendar"></div>
                                        <div>
                                            <table class="table">
                                                <thead class="thead-light" style="font-size: small;">
                                                    <tr>
                                                        <td>Lunes</td>
                                                        <td>Martes</td>
                                                        <td>Miércoles</td>
                                                        <td>Jueves</td>
                                                        <td>Viernes</td>
                                                        <td>Sábado</td>
                                                        <td>Domingo</td>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>1</td>
                                                        <td>2</td>
                                                        <td>3</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>5</td>
                                                        <td>6</td>
                                                        <td>7</td>
                                                        <td>8</td>
                                                        <td>9</td>
                                                        <td>10</td>
                                                    </tr>
                                                    <tr>
                                                        <td>11</td>
                                                        <td>12</td>
                                                        <td>13</td>
                                                        <td>14</td>
                                                        <td>15</td>
                                                        <td>16</td>
                                                        <td>17</td>
                                                    </tr>
                                                    <tr>
                                                        <td>18</td>
                                                        <td>19</td>
                                                        <td>20</td>
                                                        <td>21</td>
                                                        <td>22</td>
                                                        <td>23</td>
                                                        <td>24</td>
                                                    </tr>
                                                    <tr>
                                                        <td>25</td>
                                                        <td>26</td>
                                                        <td>27</td>
                                                        <td><span class="badge badge-info" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Rumbo a la Convención">28</span></td>
                                                        <td>29</td>
                                                        <td>30</td>
                                                        <td><span class="badge badge-success" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Regreso a casa">1</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- MODAL VISTA - COMPROBANTE -->
<div class="modal fade" id="ver-pase-llegada" tabindex="-1" role="dialog" aria-labelledby="ver-pase-llegada" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 590px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ver-pase-llegada">Pase de Abordar (Llegada) - MUSA 2022</h5>
                <span type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    X
                </span>
            </div>
            <!-- <div class="modal-header">
                <p>Por su seguridad y la de las demás personas, le pedimos que nos proporcione la Información siguiente para comprobar que no este contagiado de COVID.</p>
            </div> -->
            <div class="modal-body">
                <!-- <span><?php echo $pase_llegada['url'];?></span> -->
                <iframe src="https://admin.foromusa.com/comprobante_vuelo_uno/<?php echo $pase_llegada['url'];?>"
                        style="width:100%; height:780px;" frameborder="0" >
                </iframe>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ver-pase-salida" tabindex="-1" role="dialog" aria-labelledby="ver-pase-salida" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 590px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ver-pase-salida">Pase de Abordar (Salida) - MUSA 2022</h5>
                <span type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    X
                </span>
            </div>
            <!-- <div class="modal-header">
                <p>Por su seguridad y la de las demás personas, le pedimos que nos proporcione la Información siguiente para comprobar que no este contagiado de COVID.</p>
            </div> -->
            <div class="modal-body">
                <span><?php echo $pase_salida['url'];?></span>
                <iframe src="https://admin.foromusa.com/comprobante_vuelo_dos/<?php echo $pase_salida['url'];?>"
                        style="width:100%; height:780px;" frameborder="0" >
                </iframe>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function (){
        if (document.querySelector('[data-toggle="widget-calendar"]')) {
            var calendarEl = document.querySelector('[data-toggle="widget-calendar"]');
            var today = new Date();
            var mYear = today.getFullYear();
            var weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            var mDay = weekday[today.getDay()];
            var numDay = today.getDate();

            var m = today.getMonth();
            var d = today.getDate();
            document.getElementsByClassName('widget-calendar-year')[0].innerHTML = mYear;
            document.getElementsByClassName('widget-calendar-day')[0].innerHTML = mDay;
            switch (m+1) {
                case 1:
                    document.getElementsByClassName('widget-calendar-month')[0].innerHTML = 'Enero';
                    break;
                
                case 2:
                    document.getElementsByClassName('widget-calendar-month')[0].innerHTML = 'Febrero';
                    break;

                case 3:
                    document.getElementsByClassName('widget-calendar-month')[0].innerHTML = 'Marzo';
                    break;

                case 4:
                    document.getElementsByClassName('widget-calendar-month')[0].innerHTML = 'Abril';
                    break;
            
                case 5:
                    document.getElementsByClassName('widget-calendar-month')[0].innerHTML = 'Mayo';
                    break;

                case 6:
                    document.getElementsByClassName('widget-calendar-month')[0].innerHTML = 'Junio';
                    break;

                default:
                    break;
            }
            document.getElementsByClassName('widget-calendar-num-day')[0].innerHTML = numDay;

            var calendar = new FullCalendar.Calendar(calendarEl, {
                contentHeight: 'auto',
                initialView: 'dayGridMonth',
                selectable: true,
                initialDate: '2020-12-01',
                editable: true,
                headerToolbar: false,
                events: [{
                    title: 'Call with Dave',
                    start: '2020-11-18',
                    end: '2020-11-18',
                    className: 'bg-gradient-danger'
                },

                {
                    title: 'Lunch meeting',
                    start: '2020-11-21',
                    end: '2020-11-22',
                    className: 'bg-gradient-warning'
                },

                {
                    title: 'All day conference',
                    start: '2020-11-29',
                    end: '2020-11-29',
                    className: 'bg-gradient-success'
                },

                {
                    title: 'Meeting with Mary',
                    start: '2020-12-01',
                    end: '2020-12-01',
                    className: 'bg-gradient-info'
                },

                {
                    title: 'Winter Hackaton',
                    start: '2020-12-03',
                    end: '2020-12-03',
                    className: 'bg-gradient-danger'
                },

                {
                    title: 'Digital event',
                    start: '2020-12-07',
                    end: '2020-12-09',
                    className: 'bg-gradient-warning'
                },

                {
                    title: 'Marketing event',
                    start: '2020-12-10',
                    end: '2020-12-10',
                    className: 'bg-gradient-primary'
                },

                {
                    title: 'Dinner with Family',
                    start: '2020-12-19',
                    end: '2020-12-19',
                    className: 'bg-gradient-danger'
                },

                {
                    title: 'Black Friday',
                    start: '2020-12-23',
                    end: '2020-12-23',
                    className: 'bg-gradient-info'
                },

                {
                    title: 'Cyber Week',
                    start: '2020-12-02',
                    end: '2020-12-02',
                    className: 'bg-gradient-warning'
                },

                ]
            });
            calendar.render();
            }
    })
</script>

<?php echo $footer; ?>



