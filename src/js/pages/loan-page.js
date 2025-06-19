import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';

const API_ENDPOINTS = {
    LOAN: '../php/api/loan-api.php',
    RESERVATION: '../php/api/book-reservation-api.php',
    STATE: './state/code.php',
    USER: './users/code.php',
    BOOK: './book/code.php',
};

let urlParams;
let id;
let reservationId;

document.addEventListener("DOMContentLoaded", async () => {
    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    id = urlParams.get("id");
    reservationId = urlParams.get("reservationId");

    if (currentPath === '?page=loans') {
        await getAll();
        return;
    }

    if (id) {
        update();
        return;
    }

    await utils.fetchSelect(API_ENDPOINTS.USER, "primeiro_nome ultimo_nome", "user");
    await utils.fetchSelect(`${API_ENDPOINTS.STATE}?type=LIVRO`, "estado", "state_pickup");

    create();
    return;
});

async function getAll() {

    try {
        const [loanResponse] = await Promise.all([
            fetch(API_ENDPOINTS.LOAN),
        ]);

        if (!loanResponse.ok) {
            throw new Error("Erro na requisição");
        }

        const loan = await loanResponse.json();
        showLoan(loan);

        utils.initializeRowSelection(API_ENDPOINTS.LOAN, '?page=loan-form');
    } catch (error) {
        console.error("Erro ao obter empréstimos:", error);
        toastr.warning("Não foi possível carregar os empréstimos. Tenta novamente mais tarde.", "Atenção!");
    }
}
function showLoan(loans) {

    if ($.fn.DataTable.isDataTable('#zero_config')) {
        $('#zero_config').DataTable().destroy();
    }

    const tableBody = $('#zero_config tbody');
    tableBody.empty();

    loans.forEach((loan) => {

        let state = '';

        switch (loan.estado_emprestimo) {
            case 'EM ANDAMENTO':
                state = '<span class="badge rounded-pill bg-warning">Em Andamento</span>';
                break;
            case 'CONCLUIDO':
                state = '<span class="badge rounded-pill bg-success">Concluído</span>';
                break;
            case 'CANCELADO':
                state = '<span class="badge rounded-pill bg-secondary">Cancelado</span>';
                break;
            case 'ATRASADO':
                state = '<span class="badge rounded-pill bg-danger">Atrasado</span>';
                break;
        }
        tableBody.append(`
            <tr id="id-${loan.id}" class="selectable-row">
                <td class="text-truncate">${loan.utilizador}</td>
                <td class="text-truncate">${loan.titulo}</td>
                <td class="text-truncate">${utils.formatDate(loan.data_emprestimo)}</td>
                <td class="text-truncate">${utils.formatDate(loan.data_devolucao)}</td>
                <td class="text-truncate">${utils.formatDate(loan.data_devolucao)}</td>
                <td class="text-truncate text-center">${state}</td>
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
    const form = document.querySelector("#loanForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.newData(API_ENDPOINTS.LOAN, formData, form, '?page=loans');
    });
}

function update() {

    const form = document.querySelector("#loanForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        formData.append("id", id);
        bdUtils.updateData(API_ENDPOINTS.LOAN, formData, form, '?page=loans');
    });
}