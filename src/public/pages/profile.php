<div class="container-fluid">
    <div class="row justify-content-center min-vh-100 py-5">
        <div class="col-md-10 col-lg-10 p-4">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <img src="https://ui-avatars.com/api/?name=User&background=6c63ff&color=fff&size=56" class="rounded-circle shadow-sm mb-2" alt="Avatar do usuário" width="56" height="56">
                        <h4 class="card-title mb-0">Meu Perfil</h4>
                        <small class="text-muted">Bem-vindo(a) de volta!</small>
                    </div>
                    <div class="row">
                        <!-- Sidebar dentro do card -->
                        <nav class="col-md-4 col-lg-3 mb-3 mb-md-0">
                            <div class="nav flex-column nav-pills gap-2 p-0" id="profile-tabs" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active d-flex align-items-center" id="profile-tab" data-bs-toggle="pill" href="#profile" role="tab">
                                    <i class="bi bi-person-circle me-2"></i> Perfil
                                </a>
                                <a class="nav-link d-flex align-items-center" id="comments-tab" data-bs-toggle="pill" href="#comments" role="tab">
                                    <i class="bi bi-chat-left-text me-2"></i> Últimos Comentários
                                </a>
                                <a class="nav-link d-flex align-items-center" id="reservations-tab" data-bs-toggle="pill" href="#reservations" role="tab">
                                    <i class="bi bi-calendar-check me-2"></i> Reservas
                                </a>
                                <a class="nav-link d-flex align-items-center" id="loans-tab" data-bs-toggle="pill" href="#loans" role="tab">
                                    <i class="bi bi-journal-bookmark me-2"></i> Empréstimos
                                </a>
                                <a class="nav-link d-flex align-items-center" id="settings-tab" data-bs-toggle="pill" href="#settings" role="tab">
                                    <i class="bi bi-gear me-2"></i> Configurações
                                </a>
                            </div>
                        </nav>
                        <!-- Conteúdo principal das abas -->
                        <div class="col-md-8 col-lg-9 ps-md-4">
                            <div class="tab-content" id="profile-tabs-content">
                                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                    <h5 class="mb-3">Informações do Usuário</h5>
                                    <p class="text-muted">Aqui vão as informações do usuário.</p>
                                </div>
                                <div class="tab-pane fade" id="comments" role="tabpanel">
                                    <h5 class="mb-3">Últimos Comentários</h5>
                                    <p class="text-muted">Lista dos últimos comentários feitos pelo usuário.</p>
                                </div>
                                <div class="tab-pane fade" id="reservations" role="tabpanel">
                                    <h5 class="mb-3">Reservas</h5>
                                    <p class="text-muted">Histórico de reservas do usuário.</p>
                                </div>
                                <div class="tab-pane fade" id="loans" role="tabpanel">
                                    <h5 class="mb-3">Empréstimos</h5>
                                    <p class="text-muted">Histórico de empréstimos do usuário.</p>
                                </div>
                                <div class="tab-pane fade" id="settings" role="tabpanel">
                                    <h5 class="mb-3">Configurações</h5>
                                    <p class="text-muted">Configurações da conta do usuário.</p>
                                </div>
                            </div>
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
    triggerTabList.forEach(function(triggerEl) {
        triggerEl.addEventListener('click', function(event) {
            event.preventDefault();
            const tabTrigger = new bootstrap.Tab(triggerEl);
            tabTrigger.show();
        });
    });
</script>