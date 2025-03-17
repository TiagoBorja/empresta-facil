<style>
    .el-card-avatar img {
        transition: none !important;
        transform: none !important;
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-12 p-4">
        <div class="card shadow-lg">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Pesquisar Catálogo</h4>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Geral
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                            <li><a class="dropdown-item" href="#">Categoria</a></li>
                            <li><a class="dropdown-item" href="#">Autor</a></li>
                            <li><a class="dropdown-item" href="#">Assunto</a></li>
                        </ul>
                    </div>

                    <input type="text" class="form-control" placeholder="Pesquisar por título, autor, assunto..." />

                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="libraryDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Todas as Bibliotecas
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="libraryDropdown">
                            <li><a class="dropdown-item" href="#">Biblioteca 1</a></li>
                            <li><a class="dropdown-item" href="#">Biblioteca 2</a></li>
                            <li><a class="dropdown-item" href="#">Biblioteca 3</a></li>
                        </ul>
                    </div>

                    <button class="btn btn-primary">
                        <i class="fas fa-search"></i> Pesquisar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-md-12 p-3">
    <div class="row el-element-overlay">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-lg">
                <div class="el-card-item">
                    <div class="el-card-avatar el-overlay-1">
                        <img src="../assets/images/big/img1.jpg" alt="user">
                    </div>
                    <div class="el-card-content">
                        <a class="h4 d-block mb-0" href="?page=view-info">Abelha Zarelha</a>
                        <span class="text-muted">Raquel Patriarca</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>