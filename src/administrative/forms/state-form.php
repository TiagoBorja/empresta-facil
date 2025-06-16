<div class="row justify-content-center">
    <div class="col-md-10 me-3">

        <a class="text-info" href="?page=state">
            <i class="mdi mdi-undo"></i>
            Voltar
        </a>

        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="mdi mdi-alert-circle me-2"></i>
                    <span id="stateName" class="hide-menu">Estado</span>
                </h4>
            </div>
            <form id="stateForm">
                <div class="card-body">

                    <div class="row g-3">
                        <div class="mb-3">
                            <input type="text" id="id" name="id" class="form-control" readonly>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-floating">
                                <input type="text" id="state" name="state" class="form-control">
                                <label class="form-label">Estado</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-floating">
                                <input type="text" id="observation" name="observation" class="form-control">
                                <label class="form-label">Observações</label>
                            </div>
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

<script type="module" src="../js/pages/state-page.js"></script>
<script type="module" src="../js/forms/state-form.js"></script>