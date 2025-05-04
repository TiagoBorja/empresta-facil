import * as bdUtils from './bd-utils.js';
import * as utils from './utils.js';
const API_URL = '../administrative/state/code.php';
let urlParams;
let id;

document.addEventListener("DOMContentLoaded", () => {

    getStates();

    urlParams = new URLSearchParams(window.location.search);
    id = urlParams.get("id");

    if (id) {
        updateUserRole();
        changeActiveStatus();
        return;
    }

    newState();
});


async function getStates() {

    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error("Resposta inválida do servidor");

        const result = await response.json();
        showStates(result)
        console.log(result)

        utils.initializeRowSelection(API_URL, '?page=state-form');
    } catch {
        toastr.warning(result.message, "Atenção!");
    }
}

function showStates(states) {
    let table = "";

    states.forEach((state) => {
        table += `<tr id="id-${state.id}">
                  <td scope="row">${state.estado}</td>
                  <td>${state.oberservacoes ?? 'Sem Observações'}</td>
                  </tr>`;
    });

    const tableBody = document.getElementById("tbody");
    tableBody.innerHTML = table;
}

function newState() {
    const form = document.querySelector("#stateForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.newData(API_URL, formData, form, '?page=state');
    });
}

function updateUserRole() {

    const form = document.querySelector("#roleForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.updateData(API_URL, formData, form, '?page=user-roles');
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