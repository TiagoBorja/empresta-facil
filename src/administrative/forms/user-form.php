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
                        <span id="userName" class="hide-menu">Utilizador</span>
                        <button id="active" class="float-end badge rounded-pill bg-success"></button>
                    </form>
                </h4>
            </div>

            <form id="userForm" enctype="multipart/form-data">

                <div class="card-body">
                    <div class="row g-3"> <!-- g-3 para dar espaço entre os fieldsets -->
                        <fieldset class="col-md-6 mb-4">
                            <legend class="fs-5 fw-bold text-primary border-bottom pb-2 text-center">
                                <i class="mdi mdi-card-account-details me-2"></i>Informações Pessoais
                            </legend>
                            <div class="row g-3">
                                <input type="hidden" id="id" name="id">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" id="firstName" name="firstName" class="form-control"
                                            placeholder="João" required>
                                        <label for="firstName">Primeiro Nome</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" id="lastName" name="lastName" class="form-control"
                                            placeholder="Silva" required>
                                        <label for="lastName">Último Nome</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" id="nif" name="nif" class="form-control"
                                            placeholder="123456789">
                                        <label for="nif">NIF</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" id="cc" name="cc" class="form-control"
                                            placeholder="123456789">
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
                                <div class="col-md-8">
                                    <div class="form-floating">
                                        <input type="date" id="birthDay" name="birthDay" class="form-control"
                                            placeholder="Data de Nascimento">
                                        <label for="birthDay">Data de Nascimento</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                                            placeholder="Exemplo: 912345678">
                                        <label for="phoneNumber">Telemóvel</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="Exemplo: joao.silva@email.com" required>
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <textarea id="address" name="address" class="form-control"
                                            placeholder="Exemplo: Rua da Liberdade, 123"></textarea>
                                        <label for="address">Morada</label>
                                    </div>
                                </div>
                            </div> <!-- fecha a row dos inputs -->
                        </fieldset>

                        <fieldset class="col-md-6 mb-4">
                            <legend class="fs-5 fw-bold text-primary border-bottom pb-2 text-center">
                                <i class="mdi mdi-login me-2"></i>Informações de Acesso
                            </legend>

                            <div class="row g-3">

                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" id="username" name="username" class="form-control"
                                            placeholder="Exemplo: joao.silva" required>
                                        <label for="username">Nome de Utilizador</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" id="password" name="password" class="form-control d-none"
                                            placeholder="Exemplo: joao.silva" required>
                                        <label for="password">Senha</label>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <select class="form-select" id="roleSelect" name="role">
                                            <option value="">Selecionar</option>
                                        </select>
                                        <label class="form-label" for="role">Permissão</label>
                                    </div>
                                </div>

                                <div id="libraryDropdownDiv" class="col-md-12 d-none">
                                    <div class="form-floating">
                                        <button class="form-select text-start ps-3 pe-5 position-relative" type="button"
                                            id="librariesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span id="selectedLibrariesText" class="text-truncate">Selecionar
                                                Biblioteca</span>
                                        </button>

                                        <div id="librariesCheckboxes" class="dropdown-menu p-3 w-100"
                                            aria-labelledby="librariesDropdown">
                                            <input type="text" name="searchInput" id="searchInput" placeholder="Nome">
                                        </div>

                                        <label for="librariesDropdown" class="form-label">Biblioteca(s)</label>
                                    </div>
                                </div>

                                <div class="row g-3 col-md-12">
                                    <div class="col-md-8">
                                        <div class="form-floating">
                                            <!-- Upload de nova imagem -->
                                            <input type="file" id="imgProfile" name="imgProfile"
                                                accept="image/png, image/jpeg" class="form-control">
                                            <label for="imgProfile">Foto de Perfil</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <img id="profilePreview" src="" alt="Foto de Perfil Atual"
                                            class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                </div>
                            </div>
                        </fieldset>

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
            </form>
        </div>
    </div>
</div>
<script type="module" src="../js/pages/users-page.js"></script>
<script type="module" src="../js/forms/user-form.js"></script>