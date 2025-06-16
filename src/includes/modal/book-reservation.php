<div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-danger shadow">
            <div class="modal-header bg-danger text-white">
                <h1 class="modal-title fs-5" id="reservationTitle">Reservar - </h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="reservationForm">
                <div class="modal-body bg-light">
                    <input id="bookId" type="hidden">
                    <div class="mb-3">
                        <label for="librarySelect" class="form-label text-danger">Biblioteca</label>
                        <select class="form-select border-danger" id="librarySelect" name="library">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pickUpDate" class="form-label text-danger">Data de Levantamento</label>
                        <input type="date" class="form-control border-danger" id="pickUpDate" name="pickUpDate">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button id="reservationSubmit" class="btn btn-outline-success w-100 py-2">
                        <i class="bi bi-check-circle me-2"></i> Concluir Reserva
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>