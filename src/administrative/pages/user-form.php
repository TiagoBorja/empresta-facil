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
                    <fieldset>
                        <legend class="text-center mb-3">Informações Pessoais</legend>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="first_name">Primeiro Nome</label>
                                <input type="text" id="first_name" name="first_name" class="form-control"
                                    placeholder="Exemplo: João">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="last_name">Último Nome</label>
                                <input type="text" id="last_name" name="last_name" class="form-control"
                                    placeholder="Exemplo: Silva">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="nif">NIF</label>
                                <input type="text" id="nif" name="nif" class="form-control"
                                    placeholder="Exemplo: 123456789">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label" for="birth_date">Data de Nascimento</label>
                                <input type="date" id="birth_date" name="birth_date" class="form-control">
                            </div>
                        </div>
                    </fieldset>
                    <hr>
                    <!-- Identificação -->
                    <fieldset>
                        <legend>Identificação</legend>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="cc">Cartão de Cidadão</label>
                                <input type="text" id="cc" name="cc" class="form-control"
                                    placeholder="Exemplo: 12345678Z">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="gender">Género</label>
                                <input type="text" id="gender" name="gender" class="form-control"
                                    placeholder="Exemplo: Masculino">
                            </div>
                        </div>
                    </fieldset>
                    <hr>
                    <!-- Endereço -->
                    <fieldset>
                        <legend>Endereço</legend>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="address">Morada</label>
                                <textarea id="address" name="address" class="form-control"
                                    placeholder="Exemplo: Rua da Liberdade, 123"></textarea>
                            </div>
                        </div>
                    </fieldset>
                    <hr>
                    <!-- Contato -->
                    <fieldset>
                        <legend>Contato</legend>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="phone_number">Telemóvel</label>
                                <input type="text" id="phone_number" name="phone_number" class="form-control"
                                    placeholder="Exemplo: 912345678">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="username">Nome de Utilizador</label>
                                <input type="text" id="username" name="username" class="form-control"
                                    placeholder="Exemplo: joao.silva">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="Exemplo: joao.silva@email.com">
                            </div>
                        </div>
                    </fieldset>
                    <hr>
                    <fieldset>
                        <legend>Login</legend>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="username">Nome de Utilizador</label>
                                <input type="text" id="username" name="username" class="form-control"
                                    placeholder="Exemplo: joao.silva">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="email">Senha</label>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Exemplo: 12344566">
                            </div>
                        </div>
                    </fieldset>
                    <!-- Tipo de Utilizador -->
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label" for="user_type_fk">Permissão</label>
                            <select id="roleSelect" class="form-select">
                                <option value="">Selecionar</option>
                            </select>
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
</div>
<script type="module" src="../js/users.js"></script>