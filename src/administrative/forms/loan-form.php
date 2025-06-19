<a class="text-info" href="?page=book-reservations">
    <i class="mdi mdi-undo"></i>
    Voltar
</a>
<div class="card mt-2">
    <div class="card-header">
        <h4 class="card-title mb-0">
            <i id="icon" class="mdi mdi-book-open-page-variant"></i>
            <span id="bookToLoan" class="hide-menu">Empréstimo</span>
        </h4>
    </div>
    <div class="card-body">
        <form id="loanForm">
            <input type="hidden" name="reservationId" id="reservationId">
            <input type="hidden" name="loanId" id="loanId">
            <h5 class="mb-3">Informações da Reserva</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select name="user" id="user" class="form-select" required>
                            <option selected disabled>Selecione</option>
                        </select>
                        <label for="user">Escolha o Utilizador</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select name="book" id="book" class="form-select" required>
                            <option selected disabled>Selecione</option>
                        </select>
                        <label for="book">Escolha o Livro</label>
                    </div>
                </div>
            </div>

            <h5 class="mt-4 mb-3">Estados</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <select name="state_pickup" id="state_pickup" class="form-select" required>
                            <option selected disabled>Selecione</option>
                        </select>
                        <label for="state_pickup">Estado ao Levantar</label>
                    </div>
                </div>

                <div id="stateReturnDiv" class="col-md-4">
                    <div class="form-floating mb-3">
                        <select name="state_return" id="state_return" class="form-select" required>
                            <option selected disabled>Selecione</option>
                        </select>
                        <label for="state_return">Estado ao Devolver</label>
                    </div>
                </div>

                <div id="loanStatusDiv" class="col-md-4">
                    <div class="form-floating mb-3">
                        <select name="loan_status" id="loan_status" class="form-select" required>
                            <option selected disabled>Selecione</option>
                        </select>
                        <label for="loan_status">Estado do Empréstimo</label>
                    </div>
                </div>
            </div>

            <h5 class="mt-4 mb-3">Datas</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="date" name="return_date" id="return_date" class="form-control" required>
                        <label for="return_date">Data de Devolução</label>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="text-center">
                    <button name="saveData" type="submit"
                        class="btn btn-success text-white rounded-0 d-inline-flex align-items-center">
                        <i class="mdi mdi-content-save d-flex align-items-center align-text-icon"></i>
                        <span class="ms-1">Guardar</span>
                    </button>
                    <button id="clear" type="button"
                        class="btn btn-primary text-white rounded-0 d-inline-flex align-items-center">
                        <i class="mdi mdi-refresh d-flex align-items-center align-text-icon"></i>
                        <span class="ms-1">Limpar</span>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script type="module" src="../js/pages/loan-page.js"></script>
<script type="module" src="../js/forms/loan-form.js"></script>