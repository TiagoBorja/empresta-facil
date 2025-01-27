<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Pesquisar Catálogo</h4>
                <div class="input-group">
                    <!-- Dropdown de filtro à esquerda -->
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Filtrar por
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                            <li><a class="dropdown-item" href="#">Categoria</a></li>
                            <li><a class="dropdown-item" href="#">Autor</a></li>
                            <li><a class="dropdown-item" href="#">Assunto</a></li>
                        </ul>
                    </div>
                    
                    <!-- Caixa de pesquisa -->
                    <input type="text" class="form-control" placeholder="Pesquisar por título, autor, assunto..." />

                    <!-- Dropdown para selecionar biblioteca à direita -->
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="libraryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Selecionar Biblioteca
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="libraryDropdown">
                            <li><a class="dropdown-item" href="#">Biblioteca 1</a></li>
                            <li><a class="dropdown-item" href="#">Biblioteca 2</a></li>
                            <li><a class="dropdown-item" href="#">Biblioteca 3</a></li>
                        </ul>
                    </div>

                    <!-- Botão de pesquisa -->
                    <button class="btn btn-primary">
                        <i class="bi bi-search"></i> Pesquisar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Main Content -->
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Destaques</h2>
    </div>
</div>

<!-- Carousel Section -->
<div id="featuredBooks" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1200&q=80"
                class="d-block w-100" alt="Biblioteca" style="height: 400px; object-fit: cover;" />
            <div class="carousel-caption">
                <h3>Novos Livros Disponíveis</h3>
                <p>Descubra nossa mais recente coleção de livros</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=1200&q=80"
                class="d-block w-100" alt="Estudantes" style="height: 400px; object-fit: cover;" />
            <div class="carousel-caption">
                <h3>Espaço de Estudo</h3>
                <p>Ambientes confortáveis para sua leitura</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=1200&q=80"
                class="d-block w-100" alt="Livros" style="height: 400px; object-fit: cover;" />
            <div class="carousel-caption">
                <h3>Acervo Digital</h3>
                <p>Acesse nossa biblioteca digital</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#featuredBooks" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#featuredBooks" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
    </button>
</div>

<!-- Quick Links -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="bi bi-book-fill text-primary mb-3" style="font-size: 40px;"></i>
                <h5 class="card-title">Catálogo</h5>
                <p class="card-text">Explore nossa coleção completa de livros e recursos.</p>
                <a class="btn btn-outline-primary" href="?pagina=1">Ver Catálogo</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="bi bi-book-open-fill text-primary mb-3" style="font-size: 40px;"></i>
                <h5 class="card-title">Empréstimos</h5>
                <p class="card-text">Gerencie seus empréstimos e reservas.</p>
                <button class="btn btn-outline-primary">Meus Empréstimos</button>
            </div>
        </div>
    </div>
</div>
