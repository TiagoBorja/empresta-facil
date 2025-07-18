import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';
const API_URL = '../administrative/users/code.php';
const ROLE_API_URL = '../administrative/user-roles/code.php';
const LIBRARY_API_URL = '../administrative/library/code.php';
const USER_LIBRARY_API_URL = '../php/api/user-library-api.php';

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
        const role = document.getElementById("userRole").value;

        if (!id) {
            if (role === 'Administrador') {
                await utils.fetchSelect(ROLE_API_URL, 'tipo', "roleSelect");
                newUserByAdm();
            }
            else {
                newUserByEmployee();
            }
            return;
        }

        if (role === 'Administrador')
            updateUserByAdm();
        else
            updateUserByEmployee();
        changeActiveStatus();
        return;
    }

});

async function getUsers() {

    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error("Resposta inválida do servidor");

        const result = await response.json();
        showUsers(result.data)

        utils.initializeRowSelection(API_URL, '?page=user-form', null, {
            onPendingClick: (row) => {
                const userId = row.id.replace('id-', '');
                const userEmail = row.getAttribute('data-email') || 'Email não disponível';
                openCodeValidationModal(userId, userEmail);
            },
        });
    } catch (error) {
        console.warn(error)
    }
}

async function newUserByAdm() {
    const allLibrariesData = await fetchAllLibrariesData();
    console.log(allLibrariesData);

    utils.createGenericCheckboxes(allLibrariesData, [], {
        containerId: 'librariesCheckboxes',
        nameField: 'nome',
        idField: 'id',
        valueField: 'id',
        checkboxName: 'libraries[]',
        dropdownButtonId: 'librariesDropdown',
        singularLabel: 'biblioteca',
        pluralLabel: 'bibliotecas',
        associationField: 'biblioteca_fk'
    });
    const form = document.querySelector("#userForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.newData(API_URL, formData, form, '?page=users');
    });
}
function newUserByEmployee() {
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
        let active = '';

        switch (user.ativo) {
            case 'P':
                active = '<span class="badge rounded-pill bg-warning">Pendente</span>';
                break;
            case 'Y':
                active = '<span class="badge rounded-pill bg-success">Ativo</span>';
                break;
            case 'N':
                active = '<span class="badge rounded-pill bg-danger">Inativo</span>';
                break;
            default:
                active = '';
        }


        tableBody.append(`
            <tr id="id-${user.id}" class="selectable-row" data-active="${user.ativo}" data-email="${user.email}">
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
        ordering: false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese.json'
        }
    });
}

async function registerUser() {
    const allLibrariesData = await fetchAllLibrariesData();
    console.log(allLibrariesData);

    utils.createGenericCheckboxes(allLibrariesData, [], {
        containerId: 'librariesCheckboxes',
        nameField: 'nome',
        idField: 'id',
        valueField: 'id',
        checkboxName: 'libraries[]',
        dropdownButtonId: 'librariesDropdown',
        singularLabel: 'biblioteca',
        pluralLabel: 'bibliotecas',
        associationField: 'biblioteca_fk'
    });

    const form = document.querySelector("#registerForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("registerUser", true);

        bdUtils.newData(API_URL, formData, form, '?page=auth');
    });
}

async function updateUserByEmployee() {
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
async function updateUserByAdm() {
    const allLibrariesData = await fetchAllLibrariesData();
    const userLibraries = await fetchAllUserLibrariesData(id);

    utils.createGenericCheckboxes(allLibrariesData, userLibraries, {
        containerId: 'librariesCheckboxes',
        nameField: 'nome',
        idField: 'id',
        valueField: 'id',
        checkboxName: 'libraries[]',
        dropdownButtonId: 'librariesDropdown',
        singularLabel: 'biblioteca',
        pluralLabel: 'bibliotecas',
        associationField: 'biblioteca_fk'
    });
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

async function fetchAllLibrariesData() {
    const response = await fetch(`${LIBRARY_API_URL}?activeOnly=true`);
    if (!response.ok) {
        const errorText = await response.text();
        throw new Error(`Erro na API: ${response.status} - ${errorText}`);
    }

    const result = await response.json();

    if (!result || typeof result !== 'object') {
        throw new Error("Resposta da API inválida");
    }

    if (result.status && result.status !== 200) {
        throw new Error(result.message || "Bibliotecas não encontradas");
    }

    const librariesData = result.data || result;

    if (!Array.isArray(librariesData)) {
        throw new Error("Formato de dados de bibliotecas inválido");
    }

    return librariesData;
}

function openCodeValidationModal(userId, userEmail) {
    const modalElement = document.getElementById("validationModal");
    const validationModal = new bootstrap.Modal(modalElement);

    document.getElementById("userIdInput").value = userId || '';
    document.getElementById("userEmailDisplay").textContent = userEmail || 'Email não disponível';

    validationModal.show();


    const form = document.querySelector("#validationForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("validationSubmit", "1");
        formData.append("saveData", true);
        bdUtils.updateData(USER_LIBRARY_API_URL, formData, form, '?page=users');
    });
}
async function fetchAllUserLibrariesData(userId) {
    const response = await fetch(`${USER_LIBRARY_API_URL}?&id=${userId}`);
    if (!response.ok) {
        const errorText = await response.text();
        throw new Error(`Erro na API: ${response.status} - ${errorText}`);
    }

    const data = await response.json();
    return data?.data || []; // ← ajusta conforme estrutura da resposta
}