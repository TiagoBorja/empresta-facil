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
            <a class="text-info" href="?page=authors">
                <i class="mdi mdi-undo"></i>
                Voltar
            </a>
        </nav>

        <article class="card mt-3">
            <header class="card-header">
                <form id="changeStatus">
                    <h1 class="card-title h4">
                        <i class="mdi mdi-user"></i>
                        <span id="authorName" class="hide-menu">Autor</span>
                        <button id="active" class="float-end badge rounded-pill bg-success"
                            aria-label="Status do autor"></button>
                    </h1>
                </form>
            </header>

            <form id="authorForm" enctype="multipart/form-data">
                <div class="card-body">
                    <input type="hidden" id="id" name="id" class="form-control" readonly>

                    <section class="row g-3">

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" id="firstName" name="firstName" class="form-control"
                                    placeholder="João" required>
                                <label for="firstName">Primeiro Nome</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" id="lastName" name="lastName" class="form-control"
                                    placeholder="Silva" required>
                                <label for="lastName">Último Nome</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select" name="gender" id="gender" aria-label="Gênero do autor">
                                    <option value="">Selecionar</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                                    <option value="O">Outro</option>
                                </select>
                                <label for="gender">Género</label>
                            </div>
                        </div>
                    </section>

                    <section class="row g-3 mt-2">
                        <h2 class="visually-hidden">Informações Adicionais</h2>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" id="nationality" name="nationality" class="form-control"
                                    placeholder="Português, Americano...">
                                <label for="nationality">Nacionalidade</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="date" id="birthDay" name="birthDay" class="form-control"
                                    placeholder="Data de Nascimento">
                                <label for="birthDay">Data de Nascimento</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="file" id="imgProfile" name="imgProfile" accept="image/png, image/jpeg"
                                    class="form-control" aria-label="Selecionar foto do autor">
                                <label for="imgProfile">Foto do Autor</label>
                            </div>
                        </div>

                        <div class="col-8">
                            <div class="form-floating">
                                <textarea id="biography" name="biography" class="form-control"
                                    placeholder="Biografia do autor" style="height: 100px"></textarea>
                                <label for="biography">Biografia</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating mb-2">
                                <img id="imgPreview" src="" alt="Foto Atual" class="img-fluid rounded"
                                    style="max-height: 150px;">
                            </div>
                            <button id="btnDeleteImg" type="button" class="btn btn-outline-danger btn-sm">
                                <i class="mdi mdi-close"></i>
                            </button>
                        </div>
                    </section>
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

<script type="module" src="../js/pages/author-page.js"></script>
<script type="module" src="../js/forms/author-form.js"></script>