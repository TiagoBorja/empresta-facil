<div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow rounded-4 border-0">
            <form id="validationForm">
                <div class="modal-header bg-primary text-white rounded-top-4">
                    <h5 class="modal-title" id="validationModalLabel">
                        <i class="mdi mdi-account-check-outline me-2"></i> Validação de Utilizador
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Introduza o código que o utilizador recebeu por email para concluir a
                        validação.</p>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="mdi mdi-email-outline me-1"></i> Email do utilizador:
                        </label>
                        <div class="form-control-plaintext ps-2" id="userEmailDisplay">Email não disponível</div>
                        <input type="hidden" id="userIdInput" name="userIdInput">
                    </div>

                    <div class="mb-3">
                        <label for="validationCodeInput" class="form-label fw-semibold">
                            <i class="mdi mdi-key-outline me-1"></i> Código de validação
                        </label>
                        <input type="text" class="form-control border-primary" id="validationCodeInput"
                            name="validationCodeInput" placeholder="Introduza o código aqui" required>
                        <div class="invalid-feedback">
                            Por favor, introduza um código válido.
                        </div>
                    </div>

                    <div id="validationMessage" class="alert alert-danger py-2 px-3 mt-3 d-none" role="alert"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success text-white">
                        <i class="mdi mdi-check-bold me-1"></i> Validar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>