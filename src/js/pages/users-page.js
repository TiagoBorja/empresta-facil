import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';
const API_URL = '../administrative/users/code.php';
const ROLE_API_URL = '../administrative/user-roles/code.php';
let urlParams;
let id;


document.addEventListener("DOMContentLoaded", async function () {

    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    id = urlParams.get("id");

    if (currentPath === '?page=users') {
        await getUsers();
        return;
    }

    if (currentPath === '?page=register') {
        registerUser();
        return;
    }

    if (currentPath.includes('?page=user-form')) {

        if (!id) {
            await utils.fetchSelect(ROLE_API_URL, 'tipo', "roleSelect");
            newUser();
            return;
        }
        updateUser();
        changeActiveStatus();
        return;
    }

});

async function getUsers() {

    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error("Resposta inválida do servidor");

        const result = await response.json();
        showUsers(result)

        utils.initializeRowSelection(API_URL, '?page=user-form');
    } catch (error) {
        console.warn(error)
    }
}

function newUser() {
    const form = document.querySelector("#userForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.newData(API_URL, formData, form, '?page=users');
    });
}

function showUsers(users) {

    if ($.fn.DataTable.isDataTable('#zero_config')) {
        $('#zero_config').DataTable().destroy();
    }

    const tableBody = $('#zero_config tbody');
    tableBody.empty(); 

    users.forEach((user) => {
        const active = user.ativo === 'Y'
            ? '<span class="badge rounded-pill bg-success">Ativo</span>'
            : (user.ativo === 'N'
                ? '<span class="badge rounded-pill bg-danger">Inativo</span>'
                : '');

        tableBody.append(`
            <tr id="id-${user.id}" class="selectable-row">
                <td>${user.primeiro_nome}</td>
                <td>${user.ultimo_nome}</td>
                <td>${user.nome_utilizador}</td>
                <td>${user.email}</td>
                <td>${user.tipo}</td>
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

function registerUser() {
    const form = document.querySelector("#registerForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("registerUser", true);

        bdUtils.newData(API_URL, formData, form, '?page=auth');
    });
}

function updateUser() {

    const form = document.querySelector("#userForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        formData.append("id", id);
        bdUtils.updateData(API_URL, formData, form, '?page=users');
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