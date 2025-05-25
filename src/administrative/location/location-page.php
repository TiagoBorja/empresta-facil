<?php include '../php/classes/Location.php' ?>

<div class="row justify-content-center">

    <div class="col-md-12 me-3">

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title d-flex align-items-center">
                    <i class="mdi mdi-location"></i>
                    <span class="hide-menu">Localizações</span>
                </h4>

                <a class="float-end badge rounded-pill bg-success d-inline-flex align-items-center"
                    href="?page=location-form">
                    <i class="mdi mdi-plus d-flex align-items-center"></i>
                    <span class="ms-1">Adicionar</span>
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Código Localização</th>
                                <th scope="col">Biblioteca</th>
                                <th scope="col">Ativo</th>
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
<script type="module" src="../js/pages/location-page.js"></script>
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