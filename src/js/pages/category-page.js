import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';
const API_URL = '../administrative/category/code.php';
let urlParams;
let id;

document.addEventListener("DOMContentLoaded", async () => {

    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    id = urlParams.get("id");

    if (currentPath === '?page=categories') {
        await getCategories();
        return;
    }

    if (id) {
        updateCategory();
        changeActiveStatus();
        return;
    }

    newCategory();
});


async function getCategories() {

    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error("Resposta inválida do servidor");

        const result = await response.json();
        console.log(result);

        showCategories(result);

        utils.initializeRowSelection(API_URL, '?page=category-form');
    } catch (error) {
        console.error("Erro ao obter categorias:", error);
        toastr.warning("Não foi possível carregar as categorias. Tenta novamente mais tarde.", "Atenção!");
    }
}
function showCategories(categories) {
    let table = "";

    categories.forEach((category) => {
        const active = category.ativo === 'Y'
            ? '<span class="badge rounded-pill bg-success">Ativo</span>'
            : (category.ativo === 'N'
                ? '<span class="badge rounded-pill bg-danger">Inativo</span>'
                : '');

        table += `<tr id="id-${category.id}">
                  <td scope="row">${category.categoria}</td>
                  <td>${category.descricao}</td>
                  <td>${active}</td>
                  </tr>`;
    });

    const tableBody = document.getElementById("tbody");
    tableBody.innerHTML = table;
}


function newCategory() {
    const form = document.querySelector("#categoryForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.newData(API_URL, formData, form, '?page=categories');
    });
}

function updateCategory() {

    const form = document.querySelector("#categoryForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.updateData(API_URL, formData, form, '?page=categories');
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
