<div class="row justify-content-center">
    <h2 id="userName" class="text-center"></h2>
    <h4 id="userLibrary" class="text-center"></h4>
    <input id="employeeId" type="hidden" value="<?php echo $_SESSION['employee']['id'] ?>">
    <h3 class="text-center mt-4 mb-4">Estatísticas</h3>
    <div class="row">
        <!-- Total de Livros -->
        <div class="col-md-6 col-lg-3">
            <a href="?page=livros">
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
        <div class="col-md-6 col-lg-3">
            <a href="?page=emprestimos">
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
        <div class="col-md-6 col-lg-3">
            <a href="?page=autores">
                <div class="card card-hover">
                    <div class="box bg-orange text-center">
                        <i class="mdi mdi-account display-4 text-white"></i>
                        <h6 class="text-white mt-2">Utilizadores Pendentes</h6>
                        <h4 class="text-white">5</h4>
                    </div>
                </div>
            </a>
        </div>
        <!-- Editoras -->
        <div class="col-md-6 col-lg-3">
            <a href="?page=editoras">
                <div class="card card-hover">
                    <div class="box bg-primary text-center">
                        <i class="mdi mdi-pencil display-4 text-white"></i>
                        <h6 class="text-white mt-2">Sugestões</h6>
                        <h4 class="text-white">12</h4>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Secção Alertas -->
    <h3 class="text-center mt-5 mb-4">Alertas</h3>
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <a href="?page=relatorios">
                <div class="card card-hover">
                    <div class="box bg-danger text-center">
                        <i class="mdi mdi-timer-off display-4 text-white"></i>
                        <h6 class="text-white mt-2">Prazos Expirados</h6>
                        <h4 class="text-white">3</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="?page=relatorios">
                <div class="card card-hover">
                    <div class="box bg-warning text-center">
                        <i class="mdi mdi-book display-4 text-white"></i>
                        <h6 class="text-white mt-2">Livros Danificados</h6>
                        <h4 class="text-white">7</h4>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Secção Atalhos -->
    <h3 class="text-center mt-5 mb-4">Atalhos</h3>
    <div class="row">
        <!-- Livros -->
        <div class="col-md-6 col-lg-2">
            <a href="?page=livros">
                <div class="card card-hover small-box bg-info text-center">
                    <i class="mdi mdi-book-multiple display-6 text-white"></i>
                    <p class="text-white mt-2">Recursos</p>
                </div>
            </a>
        </div>
        <!-- Empréstimos -->
        <div class="col-md-6 col-lg-2">
            <a href="?page=emprestimos">
                <div class="card card-hover small-box bg-success text-center">
                    <i class="mdi mdi-swap-horizontal display-6 text-white"></i>
                    <p class="text-white mt-2">Empréstimos</p>
                </div>
            </a>
        </div>
        <!-- Autores -->
        <div class="col-md-6 col-lg-2">
            <a href="?page=autores">
                <div class="card card-hover small-box bg-orange text-center">
                    <i class="mdi mdi-account display-6 text-white"></i>
                    <p class="text-white mt-2">Autores</p>
                </div>
            </a>
        </div>
        <!-- Editoras -->
        <div class="col-md-6 col-lg-2">
            <a href="?page=editoras">
                <div class="card card-hover small-box bg-primary text-center">
                    <i class="mdi mdi-pencil display-6 text-white"></i>
                    <p class="text-white mt-2">Editoras</p>
                </div>
            </a>
        </div>
        <!-- Utilizadores -->
        <div class="col-md-6 col-lg-2">
            <a href="?page=users">
                <div class="card card-hover small-box bg-warning text-center">
                    <i class="mdi mdi-account-box display-6 text-white"></i>
                    <p class="text-white mt-2">Utilizadores</p>
                </div>
            </a>
        </div>
        <!-- Funcionários -->
        <div class="col-md-6 col-lg-2">
            <a href="?page=funcionarios">
                <div class="card card-hover small-box bg-dark text-center">
                    <i class="mdi mdi-account-multiple display-6 text-white"></i>
                    <p class="text-white mt-2">Funcionários</p>
                </div>
            </a>
        </div>
    </div>
</div>

<script type="module" src="../js/pages/dashboard.js"></script>