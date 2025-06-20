<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'Administrador') {
    header("Location: ../php/index.php?page=home");
    exit;
}
$page = 'dashboard';
if (isset($_GET["page"]))
    $page = $_GET["page"];

$page_file = "";


$page_config = [
    'home' => ['title' => 'Página Inicial', 'file' => './pages/home.php'],
    'catalog' => ['title' => 'Catálogo', 'file' => './pages/catalog.php'],
    'view-info' => ['title' => 'Informações', 'file' => './pages/view-info.php'],
    'auth' => ['title' => 'Login', 'file' => './pages/login-form.php'],

    'dashboard' => ['title' => 'Painel Administrativo', 'file' => './pages/dashboard.php'],
    'users' => ['title' => 'Utilizadores', 'file' => './pages/users-page.php'],
    'user-roles' => ['title' => 'Tipos de Utilizadores', 'file' => './pages/user-roles-page.php'],

    'state' => ['title' => 'Gestão de Estados', 'file' => './pages/state-page.php'],
    'state-form' => ['title' => 'Gestão de Estados', 'file' => './forms/state-form.php'],

    'categories' => ['title' => 'Gestão de Categorias', 'file' => './pages/category.php'],
    'category-form' => ['title' => 'Gestão de Categorias', 'file' => './forms/category-form.php'],

    'user-form' => ['title' => 'Utilizadores', 'file' => './forms/user-form.php'],
    'role-form' => ['title' => 'Tipos de Utilizadores', 'file' => './forms/role-form.php'],
];

$page_title = isset($page_config[$page]) ? $page_config[$page]['title'] : 'Not Found';
$page_file = isset($page_config[$page]) ? $page_config[$page]['file'] : './pages/not_found.php';
?>

<?= include '../includes/header.php'; ?>

<body cz-shortcut-listen="true">
    <div class="preloader" style="display: none;">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="mini-sidebar"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">

        <header class="">
            <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">

                <div class="container-fluid">
                    <div class="navbar-header" data-logobg="skin5">
                        <a class="navbar-brand" href="index.html">
                            <!-- Logo icon -->
                            <b class="logo-icon ms-2">
                                <img src="../public/assets/images/logo-icon.png" alt="homepage" class="light-logo"
                                    width="26">
                            </b>
                            <span class="logo-text ms-2">
                                <span class="text-danger">EmprestaFacil</span>
                            </span>
                        </a>


                        <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                                class="ti-menu ti-close"></i></a>

                    </div>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent"
                        style="background-color: #343A40 !important;">
                        <!-- Links de Navegação - Centralizados e Alinhados Verticalmente -->
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex align-items-center">
                            <li class="nav-item d-none d-lg-block">
                                <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                    data-sidebartype="mini-sidebar">
                                    <i class="mdi mdi-menu font-24"></i>
                                </a>
                            </li>
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
                            <li class="nav-item">
                                <a class="nav-link <?= $page == 'waiting' ? 'active' : '' ?> h5 mb-0 d-flex align-items-center"
                                    aria-current="page" href="#">
                                    <i class="mdi mdi-trophy-award me-2"></i> Mais Requisitados
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= $page == 'waiting' ? 'active' : '' ?> h5 mb-0 d-flex align-items-center"
                                    aria-current="page" href="#">
                                    <i class="mdi mdi-newspaper me-2"></i> Novidades
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= $page == 'waiting' ? 'active' : '' ?> h5 mb-0 d-flex align-items-center"
                                    aria-current="page" href="#">
                                    <i class="mdi mdi-book-open-page-variant me-2"></i> Recomendações
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav float-end mb-2 mb-lg-0 d-flex align-items-center">

                            <li class="nav-item dropdown">
                                <a class="
                        nav-link
                        dropdown-toggle
                        text-muted
                        waves-effect waves-dark
                        pro-pic" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="./users/<?= $_SESSION['user']['img_url'] ?>" alt="user"
                                        class="rounded-circle" width="31" />
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end user-dd animated"
                                    aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                            class="mdi mdi-account me-1 ms-1 text-info"></i>
                                        Meu Perfil</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                            class="fas fa-heart me-1 ms-1 text-danger"></i>
                                        Favoritos</a>

                                    <?= (isset($_SESSION['user']['tipo']) && $_SESSION['user']['tipo'] === 'Administrador')
                                        ? '<div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="../administrative/index.php">
                                        <i class="mdi mdi-settings me-1 ms-1 text-secondary"></i> Definições
                                        </a>'
                                        : ''
                                    ?>

                                    <div class="dropdown-divider"></div>

                                    <?= isset(($_SESSION['user']))
                                        ? '<a id="logout" class="dropdown-item" href="./config/auth/logout.php">
                                        <i class="fa fa-power-off text-danger me-1 ms-1"></i>
                                        Sair
                                    </a>'
                                        : '<a id="login" class="dropdown-item" href="?page=auth">
                                        <i class="mdi mdi-login text-info me-1 ms-1"></i>
                                        Entrar
                                    </a>'
                                    ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <aside class="left-sidebar" style="background-color: #343A40 !important;">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="">
                        <!-- Catálogo -->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="?page=1">
                                <i class="mdi mdi-library"></i><span class="hide-menu">Catálogo</span>
                            </a>
                        </li>

                        <!-- Dashboard -->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="?page=dashboard">
                                <i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <!-- Gestão de Recursos -->
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                                <i class="mdi mdi-book"></i><span class="hide-menu">Gestão de Recursos</span>
                            </a>
                            <ul aria-expanded="false" class="collapse ms-2">
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="?page=recursos">
                                        <i class="mdi mdi-library-books"></i><span class="hide-menu">Recursos</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="?page=categories">
                                        <i class="mdi mdi-bookmark-multiple"></i><span
                                            class="hide-menu">Categorias</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="?page=subcategorias">
                                        <i class="mdi mdi-bookmark-outline"></i><span
                                            class="hide-menu">Subcategorias</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="?page=localizacoes">
                                        <i class="mdi mdi-map-marker"></i><span class="hide-menu">Localizações</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="?page=editoras">
                                        <i class="mdi mdi-library-shelves"></i><span class="hide-menu">Editoras</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="?page=tipos-recurso">
                                        <i class="mdi mdi-tag-multiple"></i><span class="hide-menu">Tipos de
                                            Recursos</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Gestão de Utilizadores -->
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                                <i class="mdi mdi-account-multiple"></i><span class="hide-menu">Gestão de
                                    Utilizadores</span>
                            </a>
                            <ul aria-expanded="false" class="collapse ms-2">
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="?page=utilizadores">
                                        <i class="mdi mdi-account"></i><span class="hide-menu">Utilizadores</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="?page=funcionarios">
                                        <i class="mdi mdi-account-tie"></i><span class="hide-menu">Funcionários</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="?page=tipos-utilizador">
                                        <i class="mdi mdi-account-group"></i><span class="hide-menu">Tipos de
                                            Utilizador</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Empréstimos e Reservas -->
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                                <i class="mdi mdi-book"></i><span class="hide-menu">Empréstimos</span>
                            </a>
                            <ul aria-expanded="false" class="collapse ms-2">
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="?page=emprestimos">
                                        <i class="mdi mdi-bookmark-multiple"></i><span class="hide-menu">Empréstimos em
                                            Processo</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="?page=reservas">
                                        <i class="mdi mdi-bookmark-multiple"></i><span class="hide-menu">Reservas</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Configurações -->
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                                <i class="mdi mdi-settings"></i><span class="hide-menu">Configurações</span>
                            </a>
                            <ul aria-expanded="false" class="collapse ms-2">
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="?page=state">
                                        <i class="mdi mdi-tune"></i><span class="hide-menu">Gestão de Estados</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <div class="page-wrapper" style="background-color: #fff5d7 !important;">

            <br>
            <br>

            <div class="container-fluid">

                <?php
                switch ($page) {

                    case 'authors':
                        $page_file = "./author/author-page.php";
                        break;

                    case 'author-form':
                        $page_file = "./forms/author-form.php";
                        break;

                    case 'books':
                        $page_file = "./book/book-page.php";
                        break;

                    case 'book-form':
                        $page_file = "./forms/book-form.php";
                        break;

                    case 'book-reservations':
                        $page_file = "./pages/book-reservation-page.php";
                        break;

                    case 'categories':
                        $page_file = "./category/category-page.php";
                        break;

                    case 'category-form':
                        $page_file = "./forms/category-form.php";
                        break;

                    case 'dashboard':
                        $page_file = "./pages/dashboard.php";
                        break;

                    case 'employees':
                        $page_file = "./pages/employee-page.php";
                        break;

                    case 'employee-form':
                        $page_file = "./forms/employee-form.php";
                        break;

                    case 'libraries':
                        $page_file = "./library/library-page.php";
                        break;

                    case 'library-form':
                        $page_file = "./forms/library-form.php";
                        break;

                    case 'loans':
                        $page_file = "./pages/loan-page.php";
                        break;

                    case 'loan-form':
                        $page_file = "./forms/loan-form.php";
                        break;

                    case 'locations':
                        $page_file = "./location/location-page.php";
                        break;

                    case 'location-form':
                        $page_file = "./forms/location-form.php";
                        break;

                    case 'publishers':
                        $page_file = "./publisher/publisher-page.php";
                        break;

                    case 'publisher-form':
                        $page_file = "./forms/publisher-form.php";
                        break;

                    case 'state':
                        $page_file = "./state/state-page.php";
                        break;

                    case 'state-form':
                        $page_file = "./forms/state-form.php";
                        break;

                    case 'subcategories':
                        $page_file = "./subcategory/subcategory-page.php";
                        break;

                    case 'subcategory-form':
                        $page_file = "./forms/subcategory-form.php";
                        break;

                    case 'type-resources':
                        $page_file = "./type-resource/type-resource-page.php";
                        break;

                    case 'type-resource-form':
                        $page_file = "./forms/type-resource-form.php";
                        break;

                    case 'user-roles':
                        $page_file = "./user-roles/user-roles-page.php";
                        break;

                    case 'role-form':
                        $page_file = "./forms/role-form.php";
                        break;

                    case 'users':
                        $page_file = "./users/users-page.php";
                        break;

                    case 'user-form':
                        $page_file = "./forms/user-form.php";
                        break;

                    default:
                        $page_file = "../public/pages/not_found.php";
                        break;
                }


                if (!file_exists($page_file))
                    include("../public/html/error-404.html");

                include($page_file);
                ?>

            </div>
        </div>
        <?= include '../includes/footer.php'; ?>
</body>

</html>