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
            <form id="roleForm">
                <div class="card-body">
                    <div class="mb-3">
                        <input type="hidden" id="roleId" name="roleId" class="form-control" readonly>
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
                        <button name="updateData" type="submit"
                            class="btn btn-success text-white rounded-0 d-inline-flex align-items-center">
                            <i class="mdi mdi-content-save d-flex align-items-center align-text-icon"></i>
                            <span class="ms-1">Guardar</span>
                        </button>
                        <button class="btn btn-primary text-white rounded-0 d-inline-flex align-items-center">
                            <i class="mdi mdi-refresh d-flex align-items-center align-text-icon"></i>
                            <span class="ms-1">Limpar</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../js/user-roles.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', async function () {
        const urlParams = new URLSearchParams(window.location.search);
        const roleId = urlParams.get("roleId");

        try {
            const response = await fetch(`../administrative/user-roles/code.php?roleId=${roleId}`);

            if (!response.ok) throw new Error("Erro na requisição");

            const result = await response.json();

            if (result.status === 200) {
                document.getElementById("permissionName").textContent = `Permissão - ${result.data.tipo}`;
                document.getElementById("roleId").value = result.data.id;
                document.getElementById("role").value = result.data.tipo;
                document.getElementById("description").value = result.data.descricao;

                const activeBadge = document.getElementById("active");
                activeBadge.textContent = result.data.ativo === "Y" ? "Ativo" : "Inativo";
                activeBadge.classList.toggle("bg-success", result.data.ativo === "Y");
                activeBadge.classList.toggle("bg-danger", result.data.ativo === "N");
            }
        } catch (error) {
            toastr.error(error, "Erro!");
        }
    });

</script>