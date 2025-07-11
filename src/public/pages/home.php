<style>
    /* Estilos gerais */
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
        height: 250px;
        /* Imagem maior */
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

    /* Controles do carrossel */
    .carousel-control-prev,
    .carousel-control-next {
        width: 30px;
        height: 30px;
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.8;
        transition: opacity 0.15s ease;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 15px;
        height: 15px;
    }

    /* Carrossel com múltiplos itens */
    .carousel-inner {
        width: 100%;
        overflow: hidden;
        padding: 10px 0;
    }

    .carousel-item {
        transition: transform 0.6s ease-in-out;
    }

    .carousel-item.active,
    .carousel-item-next,
    .carousel-item-prev {
        display: flex;
    }

    .carousel-item-next:not(.carousel-item-start),
    .active.carousel-item-end {
        transform: translateX(33.33%);
    }

    .carousel-item-prev:not(.carousel-item-end),
    .active.carousel-item-start {
        transform: translateX(-33.33%);
    }

    /* Container para os cards */
    .carousel-item-row {
        display: flex;
        flex-wrap: nowrap;
        width: 100%;
    }

    /* Estilo para cada card no carrossel */
    .carousel-item-col {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
        padding: 0 10px;
        box-sizing: border-box;
    }

    /* Indicadores do carrossel (opcional) */
    .carousel-indicators {
        bottom: -40px;
    }

    .carousel-indicators button {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin: 0 5px;
        background-color: rgba(0, 0, 0, 0.2);
        border: none;
    }

    .carousel-indicators button.active {
        background-color: rgba(0, 0, 0, 0.5);
    }

    /* Ajustes responsivos */
    @media (max-width: 992px) {
        .carousel-item-col {
            flex: 0 0 50% !important;
            max-width: 50% !important;
        }

        .carousel-item-next:not(.carousel-item-start),
        .active.carousel-item-end {
            transform: translateX(50%);
        }

        .carousel-item-prev:not(.carousel-item-end),
        .active.carousel-item-start {
            transform: translateX(-50%);
        }
    }

    @media (max-width: 768px) {
        .img-wrapper {
            height: 200px;
        }
    }

    @media (max-width: 576px) {
        .carousel-item-col {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }

        .carousel-item-next:not(.carousel-item-start),
        .active.carousel-item-end {
            transform: translateX(100%);
        }

        .carousel-item-prev:not(.carousel-item-end),
        .active.carousel-item-start {
            transform: translateX(-100%);
        }

        .card .img-wrapper {
            height: 17em;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 25px;
            height: 25px;
        }
    }

    /* Efeito hover para os cards (opcional) */
    .card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
</style>

<?php

require './classes/Book.php';

$book = new Book();
$userName = isset($_SESSION['user']['primeiro_nome']) ?? '';

$isGuest = !isset($_SESSION['user']);

?>
<h1 class="p-3 text-center mt-3">
    <?php if (isset($_SESSION['user']['primeiro_nome'])): ?>
        Seja bem-vindo, <?= "{$_SESSION['user']['primeiro_nome']}!" ?>
    <?php else: ?>
        Seja bem-vindo!
    <?php endif; ?>
</h1>

<p class="text-center mb-4">Explore o catálogo de livros e aproveite as nossas recomendações personalizadas!</p>

<div class="row mt-3 p-2">
    <div class="col-md-4 mb-4">
        <div class="card shadow-lg">
            <div class="img-wrapper"><img src="../public/assets/images/big/shelf-book.jpg" class="d-block w-100"
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
            <div class="img-wrapper"><img src="../public/assets/images/big/ranking.jpg" class="d-block w-100"
                    alt="Livros Mais Requisitados"></div>
            <div class="card-body">
                <h5 class="card-title">Livros Mais Requisitados</h5>
                <p class="card-text">Confira os livros mais populares entre os nossos utilizadores! Não perca a chance
                    de ler os títulos que estão fazendo sucesso na biblioteca.</p><a
                    href="?page=catalog&mostRequested=true" class="btn btn-outline-primary">Veja os mais
                    requisitados</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card shadow-lg">
            <div class="img-wrapper"><img src="../public/assets/images/big/can-like.jpg" class="d-block w-100"
                    alt="Livros que Você Pode Gostar"></div>
            <div class="card-body">
                <h5 class="card-title">Livros que Você Pode Gostar</h5>
                <p class="card-text">Com base nos seus gostos,
                    selecionamos livros que podem ser do seu interesse. Explore essas sugestões personalizadas e
                    expanda seus horizontes literários!</p>

                <?php if ($isGuest): ?>
                    <a class="btn btn-outline-primary" id="loginRequired" data-bs-toggle="modal"
                        data-bs-target="#loginRequiredModal">
                        Veja suas recomendações
                    </a>
                <?php else: ?>
                    <a class="btn btn-outline-primary" href="?page=catalog&userRecommend=true">
                        Veja suas recomendações
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<h2 class="text-center p-3">Novidades</h2>
<div id="novidadesCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
    <div class="carousel-inner">
        <?php
        $books = $book->getNewBooks();
        if (!is_array($books)) {
            $books = [];
        }

        // Dividir os livros em grupos de 3
        $chunkedBooks = array_chunk($books, 3);
        ?>

        <?php if (!empty($chunkedBooks)): ?>
            <?php foreach ($chunkedBooks as $index => $bookGroup): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="carousel-item-row">
                        <?php foreach ($bookGroup as $book): ?>
                            <div class="carousel-item-col">
                                <div class="card h-100">
                                    <div class="img-wrapper">
                                        <img src="<?= isset($book['img_url']) && $book['img_url']
                                            ? '../administrative/book/upload/' . $book['img_url']
                                            : htmlspecialchars('../public/assets/images/no-book-image.jpg')
                                            ?>" class="d-block w-100" alt="<?= htmlspecialchars($book['titulo']) ?>">

                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($book['titulo']) ?></h5>
                                        <p class="card-text" style="max-height: 80px; overflow: hidden; text-overflow: ellipsis;">
                                            <?= htmlspecialchars($book['sinopse']) ?>
                                        </p>
                                        <a href="?page=book-info&id=<?= $book['id'] ?>" class="btn btn-outline-primary">Ver no
                                            Catálogo</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="carousel-item active">
                <div class="text-center w-100">Nenhum livro disponível no momento.</div>
            </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($books) && count($books) > 1): ?>
        <button class="carousel-control-prev" type="button" data-bs-target="#novidadesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#novidadesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    <?php endif; ?>

    <?php include '../includes/modal/login-required.php'; ?>
</div>