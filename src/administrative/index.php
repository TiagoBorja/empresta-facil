<?php
session_start();

require_once __DIR__ . '/../php/classes/Utils.php';
if (!Utils::isEmployeeOrHigher($_SESSION['user'] ?? [])) {
    header("Location: ../php/index.php?page=home");
    exit;
}


$imgFilename = $_SESSION['user']['img_url'] ?? '';

$serverPath = __DIR__ . '/users/upload/' . $imgFilename;

$urlPath = $imgFilename
    ? 'users/upload/' . $imgFilename
    : 'src/public/assets/images/users/male-icon.jpg';

if (!file_exists($serverPath)) {
    $urlPath = 'src/public/assets/images/users/male-icon.jpg';
}


$page = 'dashboard';
if (isset($_GET["page"]))
    $page = $_GET["page"];

$page_file = "";


$page_config = [
    'dashboard' => ['title' => 'Painel Administrativo', 'file' => './pages/dashboard.php'],
    'users' => ['title' => 'Utilizadores', 'file' => './pages/users-page.php'],
    'user-roles' => ['title' => 'Tipos de Utilizadores', 'file' => './pages/user-roles-page.php'],

    'state' => ['title' => 'Gestão de Estados', 'file' => './pages/state-page.php'],
    'state-form' => ['title' => 'Gestão de Estados', 'file' => './forms/state-form.php'],

    'categories' => ['title' => 'Gestão de Categorias', 'file' => './pages/category-page.php'],
    'category-form' => ['title' => 'Gestão de Categorias', 'file' => './forms/category-form.php'],

    'authors' => ['title' => 'Autores', 'file' => './author/author-page.php'],
    'author-form' => ['title' => 'Formulário de Autor', 'file' => './forms/author-form.php'],

    'books' => ['title' => 'Livros', 'file' => './book/book-page.php'],
    'book-form' => ['title' => 'Formulário de Livro', 'file' => './forms/book-form.php'],

    'book-reservations' => ['title' => 'Reservas de Livros', 'file' => './pages/book-reservation-page.php'],

    'book-location-form' => ['title' => 'Formulário de Localização de Livro', 'file' => './forms/book-location-form.php'],
    'book-locations' => ['title' => 'Localizações de Livros', 'file' => './pages/book-location-page.php'],

    'employees' => ['title' => 'Funcionários', 'file' => './pages/employee-page.php'],
    'employee-form' => ['title' => 'Formulário de Funcionário', 'file' => './forms/employee-form.php'],

    'libraries' => ['title' => 'Bibliotecas', 'file' => './library/library-page.php'],
    'library-form' => ['title' => 'Formulário de Biblioteca', 'file' => './forms/library-form.php'],

    'loans' => ['title' => 'Empréstimos', 'file' => './pages/loan-page.php'],
    'loan-form' => ['title' => 'Formulário de Empréstimo', 'file' => './forms/loan-form.php'],

    'locations' => ['title' => 'Localizações', 'file' => './location/location-page.php'],
    'location-form' => ['title' => 'Formulário de Localização', 'file' => './forms/location-form.php'],

    'publishers' => ['title' => 'Editoras', 'file' => './publisher/publisher-page.php'],
    'publisher-form' => ['title' => 'Formulário de Editora', 'file' => './forms/publisher-form.php'],

    'subcategories' => ['title' => 'Subcategorias', 'file' => './subcategory/subcategory-page.php'],
    'subcategory-form' => ['title' => 'Formulário de Subcategoria', 'file' => './forms/subcategory-form.php'],

    'role-form' => ['title' => 'Formulário de Função', 'file' => './forms/role-form.php'],
    'user-form' => ['title' => 'Formulário de Utilizador', 'file' => './forms/user-form.php'],
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
                                <span class="text-danger">EmprestaFácil</span>
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
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex align-items-center">
                            <li class="nav-item d-none d-lg-block">
                                <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                    data-sidebartype="mini-sidebar">
                                    <i class="mdi mdi-menu font-24"></i>
                                </a>
                            </li>

                            <!-- Dashboard -->
                            <li class="nav-item">
                                <a class="nav-link <?= $page == 'dashboard' ? 'active' : '' ?> h5 mb-0 d-flex align-items-center"
                                    href="?page=dashboard">
                                    <i class="mdi mdi-home-analytics me-2"></i> Dashboard
                                </a>
                            </li>

                            <?php if (Utils::isManagerOrHigher($_SESSION['user'] ?? [])): ?>
                                <li class="nav-item">
                                    <a class="nav-link <?= $page == 'books' ? 'active' : '' ?> h5 mb-0 d-flex align-items-center"
                                        href="?page=books">
                                        <i class="mdi mdi-library-shelves me-2"></i> Gestão de Livros
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Gestão de Utilizadores -->
                            <li class="nav-item">
                                <a class="nav-link <?= $page == 'users' ? 'active' : '' ?> h5 mb-0 d-flex align-items-center"
                                    href="?page=users">
                                    <i class="mdi mdi-account-group-outline me-2"></i> Gestão de Utilizadores
                                </a>
                            </li>

                            <!-- Empréstimos -->
                            <li class="nav-item">
                                <a class="nav-link <?= $page == 'loans' ? 'active' : '' ?> h5 mb-0 d-flex align-items-center"
                                    href="?page=loans">
                                    <i class="mdi mdi-book-clock-outline me-2"></i> Empréstimos
                                </a>
                            </li>

                            <!-- Relatórios -->
                            <li class="nav-item">
                                <a class="nav-link <?= $page == 'book-reservations' ? 'active' : '' ?> h5 mb-0 d-flex align-items-center"
                                    href="?page=book-reservations">
                                    <i class="mdi mdi-chart-box-outline me-2"></i> Reservas
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
                                    <img src="<?= $urlPath ?>" alt="user" class="rounded-circle" width="31" />
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end user-dd animated"
                                    aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="javascript:void(0)"><i
                                            class="mdi mdi-account me-1 ms-1 text-info"></i>
                                        Meu Perfil</a>

                                    <div class="dropdown-divider"></div>

                                    <?php if (Utils::isEmployeeOrHigher($_SESSION['user'] ?? [])): ?>
                                        <a class="dropdown-item" href="../php/index.php">
                                            <i class="mdi mdi-home-outline me-1 ms-1 text-secondary"></i> Página Inicial
                                        </a>
                                    <?php endif; ?>


                                    <div class="dropdown-divider"></div>

                                    <?= isset(($_SESSION['user']))
                                        ? '<a id="logout" class="dropdown-item" href="../php/config/auth/logout.php">
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

                        <!-- Dashboard -->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="?page=dashboard">
                                <i class="mdi mdi-home-analytics"></i><span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <!-- Gestão de Recursos -->
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                                <i class="mdi mdi-book"></i><span class="hide-menu">Gestão de Livros</span>
                            </a>
                            <ul aria-expanded="false" class="collapse ms-2">
                                <?php if (Utils::isManagerOrHigher($_SESSION['user'] ?? [])): ?>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="?page=books">
                                            <i class="mdi mdi-library-books"></i><span class="hide-menu">Livros</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if (Utils::isManagerOrHigher($_SESSION['user'] ?? [])): ?>

                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="?page=categories">
                                            <i class="mdi mdi-bookmark-multiple"></i><span
                                                class="hide-menu">Categorias</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if (Utils::isManagerOrHigher($_SESSION['user'] ?? [])): ?>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="?page=subcategories">
                                            <i class="mdi mdi-bookmark-outline"></i><span
                                                class="hide-menu">Subcategorias</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if (Utils::isManagerOrHigher($_SESSION['user'] ?? [])): ?>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="?page=locations">
                                            <i class="mdi mdi-map-marker"></i><span class="hide-menu">Localizações</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if (Utils::isEmployeeOrHigher($_SESSION['user'] ?? [])): ?>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="?page=book-locations">
                                            <i class="mdi mdi-map-marker"></i><span class="hide-menu">Localizações dos
                                                Livros</span>
                                        </a>
                                    </li>
                                <?php endif; ?>


                                <?php if (Utils::isAdmin($_SESSION['user'] ?? [])): ?>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="?page=publishers">
                                            <i class="mdi mdi-library-shelves"></i><span class="hide-menu">Editoras</span>
                                        </a>
                                    </li>>
                                <?php endif; ?>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                                <i class="mdi mdi-account-multiple"></i><span class="hide-menu">Gestão de
                                    Utilizadores</span>
                            </a>
                            <ul aria-expanded="false" class="collapse ms-2">
                                <?php if (Utils::isEmployeeOrHigher($_SESSION['user'] ?? [])): ?>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="?page=users">
                                            <i class="mdi mdi-account"></i><span class="hide-menu">Utilizadores</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if (Utils::isManagerOrHigher($_SESSION['user'] ?? [])): ?>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="?page=employees">
                                            <i class="mdi mdi-account-tie"></i><span class="hide-menu">Funcionários</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if (Utils::isAdmin($_SESSION['user'] ?? [])): ?>
                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="?page=user-roles">
                                            <i class="mdi mdi-account-group"></i><span class="hide-menu">Tipos de
                                                Utilizador</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </li>

                        <!-- Empréstimos e Reservas -->
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                                <i class="mdi mdi-book"></i><span class="hide-menu">Empréstimos</span>
                            </a>
                            <ul aria-expanded="false" class="collapse ms-2">
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="?page=loans">
                                        <i class="mdi mdi-bookmark-multiple"></i><span class="hide-menu">Empréstimos em
                                            Processo</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="?page=book-reservations">
                                        <i class="mdi mdi-bookmark-multiple"></i><span class="hide-menu">Reservas</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Gestão Avançada -->
                        <?php if (Utils::isAdmin($_SESSION['user'] ?? [])): ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                                    <i class="mdi mdi-tools"></i><span class="hide-menu">Gestão Avançada</span>
                                </a>
                                <ul aria-expanded="false" class="collapse ms-2">

                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="?page=state">
                                            <i class="mdi mdi-tune"></i><span class="hide-menu">Gestão de Estados</span>
                                        </a>
                                    </li>

                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="?page=authors">
                                            <i class="mdi mdi-account-edit"></i><span class="hide-menu">Autores</span>
                                        </a>
                                    </li>

                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="?page=libraries">
                                            <i class="mdi mdi-library"></i><span class="hide-menu">Bibliotecas</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        <?php endif; ?>
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

                    case 'book-location-form':
                        $page_file = "./forms/book-location-form.php";
                        break;

                    case 'book-locations':
                        $page_file = "./pages/book-location-page.php";
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