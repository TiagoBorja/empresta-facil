<?php
session_start();
require_once __DIR__ . '/classes/Utils.php';

$imgFilename = $_SESSION['user']['img_url'] ?? '';

$serverPath = __DIR__ . '/../administrative/users/upload/' . $imgFilename;

$urlPath = $imgFilename
    ? '../administrative/users/upload/' . $imgFilename
    : '../public/assets/images/users/male-icon.jpg';

if (!file_exists($serverPath)) {
    $urlPath = '../public/assets/images/users/male-icon.jpg';
}


$page = 'home';
if (isset($_GET["page"]))
    $page = $_GET["page"];

$page_file = "";


$page_config = [
    'home' => ['title' => 'Página Inicial', 'file' => './pages/home.php'],
    'catalog' => ['title' => 'Catálogo', 'file' => './pages/catalog.php'],
    'book-info' => ['title' => 'Informações', 'file' => './pages/book-info.php'],
    'auth' => ['title' => 'Login', 'file' => './pages/login-form.php'],
    'administrative' => ['title' => 'Painel Administrativo', 'file' => './administrative/index.php'],
];

$page_title = isset($page_config[$page]) ? $page_config[$page]['title'] : 'Not Found';
$page_file = isset($page_config[$page]) ? $page_config[$page]['file'] : './pages/not_found.php';

?>

<?= include '../includes/header.php'; ?>

<body>

    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>


    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?page=home">

                <span class="logo-text ms-2 text-danger">
                    EmprestaFácil
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
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
                        <a class="nav-link <?= $page == 'catalog' && empty($_GET['mostRequested']) ? 'active' : '' ?> h5 mb-0 d-flex align-items-center"
                            aria-current="page" href="?page=catalog">
                            <i class="mdi mdi-library me-2"></i> Catálogo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $page == 'catalog' && isset($_GET['mostRequested']) && $_GET['mostRequested'] == 'true' ? 'active' : '' ?> h5 mb-0 d-flex align-items-center"
                            aria-current="page" href="?page=catalog&mostRequested=true">
                            <i class="mdi mdi-trophy-award me-2"></i> Mais Requisitados
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
                            <img src="<?= $urlPath ?>" alt="user" class="rounded-circle" width="31" />
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="?page=profile"><i
                                    class="mdi mdi-account me-1 ms-1 text-info"></i>
                                Meu Perfil</a>

                            <?= (Utils::isEmployeeOrHigher($_SESSION['user'] ?? []))
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



    <div class="container-fluid mt-5">

        <?php
        switch ($page) {

            case 'home':
                $page_file = "../public/pages/home.php";
                break;

            case 'catalog':
                $page_file = "../public/pages/catalog.php";
                break;
            case 'book-info':
                $page_file = "../public/pages/book-info.php";
                break;
            case 'auth':
                $page_file = "../public/pages/login-form.php";
                break;
            case 'register':
                $page_file = "../public/pages/register-form.php";
                break;
            case 'logout':
                $page_file = "../public/config/auth/logout.php";
                break;
            case 'administrative':
                $page_file = "../public/administrative/index.php";
                break;

            case 'profile':
                $page_file = "../public/pages/profile.php";
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

    <?= include '../includes/footer.php'; ?>



</body>
<!-- <script>

    const heartIcon = document.querySelector('.fa-heart');

    heartIcon.addEventListener('mouseover', () => {
        heartIcon.classList.remove('far');
        heartIcon.classList.add('fas');
    });

    heartIcon.addEventListener('mouseout', () => {
        heartIcon.classList.remove('fas');
        heartIcon.classList.add('far');
    });

</script> -->

</html>