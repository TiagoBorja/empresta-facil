import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';
const API_URL = '../administrative/library/code.php';
let urlParams;
let id;

document.addEventListener("DOMContentLoaded", async () => {

    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    id = urlParams.get("id");

    if (currentPath === '?page=libraries') {
        await getAll();
        return;
    }

    if (id) {
        update();
        changeActiveStatus();
        return;
    }

    create();
    return;


});


async function getAll() {

    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error("Resposta inválida do servidor");

        const result = await response.json();

        showLibraries(result);

        utils.initializeRowSelection(API_URL, '?page=library-form');
    } catch (error) {
        console.error("Erro ao obter bibliotecas:", error);
        toastr.warning("Não foi possível carregar as bibliotecas. Tenta novamente mais tarde.", "Atenção!");
    }
}
function showLibraries(libraries) {
    let table = "";

    libraries.forEach((library) => {
        const active = library.ativo === 'Y'
            ? '<span class="badge rounded-pill bg-success">Ativo</span>'
            : (library.ativo === 'N'
                ? '<span class="badge rounded-pill bg-danger">Inativo</span>'
                : '');

        table += `<tr id="id-${library.id}">
                  <td scope="row">${library.nome}</td>
                  <td scope="row">${library.morada}</td>
                  <td scope="row">${library.cod_postal}</td>
                  <td>${active}</td>
                  </tr>`;
    });

    const tableBody = document.getElementById("tbody");
    tableBody.innerHTML = table;
}


function create() {
    const form = document.querySelector("#libraryForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.newData(API_URL, formData, form, '?page=libraries');
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
        bdUtils.updateData(API_URL, formData, form, '?page=libraries');
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
