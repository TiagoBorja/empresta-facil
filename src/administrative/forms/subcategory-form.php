<div class="row justify-content-center">
    <div class="col-md-12 me-3">

        <a class="text-info" href="?page=subcategories">
            <i class="mdi mdi-undo"></i>
            Voltar
        </a>

        <div class="card mt-3">
            <div class="card-header">
                <form id="changeStatus">
                    <h4 class="card-title">
                        <i class="mdi mdi-account-tie"></i>
                        <span id="subcategoryName" class="hide-menu">Subcategoria</span>
                        <button id="active" class="float-end badge rounded-pill bg-success"></button>
                    </h4>
                </form>
            </div>
            <form id="subcategoryForm">
                <div class="card-body">
                    <div class="mb-3">
                        <input type="hidden" id="id" name="id" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoria Principal</label>
                        <select class="form-select" id="category" name="category"> </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subcategoria</label>
                        <input type="text" id="subcategory" name="subcategory" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição da Subcategoria</label>
                        <input type="text" id="description" name="description" class="form-control">
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

<script type="module" src="../js/pages/subcategory-page.js"></script>
<script type="module" src="../js/forms/subcategory-form.js"></script>