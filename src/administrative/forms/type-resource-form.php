<div class="row justify-content-center">
    <div class="col-md-12 me-3">

        <a class="text-info" href="?page=type-resources">
            <i class="mdi mdi-undo"></i>
            Voltar
        </a>

        <div class="card mt-3">
            <div class="card-header">
                <form id="changeStatus">
                    <h4 class="card-title">
                        <i class="mdi mdi-library"></i>
                        <span id="typeName" class="hide-menu">Tipo de Recurso</span>
                        <button id="active" class="float-end badge rounded-pill bg-success"></button>
                    </h4>
                </form>
            </div>
            <form id="typeResourceForm">
                <div class="card-body">
                    <div class="mb-3">
                        <input type="hidden" id="id" name="id" class="form-control" readonly>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" id="type" name="type" class="form-control" placeholder="Livro, calculadora...">
                        <label for="type">Tido de Recurso</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" id="description" name="description" class="form-control" placeholder="Morada">
                        <label for="description">Descrição</label>
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

<script type="module" src="../js/pages/type-resource-page.js"></script>
<script type="module" src="../js/forms/type-resource-form.js"></script>