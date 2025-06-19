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
        document.getElementById("stateReturnDiv").classList.add("d-none");
        document.getElementById("loanStatusDiv").classList.add("d-none");
        showReservationForm();
        return;
    }

    if (id) {
        showLoanForm();
        return;
    }

});

async function showReservationForm() {
    try {
        const [reservationResponse, loanResponse] = await Promise.all([
            fetch(`${API_ENDPOINTS.RESERVATION}?id=${reservationId}`),
            fetch(`${API_ENDPOINTS.LOAN}?reservationId=${reservationId}`),
        ]);

        if (!reservationResponse.ok || !loanResponse.ok) {
            throw new Error("Erro na requisição");
        }

        const reservation = await reservationResponse.json();
        const loan = await loanResponse.json();


        if (reservation.status === 200) {

            const reservationValue = reservation.data;

            document.getElementById("icon").classList.remove("mdi-map-marker");
            document.getElementById("icon").classList.add("mdi-book-open-page-variant");
            document.getElementById("bookToLoan").textContent = `Reserva de ${reservationValue.nome_completo} - "${reservationValue.titulo}"`;
            document.getElementById("reservationId").value = reservationValue.id;

            await utils.fetchSelect(API_ENDPOINTS.USER, "primeiro_nome ultimo_nome", "user", reservationValue.utilizador_fk, true);
            await utils.fetchSelect(API_ENDPOINTS.BOOK, "titulo", "book", reservationValue.livro_fk, true);

            await utils.fetchSelect(`${API_ENDPOINTS.STATE}?type=LIVRO`, "estado", "state_pickup");
        }
    } catch (error) {
        toastr.error(error, "Erro!");
    }
}

async function showLoanForm() {
    try {
        const loanResponse = await fetch(`${API_ENDPOINTS.LOAN}?id=${id}`);
        console.log(loanResponse);
    } catch (error) {
        toastr.error(error, "Erro!");
    }
}

