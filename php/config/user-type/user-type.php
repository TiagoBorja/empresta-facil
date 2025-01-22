<?php include './classes/UserType.php' ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body" style="text-align: center; border-bottom: 1px solid #d4d4d4;">
                <h5 class="card-title mb-0">Tipos de Utilizador</h5>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Nome</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Ativo</th>
                        </tr>
                    </thead>
                    <tbody class="customtable">
                        <?php
                        $userType = new UserType();
                        $userType->getUserType();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-outline-success rounded-0 d-inline-flex align-items-center" data-bs-toggle="modal"
                data-bs-target="#addUserType">
                <i class="mdi mdi-plus d-flex align-items-center" style="font-size: inherit; line-height: 1;"></i>
                <span class="ms-1">Adicionar</span>
            </button>
            <button class="btn btn-outline-primary rounded-0 d-inline-flex align-items-center">
                <i class="mdi mdi-refresh d-flex align-items-center" style="font-size: inherit; line-height: 1;"></i>
                <span class="ms-1">Atualizar</span>
            </button>
            <button class="btn btn-outline-danger rounded-0 d-inline-flex align-items-center">
                <i class="mdi mdi-close d-flex align-items-center" style="font-size: inherit; line-height: 1;"></i>
                <span class="ms-1">Desabilitar</span>
            </button>
        </div>
    </div>
</div>

<!-- Modal de Criação -->
<div class="modal fade" id="addUserType" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nova Função</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="saveUserType">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nome da Função</label>
                        <input type="text" name="type" class="form-control" required>
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

<div class="modal fade" id="editUserType" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Função</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserType">
                <div class="modal-body">
                    <input type="text" name="idEdit" class="form-control">
                    <div class="mb-3">
                        <label class="form-label">Nome da Função</label>
                        <input type="text" name="type" class="form-control" required>
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
<script src="./js/user-type.js"></script>