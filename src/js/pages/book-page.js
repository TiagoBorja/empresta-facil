import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';

const BASE_API_URL = '../administrative/book/code.php';
const PUBLISHER_API_URL = '../administrative/publisher/code.php?activeOnly=true';
const CATEGORY_API_URL = '../administrative/category/code.php?activeOnly=true';
const SUBCATEGORY_API_URL = '../administrative/subcategory/code.php?activeOnly=true';

let urlParams;
let id;

document.addEventListener("DOMContentLoaded", async () => {

    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    id = urlParams.get("id");

    if (currentPath === '?page=books') {
        await getAll();
        return;
    }

    if (id) {
        update();
        changeActiveStatus();
        return;
    }

    await utils.fetchSelect(PUBLISHER_API_URL, 'editora', "publisher");
    await utils.fetchSelect(CATEGORY_API_URL, 'categoria', "category");
    await utils.fetchSelect(SUBCATEGORY_API_URL, 'subcategoria', "subcategory");

    create();
    return;


});


async function getAll() {

    try {
        const response = await fetch(BASE_API_URL);
        if (!response.ok) throw new Error("Resposta inválida do servidor");

        const result = await response.json();

        showBooks(result);

        utils.initializeRowSelection(BASE_API_URL, '?page=book-form');
    } catch (error) {
        console.error("Erro ao obter categorias:", error);
        toastr.warning("Não foi possível carregar as categorias. Tenta novamente mais tarde.", "Atenção!");
    }
}

function showBooks(books) {

    if ($.fn.DataTable.isDataTable('#zero_config')) {
        $('#zero_config').DataTable().destroy();
    }

    const tableBody = $('#zero_config tbody');
    tableBody.empty();

    books.forEach((book) => {
        const active = book.ativo === 'Y'
            ? '<span class="badge rounded-pill bg-success">Ativo</span>'
            : (book.ativo === 'N'
                ? '<span class="badge rounded-pill bg-danger">Inativo</span>'
                : '');

        tableBody.append(`
            <tr id="id-${book.id}" class="selectable-row">
                <td>${book.titulo}</td>
                <td>${book.categoria}</td>
                <td>${book.subcategoria}</td>
                <td>${book.ano_lancamento}</td>
                <td>${book.idioma}</td>
                <td>${book.quantidade}</td>
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
    const form = document.querySelector("#bookForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.newData(BASE_API_URL, formData, form, '?page=books');
    });
}

function update() {

    const form = document.querySelector("#bookForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();
        console.log("Formulário submetido, preventDefault aplicado");

        const formData = new FormData(this);
        formData.append("saveData", true);
        formData.append("id", id);
        bdUtils.updateData(BASE_API_URL, formData, form, '?page=books');
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

        bdUtils.changeActiveStatus(BASE_API_URL, formData, activeBadge, currentStatus)
    });
}
