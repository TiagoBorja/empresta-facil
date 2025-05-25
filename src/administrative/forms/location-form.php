<div class="row justify-content-center">
    <div class="col-md-12 me-3">

        <a class="text-info" href="?page=locations">
            <i class="mdi mdi-undo"></i>
            Voltar
        </a>

        <div class="card mt-3">
            <div class="card-header">
                <form id="changeStatus">
                    <h4 class="card-title">
                        <i class="mdi mdi-library"></i>
                        <span id="locationName" class="hide-menu">Códigos de Localização</span>
                        <button id="active" class="float-end badge rounded-pill bg-success"></button>
                    </h4>
                </form>
            </div>
            <form id="libraryForm">
                <div class="card-body">
                    <div class="mb-3">
                        <input type="hidden" id="id" name="id" class="form-control" readonly>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" id="locationCode" name="locationCode" class="form-control"
                            placeholder="Código da Localização">
                        <label for="name">Código da Localização</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select name="library" id="library" class="form-select">
                        </select>
                        <label for="library">Escolha a Biblioteca</label>
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
</div>

<script type="module" src="../js/pages/location-page.js"></script>
<script type="module" src="../js/forms/location-form.js"></script>