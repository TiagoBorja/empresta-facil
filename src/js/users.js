import * as bdUtils from './bd-utils.js';
import * as utils from './utils.js';
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
        await fetchRoles(ROLE_API_URL);

        if (!id) {
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
    let table = "";

    users.forEach((user) => {
        const active = user.ativo === 'Y'
            ? '<span class="badge rounded-pill bg-success">Ativo</span>'
            : (user.ativo === 'N'
                ? '<span class="badge rounded-pill bg-danger">Inativo</span>'
                : '');

        table += `<tr id="id-${user.id}">
                  <td scope="row">${user.primeiro_nome}</td>
                  <td>${user.ultimo_nome}</td>
                  <td>${user.nome_utilizador}</td>
                  <td>${user.email}</td>
                  <td>${user.tipo}</td>
                  <td>${active}</td>
                  </tr>`;
    });

    const tableBody = document.getElementById("tbody");
    tableBody.innerHTML = table;
}

async function fetchRoles(API_URL) {

    try {
        const response = await fetch(API_URL);

        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.statusText);
        }

        const result = await response.json();

        fillSelect(result);
    } catch (error) {
        console.error('Erro ao fazer requisição:', error);
    };
}


function fillSelect(roles) {
    let option = "";

    roles.forEach((role) => {

        option += `<option value="${role.id}">${role.tipo} - ${role.descricao}</option>`;
    });

    const select = document.getElementById("roleSelect");
    select.innerHTML = option;
}

function registerUser() {
    const form = document.querySelector("#registerForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        console.log([...formData.entries()]); // Verifique se os campos estão sendo capturados
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