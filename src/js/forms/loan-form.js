import * as utils from '../utils/utils.js';

const API_ENDPOINTS = {
    LOAN: '../php/api/loan-api.php',
    RESERVATION: '../php/api/book-reservation-api.php',
    STATE: './state/code.php',
    USER: './users/code.php',
    BOOK: './book/code.php',
};

let urlParams = new URLSearchParams(window.location.search);
let id = urlParams.get("id");
let reservationId = urlParams.get("reservationId");

document.addEventListener('DOMContentLoaded', async function () {

    if (reservationId) {
        showReservationForm();
        return;
    }

    if (id) {
        //showLoanForm();
        return;
    }

});

async function showReservationForm() {
    try {
        const [reservationResponse] = await Promise.all([
            fetch(`${API_ENDPOINTS.RESERVATION}?id=${reservationId}`),
        ]);

        if (!reservationResponse.ok) {
            throw new Error("Erro na requisição");
        }

        const reservation = await reservationResponse.json();

        if (reservation.status === 200) {

            const reservationValue = reservation.data;

            document.getElementById("bookToLoan").textContent = `Reserva de ${reservationValue.nome_completo} - "${reservationValue.titulo}"`;
            document.getElementById("id").value = reservationValue.id;

            await utils.fetchSelect(API_ENDPOINTS.USER, "primeiro_nome ultimo_nome", "user", reservationValue.utilizador_fk, true);

            await utils.fetchSelect(API_ENDPOINTS.BOOK, "titulo", "book", reservationValue.livro_fk, true);


            await utils.fetchSelect(API_ENDPOINTS.STATE, "estado", "state_pickup");
            await utils.fetchSelect(API_ENDPOINTS.STATE, "estado", "state_return");
            await utils.fetchSelect(API_ENDPOINTS.STATE, "estado", "loan_status");
        }
    } catch (error) {
        toastr.error(error, "Erro!");
    }
}


