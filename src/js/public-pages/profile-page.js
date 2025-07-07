import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';

const API_ENDPOINTS = {
    USER: '../administrative/users/code.php',
    COMMENTS: './api/comments-api.php',
};


let urlParams;
let id;

document.addEventListener("DOMContentLoaded", async () => {
    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    id = urlParams.get("id");

    await getProfileTab(); // já carrega ao entrar na página
    document.getElementById("profile-tab").addEventListener("click", getProfileTab);
    document.getElementById("comments-tab").addEventListener("click", getCommentTab);
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
        listContainer.innerHTML = "<li class='list-group-item'>Sem comentários disponíveis.</li>";
        return;
    }

    comments.forEach(comment => {
        const item = document.createElement("li");
        item.classList.add("list-group-item");
        item.innerHTML = `
            <strong>"${comment.comentario}"</strong> em 
            <em>${comment.titulo}</em> 
            <span class="text-muted small">- ${utils.formatDate(comment.data)}</span>
        `;
        listContainer.appendChild(item);
    });
}
