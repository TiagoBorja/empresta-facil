<style>
    .card {
        display: flex;
        flex-direction: column;
        height: 100%;
        min-height: 400px;
        margin-bottom: 20px;
        margin: 0 0.5em;
        box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
        border: none;
    }

    .card-body {
        display: flex;
        flex-grow: 1;
        flex-direction: column;
        justify-content: space-between;
        text-align: center;
    }

    .img-wrapper {
        position: relative;
        width: 100%;
        height: 200px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .img-wrapper img {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .carousel-inner {
        padding: 1em;
        display: flex;
    }

    .carousel-item {
        flex: 0 0 33.333333%;
        display: block;
        margin-right: 0;
    }

    .carousel-control-prev,
    .carousel-control-next {
        background-color: #e1e1e1;
        width: 6vh;
        height: 6vh;
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .img-wrapper {
            height: 150px;
        }
    }

    @media (max-width: 767px) {
        .card .img-wrapper {
            height: 17em;
        }
    }

    /* Ajuste para telas maiores */
    @media (min-width: 768px) {
        .carousel-inner {
            display: flex;
        }
    }
</style>

<h1 class="p-3 text-center mt-3">Seja bem-vindo, Fulano!</h1>
<p class="text-center mb-4">Explore o catálogo de livros e aproveite as nossas recomendações personalizadas!</p>

<div class="row mt-3 p-2">
    <div class="col-md-4 mb-4">
        <div class="card shadow-lg">
            <div class="img-wrapper"><img src="../assets/images/big/shelf-book.jpg" class="d-block w-100"
                    alt="Explore o Catálogo"></div>
            <div class="card-body">
                <h5 class="card-title">Explore o Catálogo Completo</h5>
                <p class="card-text">Descubra uma vasta coleção de livros e materiais que podem enriquecer sua
                    jornada de aprendizado. Navegue por categorias e encontre o que mais combina com seus interesses!
                </p><a href="?page=catalog" class="btn btn-outline-primary">Ver no Catálogo</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card shadow-lg">
            <div class="img-wrapper"><img src="../assets/images/big/ranking.jpg" class="d-block w-100"
                    alt="Livros Mais Requisitados"></div>
            <div class="card-body">
                <h5 class="card-title">Livros Mais Requisitados</h5>
                <p class="card-text">Confira os livros mais populares entre os nossos usuários! Não perca a chance
                    de ler os títulos que estão fazendo sucesso na biblioteca.</p><a href="?page=view-info"
                    class="btn btn-outline-primary">Veja os mais requisitados</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card shadow-lg">
            <div class="img-wrapper"><img src="../assets/images/big/can-like.jpg" class="d-block w-100"
                    alt="Livros que Você Pode Gostar"></div>
            <div class="card-body">
                <h5 class="card-title">Livros que Você Pode Gostar</h5>
                <p class="card-text">Com base nos seus gostos,
                    selecionamos livros que podem ser do seu interesse. Explore essas sugestões personalizadas e
                    expanda seus horizontes literários!</p><a href="?page=3" class="btn btn-outline-primary">Veja
                    suas recomendações</a>
            </div>
        </div>
    </div>
</div>

<h2 class="text-center p-3">Destaques</h2>
<div id="carouselExampleControls" class="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="card">
                <div class="img-wrapper"><img src="../assets/images/big/img1.jpg" class="d-block w-100" alt="..."></div>
                <div class="card-body">
                    <h5 class="card-title">Card title 1</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk
                        of the card's content.</p>
                    <a href="?page=catalog" class="btn btn-primary">Ver no Catálogo</a>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="card">
                <div class="img-wrapper"><img src="../assets/images/big/img2.jpg" class="d-block w-100" alt="..."></div>
                <div class="card-body">
                    <h5 class="card-title">Card title 2</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk
                        of the card's content.</p>
                    <a href="?page=catalog" class="btn btn-primary">Ver no Catálogo</a>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="card">
                <div class="img-wrapper"><img src="../assets/images/big/img3.jpg" class="d-block w-100" alt="..."></div>
                <div class="card-body">
                    <h5 class="card-title">Card title 3</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk
                        of the card's content.</p>
                    <a href="?page=catalog" class="btn btn-primary">Ver no Catálogo</a>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="card">
                <div class="img-wrapper"><img src="../assets/images/big/img3.jpg" class="d-block w-100" alt="..."></div>
                <div class="card-body">
                    <h5 class="card-title">Card title 4</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk
                        of the card's content.</p>
                    <a href="?page=catalog" class="btn btn-primary">Ver no Catálogo</a>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="card">
                <div class="img-wrapper"><img src="../assets/images/big/img3.jpg" class="d-block w-100" alt="..."></div>
                <div class="card-body">
                    <h5 class="card-title">Card title 5</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk
                        of the card's content.</p>
                    <a href="?page=catalog" class="btn btn-primary">Ver no Catálogo</a>
                </div>
            </div>
        </div>
    </div><button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
        data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span
            class="visually-hidden">Previous</span></button><button class="carousel-control-next" type="button"
        data-bs-target="#carouselExampleControls" data-bs-slide="next"><span class="carousel-control-next-icon"
            aria-hidden="true"></span><span class="visually-hidden">Next</span></button>
</div>
<script src="./js/carousel.js"></script>