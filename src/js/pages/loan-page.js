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
    await utils.fetchSelect(`${API_ENDPOINTS.STATE}?type=LIVRO`, "estado", "statePickUp");

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

        const loans = await loanResponse.json();

        showLoan(loans);
    } catch (error) {
        console.error("Erro ao obter empréstimos:", error);
        toastr.warning("Não foi possível carregar os empréstimos. Tente novamente mais tarde.", "Atenção!");
    }
}
function showLoan(loans) {

    const table = $('#zero_config').DataTable();
    if (table) {
        table.destroy();
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
        const today = new Date();
        const dataDevolucao = new Date(loan.data_devolucao);
        const dataDevolvido = loan.data_devolvido ? new Date(loan.data_devolvido) : null;

        let rowClass = ''; // classe da linha

        if (!dataDevolvido && loan.estado_emprestimo === 'EM ANDAMENTO') {
            const diffTime = dataDevolucao.getTime() - today.getTime();
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays < 0) {
                rowClass = 'table-danger'; // devolução atrasada
            } else if (diffDays <= 3) {
                rowClass = 'table-warning'; // devolução iminente
            }
        }

        tableBody.append(`
            <tr id="id-${loan.id}" class="selectable-row ${rowClass}" data-bookid="${loan.livro_localizacao_fk}">
                <td class="text-truncate">${loan.utilizador}</td>
                <td class="text-truncate">${loan.titulo}</td>
                <td class="text-truncate">${utils.formatDate(loan.criado_em)}</td>
                <td class="text-truncate">${utils.formatDate(loan.data_devolucao)}</td>
                <td class="text-truncate">${utils.formatDate(loan.data_devolvido)}</td>
                <td class="text-truncate text-center">${state}</td>
            </tr>
`);


    });

    $('#zero_config').DataTable({
        ordering: false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese.json'
        },
        destroy: true,
        initComplete: function () {
            utils.onSelectLoan(
                API_ENDPOINTS.LOAN,
                '?page=loan-form'
            );
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
        bdUtils.updateData(API_ENDPOINTS.LOAN, formData, form, '?page=loans');
    });
}