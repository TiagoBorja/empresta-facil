import * as bdUtils from './bd-utils.js';
import * as utils from './utils.js';
const API_URL = '../administrative/users/code.php';
const ROLE_API_URL = '../administrative/user-roles/code.php';

document.addEventListener("DOMContentLoaded", function () {

    getUsers();
});

async function getUsers() {

    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error("Resposta inválida do servidor");

        const result = await response.json();
        showUsers(result)

        utils.initializeRowSelection(API_URL, '?page=user-form');
        fetchRoles(ROLE_API_URL);
    } catch (error) {
        console.warn(error)
    }
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

        if (result.error) {
            console.error(result.error);
        } else {
            console.log(result);
        }
    } catch (error) {
        console.error('Erro ao fazer requisição:', error);
    }
}
function fillSelect(roles) {
    let option = "";

    roles.forEach((role) => {

        option += `<option value="${role.id}">${role.tipo} - ${role.descricao}</option>`;
    });

    const select = document.getElementById("roleSelect");
    select.innerHTML = option;
}

