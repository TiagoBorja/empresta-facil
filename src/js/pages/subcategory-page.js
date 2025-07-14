import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';
const API_URL = '../administrative/subcategory/code.php';
const CATEGORIES_API_URL = '../administrative/category/code.php';
let urlParams;
let id;

document.addEventListener("DOMContentLoaded", async () => {

    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    id = urlParams.get("id");

    if (currentPath === '?page=subcategories') {
        await getAll();
        return;
    }

    if (id) {
        updateSubcategory();
        changeActiveStatus();
        return;
    }

    await utils.fetchSelect(CATEGORIES_API_URL, "categoria", "category");
    newSubcategory();
    return;


});


async function getAll() {

    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error("Resposta inválida do servidor");

        const result = await response.json();

        showSubcategories(result);

        utils.initializeRowSelection(API_URL, '?page=subcategory-form');
    } catch (error) {
        console.error("Erro ao obter categorias:", error);
        toastr.warning("Não foi possível carregar as categorias. Tenta novamente mais tarde.", "Atenção!");
    }
}

function showSubcategories(subcategories) {
    if ($.fn.DataTable.isDataTable('#zero_config')) {
        $('#zero_config').DataTable().destroy();
    }

    const tableBody = $('#tbody');
    tableBody.empty();

    subcategories.forEach((subcategory) => {
        const active = subcategory.ativo === 'Y'
            ? '<span class="badge rounded-pill bg-success">Ativo</span>'
            : (subcategory.ativo === 'N'
                ? '<span class="badge rounded-pill bg-danger">Inativo</span>'
                : '');

        tableBody.append(`
            <tr id="id-${subcategory.id}">
                <td scope="row">${subcategory.categoria}</td>
                <td scope="row">${subcategory.subcategoria}</td>
                <td scope="row">${subcategory.descricao}</td>
                <td>${active}</td>
            </tr>
        `);
    });

    $('#zero_config').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese.json'
        }
    });
}




function newSubcategory() {
    const form = document.querySelector("#subcategoryForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.newData(API_URL, formData, form, '?page=subcategories');
    });
}

function updateSubcategory() {
    console.log("Função updateSubcategory foi chamada");

    const form = document.querySelector("#subcategoryForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();
        console.log("Formulário submetido, preventDefault aplicado");

        const formData = new FormData(this);
        formData.append("saveData", true);
        formData.append("id", id);
        bdUtils.updateData(API_URL, formData, form, '?page=subcategories');
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
