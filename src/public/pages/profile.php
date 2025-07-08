<div class="container-fluid">
    <div class="row justify-content-center min-vh-100 py-5">
        <div class="col-md-10 col-lg-10 p-4">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <img src="../administrative/users/upload/<?php echo $_SESSION['user']['img_url']; ?>"
                            class="rounded-circle shadow-sm mb-2" alt="Avatar do utilizador" width="56" height="56">

                        <h4 class="card-title mb-0">Meu Perfil</h4>
                        <small class="text-muted">Bem-vindo(a) de volta!</small>
                    </div>
                    <div class="row">
                        <!-- Sidebar dentro do card -->
                        <nav class="col-md-4 col-lg-3 mb-3 mb-md-0">
                            <div class="nav flex-column nav-pills gap-2 p-0" id="profile-tabs" role="tablist"
                                aria-orientation="vertical">
                                <a class="nav-link active d-flex align-items-center" id="profile-tab"
                                    data-bs-toggle="pill" href="#profile" role="tab">
                                    <i class="bi bi-person-circle me-2"></i> Perfil
                                </a>
                                <a class="nav-link d-flex align-items-center" id="comments-tab" data-bs-toggle="pill"
                                    href="#comments" role="tab">
                                    <i class="bi bi-chat-left-text me-2"></i> Últimos Comentários
                                </a>
                                <a class="nav-link d-flex align-items-center" id="reservations-tab"
                                    data-bs-toggle="pill" href="#reservations" role="tab">
                                    <i class="bi bi-calendar-check me-2"></i> Reservas
                                </a>
                                <a class="nav-link d-flex align-items-center" id="loans-tab" data-bs-toggle="pill"
                                    href="#loans" role="tab">
                                    <i class="bi bi-journal-bookmark me-2"></i> Empréstimos
                                </a>
                                <a class="nav-link d-flex align-items-center" id="settings-tab" data-bs-toggle="pill"
                                    href="#settings" role="tab">
                                    <i class="bi bi-gear me-2"></i> Configurações
                                </a>
                            </div>
                        </nav>
                        <!-- Conteúdo principal das abas -->
                        <div class="col-md-8 col-lg-9 ps-md-4">
                            <div class="tab-content" id="profile-tabs-content">
                                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                    <h5 class="mb-3">Informações do utilizador</h5>
                                    <form class="mb-3">
                                        <input type="hidden" id="userId" value="<?php echo $_SESSION['user']['id']; ?>">

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Primeiro Nome</label>
                                                <input type="text" id="firstName" class="form-control" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Último Nome</label>
                                                <input type="text" id="lastName" class="form-control" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Data de Nascimento</label>
                                                <input type="date" id="birthDate" class="form-control" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">NIF</label>
                                                <input type="text" id="nif" class="form-control" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Cartão de Cidadão (CC)</label>
                                                <input type="text" id="citizenCard" class="form-control" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Telemóvel</label>
                                                <input type="text" id="phone" class="form-control" readonly>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label">Morada</label>
                                                <textarea id="address" class="form-control" rows="2"
                                                    readonly></textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Nome de Utilizador</label>
                                                <input type="text" id="username" class="form-control" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">E-mail</label>
                                                <input type="email" id="email" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="comments" role="tabpanel">
                                    <h5 class="mb-3">Últimos Comentários</h5>
                                    <ul class="list-group mb-4">
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="reservations" role="tabpanel">
                                    <h5 class="mb-3">Reservas</h5>
                                    <table class="table table-bordered mb-4">
                                        <thead>
                                            <tr>
                                                <th>Livro</th>
                                                <th>Data da Reserva</th>
                                                <th>Data de Levantamento</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="loans" role="tabpanel">
                                    <h5 class="mb-3">Empréstimos</h5>
                                    <table class="table table-bordered mb-4">
                                        <thead>
                                            <tr>
                                                <th>Livro</th>
                                                <th>Data de Empréstimo</th>
                                                <th>Data de Devolução</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="settings" role="tabpanel">
                                    <h5 class="mb-3">Configurações</h5>
                                    <form class="mb-3" id="settingsForm">
                                        <input type="hidden" id="settingsUserId" value="<?php echo $_SESSION['user']['id']; ?>">

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Primeiro Nome</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="settingsFirstName"
                                                        disabled>
                                                    <span class="input-group-text bg-white border-start-0"
                                                        style="cursor:pointer;"
                                                        onclick="toggleField('settingsFirstName', this)">
                                                        <i class="bi bi-pencil small text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Último Nome</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="settingsLastName"
                                                        disabled>
                                                    <span class="input-group-text bg-white border-start-0"
                                                        style="cursor:pointer;"
                                                        onclick="toggleField('settingsLastName', this)">
                                                        <i class="bi bi-pencil small text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Telemóvel</label>
                                                <div class="input-group">
                                                    <input type="tel" class="form-control" id="settingsPhone" disabled>
                                                    <span class="input-group-text bg-white border-start-0"
                                                        style="cursor:pointer;"
                                                        onclick="toggleField('settingsPhone', this)">
                                                        <i class="bi bi-pencil small text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div id="libraryDropdownDiv" class="col-md-6">
                                                <label for="librariesDropdown" class="form-label">Biblioteca(s)</label>
                                                <div class="input-group">
                                                    <button class="form-select text-start ps-3 pe-5 position-relative"
                                                        type="button" id="librariesDropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <span id="selectedLibrariesText"
                                                            class="text-truncate">Selecionar Biblioteca</span>
                                                    </button>

                                                    <div id="librariesCheckboxes" class="dropdown-menu p-3 w-100"
                                                        aria-labelledby="librariesDropdown">
                                                        <input type="text" name="searchInput" id="searchInput"
                                                            placeholder="Nome" disabled>
                                                    </div>

                                                    <span class="input-group-text bg-white border-start-0"
                                                        style="cursor:pointer;"
                                                        onclick="toggleField('libraryDropdownDiv', this)">
                                                        <i class="bi bi-pencil small text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label">Morada</label>
                                                <div class="input-group">
                                                    <textarea class="form-control" id="settingsAddress" rows="2"
                                                        disabled></textarea>
                                                    <span
                                                        class="input-group-text bg-white border-start-0 align-items-start"
                                                        style="cursor:pointer;"
                                                        onclick="toggleField('settingsAddress', this)">
                                                        <i class="bi bi-pencil small text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Nome de Utilizador</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="settingsUsername"
                                                        disabled>
                                                    <span class="input-group-text bg-white border-start-0"
                                                        style="cursor:pointer;"
                                                        onclick="toggleField('settingsUsername', this)">
                                                        <i class="bi bi-pencil small text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">E-mail</label>
                                                <div class="input-group">
                                                    <input type="email" class="form-control" id="settingsEmail"
                                                        disabled>
                                                    <span class="input-group-text bg-white border-start-0"
                                                        style="cursor:pointer;"
                                                        onclick="toggleField('settingsEmail', this)">
                                                        <i class="bi bi-pencil small text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2 mt-4">
                                <button type="submit" class="btn btn-primary" disabled id="settingsSave">Guardar
                                    Alterações</button>
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                    data-bs-target="#changePasswordModal">
                                    Alterar Senha
                                </button>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Necessário para funcionamento das abas Bootstrap 5 e Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script>
    const triggerTabList = [].slice.call(document.querySelectorAll('[data-bs-toggle="pill"]'));
    triggerTabList.forEach(function (triggerEl) {
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault();
            const tabTrigger = new bootstrap.Tab(triggerEl);
            tabTrigger.show();
        });
    });
</script>

<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="changePasswordModalLabel">
                    <i class="bi bi-shield-lock me-2 text-primary"></i>Alterar Senha
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body pt-0">
                <p class="text-muted mb-4">Por favor, preencha os campos abaixo para alterar sua senha com segurança.
                </p>
                <form>
                    <div class="form-floating mb-3 position-relative">
                        <input type="password" class="form-control ps-5" id="currentPassword" placeholder="Senha Atual"
                            required>
                        <label for="currentPassword">Senha Atual</label>
                    </div>
                    <div class="form-floating mb-3 position-relative">
                        <input type="password" class="form-control ps-5" id="newPassword" placeholder="Nova Senha"
                            required>
                        <label for="newPassword">Nova Senha</label>
                    </div>
                    <div class="form-floating mb-3 position-relative">
                        <input type="password" class="form-control ps-5" id="confirmPassword"
                            placeholder="Confirmar Nova Senha" required>
                        <label for="confirmPassword">Confirmar Nova Senha</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"><i class="bi bi-save me-1"></i>Guardar alterações</button>
            </div>
        </div>
    </div>
</div>
<script type="module" src="../js/public-pages/profile-page.js"></script>