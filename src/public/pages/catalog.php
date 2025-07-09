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
                            <li><a class="dropdown-item" href="#" data-filter="geral">Geral</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="categoria">Categoria</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="autor">Autor</a></li>
                            <li><a class="dropdown-item" href="#" data-filter="titulo">Título</a></li>
                        </ul>
                    </div>

                    <input type="text" id="searchInput" class="form-control"
                        placeholder="Pesquisar por título, autor, assunto..." />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 p-3">
    <div id="bookInfo" class="row el-element-overlay">
    </div>
</div>

<script type="module" src="../js/public-pages/catalog.js"></script>