<div class="row justify-content-center">
    <div class="col-md-12 me-3">

        <a class="text-info" href="?page=users">
            <i class="mdi mdi-undo"></i>
            Voltar
        </a>

        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">
                    <form id="changeStatus">
                        <i class="mdi mdi-account-tie"></i>
                        <span id="permissionName" class="hide-menu">Utilizador</span>
                        <button id="active" class="float-end badge rounded-pill bg-success"></button>
                    </form>
                </h4>
            </div>

            <form id="userForm">
                <div class="card-body">

                    <!-- Informações Pessoais -->
                    <fieldset class="mb-4">
                        <legend class="fs-5 fw-bold text-primary border-bottom pb-2 text-center">
                            <i class="mdi mdi-card-account-details me-2"></i>Informações Pessoais
                        </legend>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" id="firstName" name="firstName" class="form-control"
                                        placeholder="João">
                                    <label for="firstName">Primeiro Nome</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" id="lastName" name="lastName" class="form-control"
                                        placeholder="Silva">
                                    <label for="lastName">Último Nome</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" id="nif" name="nif" class="form-control" placeholder="123456789">
                                    <label for="nif">NIF</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" id="cc" name="cc" class="form-control" placeholder="123456789">
                                    <label for="cc">Cartão de Cidadão</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select" name="gender" id="gender">
                                        <option value="">Selecionar</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Feminino</option>
                                        <option value="O">Outro</option>
                                    </select>
                                    <label for="gender">Género</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="date" id="birthDay" name="birthDay" class="form-control"
                                        placeholder="123456789">
                                    <label for="birthDay">Data de Nascimento</label>
                                </div>
                            </div>
                    </fieldset>
                    <hr>
                    <!-- Endereço -->
                    <fieldset class="mb-4">
                        <legend class="fs-5 fw-bold text-primary border-bottom pb-2 text-center">
                            <i class="mdi mdi-home me-2"></i>Morada
                        </legend>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <textarea id="address" name="address" class="form-control"
                                        placeholder="Exemplo: Rua da Liberdade, 123"></textarea>
                                    <label class="form-label" for="address">Morada</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <hr>
                    <!-- Contato -->
                    <fieldset class="mb-4">
                        <legend class="fs-5 fw-bold text-primary border-bottom pb-2 text-center">
                            <i class="mdi mdi-phone me-2"></i>Contato
                        </legend>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                                        placeholder="Exemplo: 912345678">
                                    <label class="form-label" for="phoneNumber">Telemóvel</label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="Exemplo: joao.silva@email.com">
                                    <label class="form-label" for="email">Email</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <hr>
                    <fieldset class="mb-4">
                        <legend class="fs-5 fw-bold text-primary border-bottom pb-2 text-center">
                            <i class="mdi mdi-login me-2"></i>Informações de Acesso
                        </legend>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" id="username" name="username" class="form-control"
                                        placeholder="Exemplo: joao.silva">
                                    <label class="form-label" for="username">Nome de Utilizador</label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Exemplo: 12344566">
                                    <label class="form-label" for="email">Senha</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <!-- Tipo de Utilizador -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="roleSelect" name="role">
                                    <option value="">Selecionar</option>
                                </select>
                                <label class="form-label" for="role">Permissão</label>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <div class="card-footer">
            <div class="text-center">
                <button name="saveData" type="submit" class="btn btn-success text-white rounded-0">
                    <i class="mdi mdi-content-save"></i>
                    <span class="ms-1">Guardar</span>
                </button>
                <button id="clear" type="button" class="btn btn-primary text-white rounded-0">
                    <i class="mdi mdi-refresh"></i>
                    <span class="ms-1">Limpar</span>
                </button>
            </div>
        </div>
        </form>

    </div>
</div>
<script type="module" src="../js/users.js"></script>