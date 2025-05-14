<?php include '../php/classes/User.php' ?>

<div class="row justify-content-center">

    <div class="col-md-12 me-3">

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title d-flex align-items-center">
                    <i class="mdi mdi-account-tie"></i>
                    <span class="hide-menu">Utilizadores</span>
                </h4>

                <a class="float-end badge rounded-pill bg-success d-inline-flex align-items-center"
                    href="?page=user-form" data-bs-target="#addUser">
                    <i class="mdi mdi-plus d-flex align-items-center"></i>
                    <span class="ms-1">Adicionar</span>
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered dataTable" role="grid"
                        aria-describedby="zero_config_info">
                        <thead class="thead-dark">
                            <tr class="role">
                                <th class="sorting_asc" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                    style="width: 126.375px;">
                                    Primeiro Nome
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                    style="width: 126.375px;">
                                    Último Nome</th>
                                <th class="sorting_asc" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                    style="width: 126.375px;">
                                    Nome de Utilizador</th>
                                <th class="sorting_asc" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                    style="width: 126.375px;">
                                    Email</th>
                                <th class="sorting_asc" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                    style="width: 126.375px;">
                                    Permissão</th>
                                <th class="sorting_asc" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                    style="width: 126.375px;">
                                    Ativo</th>
                            </tr>


                        </thead>
                        <tbody id="tbody" class="customtable">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="module" src="../js/pages/users-page.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const toastMessage = sessionStorage.getItem('toastMessage');

        if (toastMessage === 'success') {
            toastr.success("Operação realizada com sucesso!", "Sucesso!");
        } else if (toastMessage === 'error') {
            toastr.error("Ocorreu um erro ao processar a solicitação.", "Erro!");
        }
        sessionStorage.removeItem('toastMessage');

    });
</script>