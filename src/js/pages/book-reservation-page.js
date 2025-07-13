import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';

const API_ENDPOINTS = {
    RESERVATION: '../php/api/book-reservation-api.php',
    LOAN: '../php/api/loan-api.php',
};

let urlParams;
let id;

document.addEventListener("DOMContentLoaded", async () => {

    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    id = urlParams.get("id");

    if (currentPath === '?page=book-reservations') {
        await getAll();
        return;
    }

    if (id) {
        update();
        return;
    }


    create();
    return;
});

async function getAll() {

    try {
        const [reservationResponse] = await Promise.all([
            fetch(API_ENDPOINTS.RESERVATION),
        ]);

        if (!reservationResponse.ok) {
            throw new Error("Erro na requisição");
        }

        const reservation = await reservationResponse.json();

        showReservation(reservation);

        utils.initializeRowSelection(API_ENDPOINTS.LOAN, '?page=loan-form', 'reservationId');
    } catch (error) {
        console.error("Erro ao obter bibliotecas:", error);
        toastr.warning("Não foi possível carregar as bibliotecas. Tenta novamente mais tarde.", "Atenção!");
    }
}
function showReservation(reservations) {

    if ($.fn.DataTable.isDataTable('#zero_config')) {
        $('#zero_config').DataTable().destroy();
    }

    const tableBody = $('#zero_config tbody');
    tableBody.empty();

    reservations.forEach((reservation) => {

        let state = '';

        switch (reservation.estado_reserva) {
            case 'EM ANDAMENTO':
                state = '<span class="badge rounded-pill bg-warning">Em andamento</span>';
                break;
            case 'CONCLUIDA':
                state = '<span class="badge rounded-pill bg-success">Concluída</span>';
                break;
            case 'EXPIRADA':
                state = '<span class="badge rounded-pill bg-secondary">Expirada</span>';
                break;
            case 'CANCELADA':
                state = '<span class="badge rounded-pill bg-danger">Cancelada</span>';
                break;
        }
        tableBody.append(`
            <tr id="id-${reservation.id}" class="selectable-row">
                <td class="text-truncate">${reservation.nome_completo}</td>
                <td class="text-truncate">${reservation.titulo}</td>
                <td class="text-truncate">${utils.formatDate(reservation.criado_em)}</td>
                <td class="text-truncate">${utils.formatDate(reservation.data_levantamento)}</td>
                <td class="text-truncate">${utils.formatDate(reservation.data_expiracao)}</td>
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
    const form = document.querySelector("#libraryForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.newData(API_ENDPOINTS.EMPLOYEE, formData, form, '?page=book-reservations');
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
        bdUtils.updateData(API_ENDPOINTS.EMPLOYEE, formData, form, '?page=book-reservations');
    });
}
