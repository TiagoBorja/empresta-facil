<div class="container-fluid">
    <div class="row justify-content-center min-vh-100">
        <div class="col-md-10 col-lg-10 p-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4">Meu Perfil</h4>
                    <div class="row">
                        <!-- Sidebar dentro do card -->
                        <nav class="col-md-4 col-lg-3 border-end pe-0 mb-3 mb-md-0">
                            <div class="nav flex-column nav-pills" id="profile-tabs" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="profile-tab" data-bs-toggle="pill" href="#profile" role="tab">Perfil</a>
                                <a class="nav-link" id="comments-tab" data-bs-toggle="pill" href="#comments" role="tab">Últimos Comentários</a>
                                <a class="nav-link" id="reservations-tab" data-bs-toggle="pill" href="#reservations" role="tab">Reservas</a>
                                <a class="nav-link" id="loans-tab" data-bs-toggle="pill" href="#loans" role="tab">Empréstimos</a>
                                <a class="nav-link" id="settings-tab" data-bs-toggle="pill" href="#settings" role="tab">Configurações</a>
                            </div>
                        </nav>
                        <!-- Conteúdo principal das abas -->
                        <div class="col-md-8 col-lg-9 ps-md-4">
                            <div class="tab-content" id="profile-tabs-content">
                                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                    <h5 class="mb-3">Informações do Usuário</h5>
                                    <p>Aqui vão as informações do usuário.</p>
                                </div>
                                <div class="tab-pane fade" id="comments" role="tabpanel">
                                    <h5 class="mb-3">Últimos Comentários</h5>
                                    <p>Lista dos últimos comentários feitos pelo usuário.</p>
                                </div>
                                <div class="tab-pane fade" id="reservations" role="tabpanel">
                                    <h5 class="mb-3">Reservas</h5>
                                    <p>Histórico de reservas do usuário.</p>
                                </div>
                                <div class="tab-pane fade" id="loans" role="tabpanel">
                                    <h5 class="mb-3">Empréstimos</h5>
                                    <p>Histórico de empréstimos do usuário.</p>
                                </div>
                                <div class="tab-pane fade" id="settings" role="tabpanel">
                                    <h5 class="mb-3">Configurações</h5>
                                    <p>Configurações da conta do usuário.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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