import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';

const API_ENDPOINTS = {
    LOAN: '../php/api/loan-api.php',
    RESERVATION: '../php/api/book-reservation-api.php',
    LIBRARY: './library/code.php',
    USER: './users/code.php',
};

let urlParams;
let id;
let reservationId;

document.addEventListener("DOMContentLoaded", async () => {

    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    id = urlParams.get("id");
    reservationId = urlParams.get("reservationId");

    if (id) {
        update();
        return;
    }

    await utils.fetchSelect(API_ENDPOINTS.USER, "primeiro_nome ultimo_nome", "user");

    create();
    return;
});


function create() {
    const form = document.querySelector("#loanForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.newData(API_ENDPOINTS.LOAN, formData, form, '?page=book-reservations');
    });
}

function update() {

    const form = document.querySelector("#employeeForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        formData.append("id", id);
        bdUtils.updateData(API_ENDPOINTS.EMPLOYEE, formData, form, '?page=employees');
    });
}