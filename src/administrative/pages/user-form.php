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
                        <span id="permissionName" class="hide-menu">Permissões</span>
                        <button id="active" class="float-end badge rounded-pill bg-success"></button>
                    </form>
                </h4>
            </div>

            <form id="userForm">
                <div class="card-body">

                    <!-- Informações Pessoais -->
                    <fieldset>
                        <legend>Informações Pessoais</legend>
                        <div class="mb-3">
                            <label class="form-label" for="first_name">Primeiro Nome</label>
                            <input type="text" id="first_name" name="first_name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="last_name">Último Nome</label>
                            <input type="text" id="last_name" name="last_name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="birth_date">Data de Nascimento</label>
                            <input type="date" id="birth_date" name="birth_date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nif">NIF</label>
                            <input type="text" id="nif" name="nif" class="form-control">
                        </div>
                    </fieldset>

                    <!-- Identificação -->
                    <fieldset>
                        <legend>Identificação</legend>
                        <div class="mb-3">
                            <label class="form-label" for="cc">Cartão de Cidadão</label>
                            <input type="text" id="cc" name="cc" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="gender">Género</label>
                            <input type="text" id="gender" name="gender" class="form-control">
                        </div>
                    </fieldset>

                    <!-- Endereço -->
                    <fieldset>
                        <legend>Endereço</legend>
                        <div class="mb-3">
                            <label class="form-label" for="address">Morada</label>
                            <textarea id="address" name="address" class="form-control"></textarea>
                        </div>
                    </fieldset>

                    <!-- Contato -->
                    <fieldset>
                        <legend>Contato</legend>
                        <div class="mb-3">
                            <label class="form-label" for="phone_number">Telemóvel</label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="username">Nome de Utilizador</label>
                            <input type="text" id="username" name="username" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                    </fieldset>

                    <!-- Tipo de Utilizador -->
                    <div class="mb-3">
                        <label class="form-label" for="user_type_fk">Tipo de Utilizador</label>
                        <select id="user_type_fk" name="user_type_fk" class="form-select">
                            <option value="">Selecionar</option>
                            <option value="1">Administrador</option>
                            <option value="2">Bibliotecário</option>
                            <option value="3">Aluno</option>
                        </select>
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