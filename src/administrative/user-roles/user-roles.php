<?php include '../php/classes/UserRole.php' ?>

<div class="row justify-content-center">

    <div class="col-md-12 me-3">

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title d-flex align-items-center">
                    <i class="mdi mdi-account-tie"></i>
                    <span class="hide-menu">Permissões</span>
                </h4>

                <a class="float-end badge rounded-pill bg-success d-inline-flex align-items-center"
                    href="?page=role-form" data-bs-target="#addUserRole">
                    <i class="mdi mdi-plus d-flex align-items-center"></i>
                    <span class="ms-1">Adicionar</span>
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Ativo</th>
                            </tr>
                        </thead>
                        <tbody class="customtable">
                            <?php
                            $UserRole = new UserRole();
                            $UserRole->getUserRole();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const toastMessage = sessionStorage.getItem('toastMessage');

        if (toastMessage === 'success') {
            toastr.success("Operação realizada com sucesso!", "Sucesso!");
        } else if (toastMessage === 'error') {
            toastr.error("Ocorreu um erro ao processar a solicitação.", "Erro!");
        }
        sessionStorage.removeItem('toastMessage');

        initializeRowSelection();
    });

    function initializeRowSelection() {
        const selectedRows = document.querySelectorAll("[id*=role-]");

        selectedRows.forEach(row => {
            row.addEventListener("click", () => fetchRoleData(row.id));
        });
    }

    async function fetchRoleData(rowId) {
        try {
            const roleId = rowId.replace("role-", "");
            const response = await fetch(`../administrative/user-roles/code.php?roleId=${roleId}`);

            if (!response.ok) throw new Error("Erro na requisição");

            const data = await response.json();

            if (data.status === 200) {
                window.location.href = `?page=role-form&roleId=${roleId}`;
            }
        } catch (error) {
            console.error("Erro ao obter os dados da role:", error);
        }
    }
</script>