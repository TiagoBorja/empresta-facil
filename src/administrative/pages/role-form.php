<div class="row justify-content-center">
    <div class="col-md-12 me-3">

        <a class="text-info" href="?page=user-roles">
            <i class="mdi mdi-undo"></i>
            Voltar
        </a>

        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="mdi mdi-account-tie"></i>
                    <span id="permissionName" class="hide-menu">Permissões</span>
                    <button id="active" class="float-end badge rounded-pill bg-success"></button>
                </h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Nome da Permissão</label>
                    <input type="text" id="role" name="role" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descrição da Permissão</label>
                    <input type="text" id="description" name="description" class="form-control" required>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button class="btn btn-success text-white rounded-0 d-inline-flex align-items-center">
                        <i class="mdi mdi-content-save d-flex align-items-center align-text-icon"></i>
                        <span class="ms-1">Guardar</span>
                    </button>
                    <button class="btn btn-primary text-white rounded-0 d-inline-flex align-items-center">
                        <i class="mdi mdi-refresh d-flex align-items-center align-text-icon"></i>
                        <span class="ms-1">Limpar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const storedData = localStorage.getItem('roleData');

        if (storedData) {
            const data = JSON.parse(storedData);

            const permissionName = document.getElementById('permissionName');
            permissionName.textContent = `Permissão - ${data.tipo}`;
            document.getElementById('role').value = data.tipo;
            document.getElementById('description').value = data.descricao;

            const activeBadge = document.getElementById('active');
            activeBadge.textContent = data.ativo === 'Y' ? 'Ativo' : 'Inativo';
            activeBadge.classList.toggle('bg-success', data.ativo);
            activeBadge.classList.toggle('bg-danger', data.ativo === 'N');

            localStorage.removeItem('roleData');
        }
    });

</script>