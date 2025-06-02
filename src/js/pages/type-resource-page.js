import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';
const API_URL = '../administrative/type-resource/code.php';
let urlParams;
let id;

document.addEventListener("DOMContentLoaded", async () => {

    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    id = urlParams.get("id");

    if (currentPath === '?page=type-resources') {
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

        showSubtegories(result);

        utils.initializeRowSelection(API_URL, '?page=type-resource-form');
    } catch (error) {
        console.error("Erro ao obter categorias:", error);
        toastr.warning("Não foi possível carregar as categorias. Tenta novamente mais tarde.", "Atenção!");
    }
}
function showSubtegories(typeResources) {
    let table = "";

    typeResources.forEach((typeResource) => {
        const active = typeResource.ativo === 'Y'
            ? '<span class="badge rounded-pill bg-success">Ativo</span>'
            : (typeResource.ativo === 'N'
                ? '<span class="badge rounded-pill bg-danger">Inativo</span>'
                : '');

        table += `<tr id="id-${typeResource.id}">
                  <td scope="row">${typeResource.tipo}</td>
                  <td scope="row">${typeResource.descricao}</td>
                  <td>${active}</td>
                  </tr>`;
    });

    const tableBody = document.getElementById("tbody");
    tableBody.innerHTML = table;
}


function create() {
    const form = document.querySelector("#typeResourceForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.newData(API_URL, formData, form, '?page=type-resources');
    });
}

function update() {
    console.log("Função update foi chamada");

    const form = document.querySelector("#typeResourceForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();
        console.log("Formulário submetido, preventDefault aplicado");

        const formData = new FormData(this);
        formData.append("saveData", true);
        formData.append("id", id);
        bdUtils.updateData(API_URL, formData, form, '?page=type-resources');
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
