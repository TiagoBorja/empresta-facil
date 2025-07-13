<div class="row justify-content-center">
    <div class="col-md-12 me-3">

        <a class="text-info" href="?page=libraries">
            <i class="mdi mdi-undo"></i>
            Voltar
        </a>

        <div class="card mt-3">
            <div class="card-header">
                <form id="changeStatus">
                    <h4 class="card-title">
                        <i class="mdi mdi-library"></i>
                        <span id="libraryName" class="hide-menu">Biblioteca</span>
                        <button id="active" class="float-end badge rounded-pill bg-success"></button>
                    </h4>
                </form>
            </div>
            <form id="libraryForm">
                <div class="card-body">
                    <div class="mb-3">
                        <input type="hidden" id="id" name="id" class="form-control" readonly>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" id="name" name="name" class="form-control" placeholder="Nome da Biblioteca"
                            required>
                        <label for="name">Nome da Biblioteca</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" id="email" name="email" class="form-control"
                            placeholder="Email da Biblioteca" required>
                        <label for="email">Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" id="address" name="address" class="form-control" placeholder="Morada"
                            required>
                        <label for="address">Morada</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" id="postalCode" name="postalCode" class="form-control" placeholder="1111-333"
                            required>
                        <label for="postalCode">Código Postal</label>
                    </div>

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
                <div class="card-footer">
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
                </div>
            </form>
        </div>
    </div>
</div>

<script type="module" src="../js/pages/library-page.js"></script>
<script type="module" src="../js/forms/library-form.js"></script>