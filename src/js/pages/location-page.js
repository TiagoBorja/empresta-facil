import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';
const API_URL = '../administrative/location/code.php';
const LIBRARY_API_URL = '../administrative/library/code.php';
let urlParams;
let id;

document.addEventListener("DOMContentLoaded", async () => {

    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    id = urlParams.get("id");

    if (currentPath === '?page=locations') {
        await getAll();
        return;
    }

    if (id) {
        update();
        changeActiveStatus();
        return;
    }

    await utils.fetchSelect(LIBRARY_API_URL, "nome", "library");
    create();
    return;


});


async function getAll() {

    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error("Resposta inválida do servidor");

        const result = await response.json();

        showLocations(result);

        utils.initializeRowSelection(API_URL, '?page=location-form');
    } catch (error) {
        console.error("Erro ao obter bibliotecas:", error);
        toastr.warning("Não foi possível carregar as bibliotecas. Tenta novamente mais tarde.", "Atenção!");
    }
}
function showLocations(locations) {

    if ($.fn.DataTable.isDataTable('#zero_config')) {
        $('#zero_config').DataTable().destroy();
    }

    const tableBody = $('#zero_config tbody');
    tableBody.empty();

    locations.forEach((location) => {
        const active = location.ativo === 'Y'
            ? '<span class="badge rounded-pill bg-success">Ativo</span>'
            : (location.ativo === 'N'
                ? '<span class="badge rounded-pill bg-danger">Inativo</span>'
                : '');

        tableBody.append(`
            <tr id="id-${location.id}" class="selectable-row">
                <td>${location.cod_local}</td>
                <td>${location.nome}</td>
                <td>${active}</td>
            </tr>`
        );
    });

    $('#zero_config').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese.json'
        }
    });
}


function create() {
    const form = document.querySelector("#libraryForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.newData(API_URL, formData, form, '?page=locations');
    });
}

function update() {

    const form = document.querySelector("#libraryForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        formData.append("id", id);
        bdUtils.updateData(API_URL, formData, form, '?page=locations');
    });
}

function changeActiveStatus() {
    const form = document.querySelector("#changeStatus");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const activeBadge = document.getElementById("active");
        const currentStatus = activeBadge.textContent === "Ativo" ? "Y" : "N";

        const formData = new FormData(this);
        formData.append("changeStatus", true);
        formData.append("id", id);
        formData.append("active", currentStatus);

        bdUtils.changeActiveStatus(API_URL, formData, activeBadge, currentStatus)
    });
}
