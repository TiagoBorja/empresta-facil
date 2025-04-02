<?php include '../php/classes/UserRole.php' ?>

<div class="row justify-content-center">

    <div class="col-md-12 me-3">

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title d-flex align-items-center">
                    <i class="mdi mdi-account-tie"></i>
                    <span class="hide-menu">Permissões</span>
                </h4>

                <button class="float-end badge rounded-pill bg-success d-inline-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#addUserRole">
                    <i class="mdi mdi-plus d-flex align-items-center"></i>
                    <span class="ms-1">Adicionar</span>
                </button>
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

<div class="modal fade" id="addUserRole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nova Função</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="saveUserRole">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nome da Função</label>
                        <input type="text" name="role" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição da Função</label>
                        <input type="text" name="description" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-success">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../js/user-roles.js"></script>