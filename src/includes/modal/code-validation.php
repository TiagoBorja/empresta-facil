<div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="validationForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="validationModalLabel">Validar Código</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Por favor, insira o código recebido por email para validar sua conta.</p>
                    <input type="hidden" id="userIdInput" name="userIdInput" value="">
                    <div class="mb-3">
                        <label for="validationCodeInput" class="form-label">Código de validação</label>
                        <input type="text" class="form-control" id="validationCodeInput" name="validationCodeInput"
                            placeholder="Insira o código" required>
                        <div class="invalid-feedback">
                            Por favor, insira um código válido.
                        </div>
                    </div>
                    <div id="validationMessage" class="text-danger" style="display:none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Validar</button>
                </div>
            </form>
        </div>
    </div>
</div>