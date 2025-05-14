<div class="row justify-content-center">
    <div class="col-md-12 me-3">

        <a class="text-info" href="?page=user-roles">
            <i class="mdi mdi-undo"></i>
            Voltar
        </a>

        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">
                    <form id="changeStatus">
                        <i class="mdi mdi-account-tie"></i>
                        <span id="permissionName" class="hide-menu">Permissões</span>
                        <button id="active" class="float-end badge rounded-pill bg-success"></button>
                    </form>
                </h4>
            </div>
            <form id="roleForm">
                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" id="id" name="id" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nome da Permissão</label>
                        <input type="text" id="role" name="role" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição da Permissão</label>
                        <input type="text" id="description" name="description" class="form-control">
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

<script type="module" src="../js/pages/user-roles-page.js"></script>
<script type="module" src="../js/forms/role-form.js"></script>