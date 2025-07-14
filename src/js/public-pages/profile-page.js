import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';

const API_ENDPOINTS = {
    USER: '../administrative/users/code.php',
    COMMENTS: './api/comments-api.php',
    RESERVATION: './api/book-reservation-api.php',
    LOAN: './api/loan-api.php',
    LIBRARY: '../administrative/library/code.php',
    USER_LIBRARY: '../php/api/user-library-api.php',
};


let urlParams;
let id;
let dropdownBlocked = true;

const checkBoxConfig = {
    containerId: 'librariesCheckboxes',
    nameField: 'nome',
    idField: 'id',
    valueField: 'id',
    checkboxName: 'libraries[]',
    dropdownButtonId: 'librariesDropdown',
    singularLabel: 'biblioteca',
    pluralLabel: 'bibliotecas',
    associationField: 'biblioteca_fk'
}

document.addEventListener("DOMContentLoaded", async () => {
    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    id = urlParams.get("id");

    await getProfileTab(); // já carrega ao entrar na página
    document.getElementById("profile-tab").addEventListener("click", getProfileTab);
    document.getElementById("comments-tab").addEventListener("click", getCommentTab);
    document.getElementById("reservations-tab").addEventListener("click", getReservationTab);
    document.getElementById("loans-tab").addEventListener("click", getLoanTab);
    document.getElementById("settings-tab").addEventListener("click", getSettingsTab);

    const dropdownButton = document.getElementById('librariesDropdown');
    const searchInput = document.getElementById('searchInput');

    // Bloqueia o clique no dropdown se estiver bloqueado
    dropdownButton.addEventListener('mousedown', function (e) {
        if (dropdownBlocked) {
            e.preventDefault();
        }
    });

    // Define estado visual inicial
    dropdownButton.style.pointerEvents = 'none';
    dropdownButton.style.backgroundColor = '#eee';
    searchInput.disabled = true;

    window.toggleField = toggleField;

    update(id);
    const form = document.querySelector("#changePasswordForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("changePassword", true);
        formData.append("profileId", id);

        bdUtils.updateData(`${API_ENDPOINTS.USER}?changePassword`, formData, form, `?page=profile&id=${id}`);
    });
});



async function getProfileTab() {

    try {
        const [userReponse] = await Promise.all([
            fetch(`${API_ENDPOINTS.USER}?id=${id}`),
        ]);

        if (!userReponse.ok) {
            throw new Error("Erro na requisição");
        }

        const user = await userReponse.json();

        fillProfileTab(user);

    } catch (error) {
        console.error("Erro ao obter bibliotecas:", error);
        toastr.warning("Não foi possível carregar as bibliotecas. Tenta novamente mais tarde.", "Atenção!");
    }
}

async function getCommentTab() {

    try {
        const [commentResponse] = await Promise.all([
            fetch(`${API_ENDPOINTS.COMMENTS}?userId=${id}`),
        ]);

        if (!commentResponse.ok) {
            throw new Error("Erro na requisição");
        }

        const user = await commentResponse.json();

        fillCommentTab(user);

    } catch (error) {
        console.error("Erro ao obter bibliotecas:", error);
        toastr.warning("Não foi possível carregar as bibliotecas. Tenta novamente mais tarde.", "Atenção!");
    }
}
async function getReservationTab() {

    try {
        const [reservationResponse] = await Promise.all([
            fetch(`${API_ENDPOINTS.RESERVATION}?userId=${id}`),
        ]);

        if (!reservationResponse.ok) {
            throw new Error("Erro na requisição");
        }

        const reservation = await reservationResponse.json();

        fillReservationTab(reservation.data);

    } catch (error) {
        console.error("Erro ao obter bibliotecas:", error);
        toastr.warning("Não foi possível carregar as bibliotecas. Tenta novamente mais tarde.", "Atenção!");
    }
}

async function getLoanTab() {

    try {
        const [loanResponse] = await Promise.all([
            fetch(`${API_ENDPOINTS.LOAN}?userId=${id}`),
        ]);

        if (!loanResponse.ok) {
            throw new Error("Erro na requisição");
        }

        const loan = await loanResponse.json();

        fillLoanTab(loan.data);

    } catch (error) {
        console.error("Erro ao obter empréstimos:", error);
        toastr.warning("Não foi possível carregar os empréstimos. Tenta novamente mais tarde.", "Atenção!");
    }
}

async function getSettingsTab() {

    try {
        const [userReponse] = await Promise.all([
            fetch(`${API_ENDPOINTS.USER}?id=${id}`),
        ]);

        if (!userReponse.ok) {
            throw new Error("Erro na requisição");
        }

        const user = await userReponse.json();

        fillSettingsTab(user);

    } catch (error) {
        console.error("Erro ao obter bibliotecas:", error);
        toastr.warning("Não foi possível carregar as bibliotecas. Tenta novamente mais tarde.", "Atenção!");
    }
}

function fillProfileTab(user) {
    document.getElementById("firstName").value = user.data.primeiro_nome || '';
    document.getElementById("lastName").value = user.data.ultimo_nome || '';
    document.getElementById("birthDate").value = user.data.data_nascimento || '';
    document.getElementById("nif").value = user.data.nif || '';
    document.getElementById("citizenCard").value = user.data.cc || '';
    document.getElementById("address").value = user.data.morada || '';
    document.getElementById("phone").value = user.data.telemovel || '';
    document.getElementById("username").value = user.data.nome_utilizador || '';
    document.getElementById("email").value = user.data.email || '';
}

function fillCommentTab(response) {
    const comments = response.data;
    const listContainer = document.querySelector("#comments ul.list-group");
    listContainer.innerHTML = ""; // limpa comentários antigos

    if (!comments.length) {
        listContainer.innerHTML = "<li class='list-group-item'>Nenhum comentário ainda.</li>";
        return;
    }
    console.log(comments);
    
    comments.forEach(comment => {
        const item = document.createElement("li");
        item.classList.add("list-group-item");
        item.innerHTML = `
            <strong>"${comment.comentario}"</strong> em 
            <em><a href="?page=book-info&id=${comment.livro_fk}">${comment.titulo}</a></em> 
            <span class="text-muted small">- ${utils.formatDate(comment.criado_em)}</span>
        `;
        listContainer.appendChild(item);
    });
}

function fillReservationTab(reservations) {
    console.log(reservations);

    const tbody = document.querySelector("#reservations table tbody");
    tbody.innerHTML = "";

    if (reservations.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="text-center">Sem reservas disponíveis.</td>
            </tr>
        `;
        return;
    }

    reservations.forEach(reservation => {
        let state = '';

        switch ((reservation.estado || "").toUpperCase()) {
            case 'PENDENTE':
                state = '<span class="badge bg-warning">Pendente</span>';
                break;
            case 'ATENDIDA':
                state = '<span class="badge bg-success">Atendida</span>';
                break;
            case 'EXPIRADA':
                state = '<span class="badge bg-secondary">Expirada</span>';
                break;
            case 'CANCELADA':
                state = '<span class="badge bg-danger">Cancelada</span>';
                break;
            default:
                state = '<span class="badge bg-dark">Desconhecido</span>';
        }


        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${reservation.titulo}</td>
            <td>${utils.formatDate(reservation.criado_em)}</td>
            <td>${utils.formatDate(reservation.data_levantamento)}</td>
            <td>${state}</td>
        `;

        tbody.appendChild(tr);
    });
}

function fillLoanTab(loans) {
    const tbody = document.querySelector("#loans table tbody");
    tbody.innerHTML = "";

    if (!loans || loans.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center">Sem empréstimos disponíveis.</td>
            </tr>
        `;
        return;
    }

    loans.forEach(loan => {
        let statusBadge = "";

        switch (loan.estado) {
            case 'DEVOLVIDO':
                statusBadge = '<span class="badge bg-success">Devolvido</span>';
                break;
            case 'ATRASADO':
                statusBadge = '<span class="badge bg-danger">Atrasado</span>';
                break;
            case 'EM ANDAMENTO':
                statusBadge = '<span class="badge bg-warning">Em Andamento</span>';
                break;
            default:
                statusBadge = '<span class="badge bg-secondary">Desconhecido</span>';
        }

        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${loan.titulo}</td>
            <td>${utils.formatDate(loan.criado_em)}</td>
            <td>${utils.formatDate(loan.data_devolucao)}</td>
            <td>${statusBadge}</td>
        `;

        tbody.appendChild(tr);
    });
}

async function fillSettingsTab(user) {
    document.getElementById("settingsFirstName").value = user.data.primeiro_nome || '';
    document.getElementById("settingsLastName").value = user.data.ultimo_nome || '';
    document.getElementById("settingsNif").value = user.data.nif || '';
    document.getElementById("settingsCc").value = user.data.cc || '';
    document.getElementById("settingsAddress").value = user.data.morada || '';
    document.getElementById("settingsPhone").value = user.data.telemovel || '';
    document.getElementById("settingsUsername").value = user.data.nome_utilizador || '';
    document.getElementById("settingsEmail").value = user.data.email || '';

    const allLibrariesData = await fetchAllLibrariesData();
    const userLibraries = await fetchAllUserLibrariesData(user.data.id);
    utils.createGenericCheckboxes(allLibrariesData, userLibraries, checkBoxConfig);
}

function toggleField(fieldId, iconElem) {

    if (fieldId === 'libraryDropdownDiv') {
        dropdownBlocked = !dropdownBlocked;

        const dropdownButton = document.getElementById('librariesDropdown');
        const searchInput = document.getElementById('searchInput');

        if (!dropdownBlocked) {
            dropdownButton.style.pointerEvents = 'auto';
            dropdownButton.style.backgroundColor = '';
            searchInput.disabled = false;
            dropdownButton.focus();
            iconElem.style.opacity = 0.4;
        } else {
            dropdownButton.style.pointerEvents = 'none';
            dropdownButton.style.backgroundColor = '#eee';
            searchInput.disabled = true;
            iconElem.style.opacity = 1;
        }
    } else {
        const field = document.getElementById(fieldId);
        if (!field) return;

        const isDisabled = field.disabled;
        field.disabled = !isDisabled;

        if (!isDisabled) {
            field.blur();
        } else {
            field.focus();
        }

        iconElem.style.opacity = isDisabled ? 0.4 : 1;
    }

    const inputs = document.querySelectorAll('input, textarea');
    const anyEnabled = Array.from(inputs).some(el => !el.disabled);
    document.getElementById('settingsSave').disabled = !anyEnabled && dropdownBlocked;
}


async function fetchAllLibrariesData() {
    const response = await fetch(`${API_ENDPOINTS.LIBRARY}?activeOnly=true`);
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

async function fetchAllUserLibrariesData(userId) {
    const response = await fetch(`${API_ENDPOINTS.USER_LIBRARY}?&id=${userId}`);
    if (!response.ok) {
        const errorText = await response.text();
        throw new Error(`Erro na API: ${response.status} - ${errorText}`);
    }

    const data = await response.json();
    return data?.data || []; // ← ajusta conforme estrutura da resposta
}


function update(userId) {
    const form = document.querySelector("#settingsForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveProfile", true);
        formData.append("profileId", userId);
        formData.append('firstName', document.querySelector('input[name="firstName"]').value);
        formData.append('lastName', document.querySelector('input[name="lastName"]').value);
        formData.append('nif', document.querySelector('input[name="nif"]').value);
        formData.append('cc', document.querySelector('input[name="cc"]').value);
        formData.append('email', document.querySelector('input[name="email"]').value);
        formData.append('phone', document.querySelector('input[name="phone"]').value);
        formData.append('username', document.querySelector('input[name="username"]').value);

        bdUtils.updateData(`${API_ENDPOINTS.USER}?profileId=${userId}`, formData, form, `?page=profile&id=${userId}`);
    });
}