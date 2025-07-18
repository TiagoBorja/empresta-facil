<div class="row justify-content-center">
    <h2 id="userName" class="text-center"></h2>
    <h4 id="userLibrary" class="text-center"></h4>
    <input id="employeeId" type="hidden" value="<?php echo $_SESSION['employee']['id'] ?>">
    <h3 class="text-center mt-4 mb-4">Estatísticas</h3>
    <div class="row">
        <!-- Total de Livros -->
        <div class="col-md-6 col-lg-4">
            <a href="?page=books">
                <div class="card card-hover">
                    <div class="box bg-info text-center">
                        <i class="mdi mdi-book-multiple display-4 text-white"></i>
                        <h6 class="text-white mt-2">Total de Livros</h6>
                        <h4 id="bookCount" class="text-white"></h4>
                    </div>
                </div>
            </a>
        </div>
        <!-- Empréstimos Ativos -->
        <div class="col-md-6 col-lg-4">
            <a href="?page=loans">
                <div class="card card-hover">
                    <div class="box bg-success text-center">
                        <i class="mdi mdi-swap-horizontal display-4 text-white"></i>
                        <h6 class="text-white mt-2">Empréstimos Ativos</h6>
                        <h4 id="activeLoansCount" class="text-white"></h4>
                    </div>
                </div>
            </a>
        </div>
        <!-- Novos Autores -->
        <div class="col-md-6 col-lg-4">
            <a href="?page=users">
                <div class="card card-hover">
                    <div class="box bg-orange text-center">
                        <i class="mdi mdi-account display-4 text-white"></i>
                        <h6 class="text-white mt-2">Utilizadores Pendentes</h6>
                        <h4 id="pendentUsersCount" class="text-white"></h4>
                    </div>
                </div>
            </a>
        </div>

    <!-- Secção Atalhos -->
    <h3 class="text-center mt-5 mb-4">Atalhos</h3>
        <?php if (Utils::isEmployeeOrHigher($_SESSION['user'] ?? [])): ?>
            <div class="col-md-6 col-lg-2">
                <a href="?page=book-locations">
                    <div class="card card-hover small-box bg-info text-center">
                        <i class="mdi mdi-map-marker display-6 text-white"></i>
                        <p class="text-white mt-2">Localização de Livros</p>
                    </div>
                </a>
            </div>
        <?php endif; ?>
        <?php if (Utils::isEmployeeOrHigher($_SESSION['user'] ?? [])): ?>
            <div class="col-md-6 col-lg-2">
                <a href="?page=loans">
                    <div class="card card-hover small-box bg-success text-center">
                        <i class="mdi mdi-swap-horizontal display-6 text-white"></i>
                        <p class="text-white mt-2">Empréstimos</p>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <!-- Autores: só para Admin -->
        <?php if (Utils::isManagerOrHigher($_SESSION['user'] ?? [])): ?>
            <div class="col-md-6 col-lg-2">
                <a href="?page=authors">
                    <div class="card card-hover small-box bg-orange text-center">
                        <i class="mdi mdi-account display-6 text-white"></i>
                        <p class="text-white mt-2">Autores</p>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <!-- Editoras: só para Admin -->
        <?php if (Utils::isAdmin($_SESSION['user'] ?? [])): ?>
            <div class="col-md-6 col-lg-2">
                <a href="?page=publishers">
                    <div class="card card-hover small-box bg-primary text-center">
                        <i class="mdi mdi-pencil display-6 text-white"></i>
                        <p class="text-white mt-2">Editoras</p>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <?php if (Utils::isEmployeeOrHigher($_SESSION['user'] ?? [])): ?>
            <div class="col-md-6 col-lg-2">
                <a href="?page=users">
                    <div class="card card-hover small-box bg-warning text-center">
                        <i class="mdi mdi-account-box display-6 text-white"></i>
                        <p class="text-white mt-2">Utilizadores</p>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <!-- Funcionários: só para Manager ou superior -->
        <?php if (Utils::isManagerOrHigher($_SESSION['user'] ?? [])): ?>
            <div class="col-md-6 col-lg-2">
                <a href="?page=employees">
                    <div class="card card-hover small-box bg-dark text-center">
                        <i class="mdi mdi-account-multiple display-6 text-white"></i>
                        <p class="text-white mt-2">Funcionários</p>
                    </div>
                </a>
            </div>
        <?php endif; ?>
    </div>

</div>

<script type="module" src="../js/pages/dashboard.js"></script>