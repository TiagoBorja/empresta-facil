<?php
$page = 0;
if (isset($_GET["page"]))
    $page = $_GET["page"];

$page_file = "";


$page_config = [
    'home' => ['title' => 'Página Inicial', 'file' => './pag/home.php'],
    'catalog' => ['title' => 'Catálogo', 'file' => './pag/catalog.php'],
    'view-info' => ['title' => 'Informações', 'file' => './pag/view-info.php'],
];

$page_title = isset($page_config[$page]) ? $page_config[$page]['title'] : 'Not Found';
$page_file = isset($page_config[$page]) ? $page_config[$page]['file'] : './pag/not_found.php';
?>

<!DOCTYPE html>
<html dir="ltr" lang="pt-pt">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template" />
    <meta name="description"
        content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework" />
    <meta name="robots" content="noindex,nofollow" />
    <title><?php echo $page_title; ?></title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png" />
    <!-- Custom CSS -->
    <link href="../assets/libs/flot/css/float-chart.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../assets/extra-libs/multicheck/multicheck.css">

    <link rel="stylesheet" href="../dist/css/custom-css/global-config.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body>

    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>


    <header class="topbar">
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php?page=home">

                    <span class="logo-text ms-2 text-danger">
                        EmprestaFácil
                    </span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent"
                    style="background-color: #343A40 !important;">
                    <!-- Links de Navegação - Centralizados e Alinhados Verticalmente -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex align-items-center">
                        <li class="nav-item">
                            <a class="nav-link <?= $page == 'home' ? 'active' : '' ?> h5 mb-0 d-flex align-items-center"
                                href="?page=home">
                                <i class="mdi mdi-home me-2"></i> Página Inicial
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $page == 'catalog' ? 'active' : '' ?> h5 mb-0 d-flex align-items-center"
                                aria-current="page" href="?page=catalog">
                                <i class="mdi mdi-library me-2"></i> Catálogo
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav float-end">

                        <li class="nav-item dropdown">
                            <a class="
                        nav-link
                        dropdown-toggle
                        text-muted
                        waves-effect waves-dark
                        pro-pic" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="../assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31" />
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end user-dd animated"
                                aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="javascript:void(0)"><i
                                        class="mdi mdi-account me-1 ms-1"></i>
                                    My
                                    Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)"><i
                                        class="mdi mdi-settings me-1 ms-1"></i> Account
                                    Setting</a>
                                <div class="dropdown-divider"></div>
                                <a id="logout" class="dropdown-item" href="javascript:void(0)"><i
                                        class="fa fa-power-off me-1 ms-1"></i>
                                    Logout</a>
                                <div class="dropdown-divider"></div>
                                <div class="ps-4 p-10">
                                    <a href="javascript:void(0)"
                                        class="btn btn-sm btn-success btn-rounded text-white">View
                                        Profile</a>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- <aside class="left-sidebar" data-sidebarbg="skin5">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="pt-4">
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="index.php"
                                aria-expanded="false">
                                <i class="mdi mdi-home"></i><span class="hide-menu">Página Inicial</span></a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="?page=1"
                                aria-expanded="false">
                                <i class="mdi mdi-library"></i><span class="hide-menu">Catálogo</span></a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="#" aria-expanded="false">
                                <i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="#" aria-expanded="false">
                                <i class="mdi mdi-book"></i><span class="hide-menu">Livros</span></a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="mdi mdi-settings"></i>
                                <span class="hide-menu">Configurações</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">

                                <li class="sidebar-item">
                                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                        aria-expanded="false">
                                        <i class="mdi mdi-account-multiple"></i>
                                        <span class="hide-menu">Utilizadores</span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse second-level">
                                        <li class="sidebar-item">
                                            <a href="?page=3" class="sidebar-link">
                                                <i class="mdi mdi-account-tie"></i>
                                                <span class="hide-menu">Tipos de Utilizadores</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="/gestao-alunos" class="sidebar-link">
                                                <i class="mdi mdi-account-school"></i>
                                                <span class="hide-menu">Gestão de Alunos</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="sidebar-item">
                                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                        aria-expanded="false">
                                        <i class="mdi mdi-book"></i>
                                        <span class="hide-menu">Livros</span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse second-level">
                                        <li class="sidebar-item">
                                            <a href="/categorias-generos" class="sidebar-link">
                                                <i class="mdi mdi-bookmark-multiple"></i>
                                                <span class="hide-menu">Categorias de Géneros</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="/categorias-materiais" class="sidebar-link">
                                                <i class="mdi mdi-library-books"></i>
                                                <span class="hide-menu">Categorias de Materiais</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="/condicao-materiais" class="sidebar-link">
                                                <i class="mdi mdi-information"></i>
                                                <span class="hide-menu">Condição dos Materiais</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="sidebar-item">
                                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                        aria-expanded="false">
                                        <i class="mdi mdi-tune"></i>
                                        <span class="hide-menu">Gerais</span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse second-level">
                                        <li class="sidebar-item">
                                            <a href="/funcoes-permissoes" class="sidebar-link">
                                                <i class="mdi mdi-account-settings"></i>
                                                <span class="hide-menu">Funções e Permissões</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside> -->

    <div class="">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex align-items-center">
                    <h4 class="page-title ms-1"><?php echo $page_title; ?></h4>
                </div>
            </div>
        </div>


        <div class="container-fluid">

            <?php
            switch ($page) {

                case 'home':
                    $page_file = "./pag/home.php";
                    break;

                case 'catalog':
                    $page_file = "./pag/catalog.php";
                    break;
                case 'view-info':
                    $page_file = "./pag/view-info.php";
                    break;
                case 3:
                    $page_file = "./config/user-type/user-type.php";
                    break;

                case 900:
                    $page_file = "./login.php";
                    break;

                default:
                    $page_file = "./pag/not_found.php";
                    break;
            }

            if (!file_exists($page_file))
                include("../html/error-404.html");

            include($page_file);
            ?>

        </div>
    </div>
    <footer class="footer text-center">
        All Rights Reserved by Matrix-admin. Designed and Developed by
        <a href="https://www.wrappixel.com">WrapPixel</a>.
    </footer>


    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="../dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <!-- <script src="../dist/js/pages/dashboards/dashboard1.js"></script> -->
    <!-- Charts js Files -->
    <script src="../assets/libs/flot/excanvas.js"></script>
    <script src="../assets/libs/flot/jquery.flot.js"></script>
    <script src="../assets/libs/flot/jquery.flot.pie.js"></script>
    <script src="../assets/libs/flot/jquery.flot.time.js"></script>
    <script src="../assets/libs/flot/jquery.flot.stack.js"></script>
    <script src="../assets/libs/flot/jquery.flot.crosshair.js"></script>
    <script src="../assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="../dist/js/pages/chart/chart-page-init.js"></script>
</body>

</html>