import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';
const API_ENDPOINTS = {
    BOOK: './book/code.php',
    BOOK_LOCATION: '../php/api/book-location-api.php',
    LIBRARY: './library/code.php',
    LOCATION: './location/code.php',
    USER: './users/code.php',
};
let urlParams;
let id;

document.addEventListener("DOMContentLoaded", async () => {

    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    id = urlParams.get("id");

    if (currentPath === '?page=book-locations') {
        await getAll();
        return;
    }

    if (id !== null) {
        update();
        return;
    }
    await utils.fetchSelect(API_ENDPOINTS.LOCATION, "cod_local", "locations");
    await utils.fetchSelect(API_ENDPOINTS.BOOK, "titulo", "book");

    create();
    return;
});


async function getAll() {

    try {
        const response = await fetch(API_ENDPOINTS.BOOK_LOCATION);
        if (!response.ok) throw new Error("Resposta inválida do servidor");

        const result = await response.json();

        showBooks(result);


        utils.initializeRowSelection(API_ENDPOINTS.BOOK_LOCATION, '?page=book-location-form');
    } catch (error) {
        console.error("Erro ao obter bibliotecas:", error);
        toastr.warning("Não foi possível carregar as bibliotecas. Tenta novamente mais tarde.", "Atenção!");
    }
}
function showBooks(books) {

    if ($.fn.DataTable.isDataTable('#zero_config')) {
        $('#zero_config').DataTable().destroy();
    }

    const tableBody = $('#zero_config tbody');
    tableBody.empty();

    books.forEach((book) => {

        tableBody.append(`
            <tr id="id-${book.livro_localizacao_fk}" class="selectable-row">
                <td>${book.biblioteca}</td>
                <td>${book.titulo}</td>
                <td>${book.cod_local}</td>
                <td>${book.quantidade}</td>
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
    console.log("Modo criação ativado. ID:", id);

    const form = document.querySelector("#bookLocationForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.newData(API_ENDPOINTS.BOOK_LOCATION, formData, form, '?page=book-locations');
    });
}

function update() {

    const form = document.querySelector("#bookLocationForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        formData.append("id", id);
        bdUtils.updateData(API_ENDPOINTS.BOOK_LOCATION, formData, form, '?page=book-locations');
    });
}
