<div id="loading" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div class="text-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">A carregar...</span>
        </div>
        <p class="mt-3">A carregar...</p>
    </div>
</div>

<div id="content" class="row justify-content-center" style="display: none;">
    <div class="col-md-12 me-3">
        <nav aria-label="Navegação secundária">
            <a class="text-info" href="?page=books">
                <i class="mdi mdi-undo"></i>
                Voltar
            </a>
        </nav>

        <article class="card mt-3">
            <header class="card-header">
                <form id="changeStatus">
                    <h1 class="card-title h4">
                        <i class="mdi mdi-user"></i>
                        <span id="bookTitle" class="hide-menu">Livro</span>
                        <button id="active" class="float-end badge rounded-pill bg-success"
                            aria-label="Status do livro"></button>
                    </h1>
                </form>
            </header>

            <form id="bookForm" enctype="multipart/form-data">
                <div class="card-body">
                    <input type="hidden" id="id" name="id" class="form-control" readonly>

                    <section class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" id="title" name="title" class="form-control"
                                    placeholder="Título do Livro" required>
                                <label for="title">Título</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" id="isbn" name="isbn" class="form-control" placeholder="ISBN"
                                    required>
                                <label for="isbn">ISBN</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-floating">
                                <input type="number" id="releaseYear" name="releaseYear" class="form-control"
                                    placeholder="Ano de Lançamento" min="1">
                                <label for="releaseYear">Ano de Lançamento</label>
                            </div>
                        </div>
                    </section>

                    <section class="row g-3 mt-2">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" id="language" name="language" class="form-control"
                                    placeholder="Idioma do Livro">
                                <label for="language">Idioma</label>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-floating">
                                <select class="form-select" id="publisher" name="publisher">
                                    <option value="">Selecionar</option>
                                </select>
                                <label for="publisher">Editora</label>
                            </div>
                        </div>
                    </section>

                    <section class="row g-3 mt-2">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select" id="category" name="category">
                                    <option value="">Selecionar</option>
                                </select>
                                <label for="category">Categoria</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select" id="subcategory" name="subcategory">
                                    <option value="">Selecionar</option>
                                </select>
                                <label for="subcategory">Subcategoria</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <button class="form-select text-start ps-3 pe-5 position-relative" type="button"
                                    id="authorsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span id="selectedAuthorsText" class="text-truncate">Selecionar autores</span>
                                </button>

                                <div id="authorsCheckboxes" class="dropdown-menu p-3 w-100"
                                    aria-labelledby="authorsDropdown">
                                    <input type="text" name="searchInput" id="searchInput" placeholder="Nome">
                                </div>

                                <label for="authorsDropdown" class="form-label">Autor(es)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <textarea id="synopsis" name="synopsis" class="form-control" placeholder="Sinopse"
                                    style="height: 100px"></textarea>
                                <label for="synopsis">Sinopse</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="file" id="bookImg" name="bookImg" accept="image/png, image/jpeg"
                                    class="form-control" aria-label="Selecionar foto do autor">
                                <label for="bookImg">Foto do Livro</label>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <img id="bookPreview" src="" alt="Foto de Perfil Atual" class="img-fluid rounded"
                                style="max-height: 150px;">
                        </div>
                    </section>

                    <div id="user-info" class="d-flex gap-4 mt-3 small d-none">
                        <div>
                            <i class="bi bi-person me-1"></i>
                            Criado por <strong id="created-user" class="fw-semibold">-</strong>
                            <br>
                            <time id="created-date" class="fst-italic">-</time>
                        </div>
                        <div>
                            <i class="bi bi-pencil me-1"></i>
                            Editado por <strong id="updated-user" class="fw-semibold">-</strong>
                            <br>
                            <time id="updated-date" class="fst-italic">-</time>
                        </div>
                    </div>
                </div>

                <footer class="card-footer">
                    <div class="text-center">
                        <button name="saveData" type="submit"
                            class="btn btn-success text-white rounded-0 d-inline-flex align-items-center">
                            <i class="mdi mdi-content-save d-flex align-items-center align-text-icon"></i>
                            <span class="ms-1">Guardar</span>
                        </button>
                        <button id="clear" type="button"
                            class="btn btn-primary text-white rounded-0 d-inline-flex align-items-center">
                            <i class="mdi mdi-refresh d-flex align-items-center align-text-icon"></i>
                            <span class="ms-1">Limpar</span>
                        </button>
                    </div>
                </footer>
            </form>

        </article>
    </div>
</div>

<script type="module" src="../js/pages/book-page.js"></script>
<script type="module" src="../js/forms/book-form.js"></script>