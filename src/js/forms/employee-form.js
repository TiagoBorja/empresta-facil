import * as utils from '../utils/utils.js';

const API_ENDPOINTS = {
    EMPLOYEE: '../php/api/employee-api.php',
    LIBRARY: './library/code.php',
    USER: './users/code.php',
};

let urlParams = new URLSearchParams(window.location.search);
let id = urlParams.get("id");

document.addEventListener('DOMContentLoaded', async function () {

    try {
        const response = await fetch(`${API_ENDPOINTS.EMPLOYEE}?id=${id}`);

        if (!response.ok) throw new Error("Erro na requisição");

        const result = await response.json();

        if (result.status === 200) {
            document.getElementById("employeeName").textContent = `Funcionário - ${result.data.nome_completo}`;
            document.getElementById("id").value = result.data.id;
            document.getElementById("users").value = result.data.utilizador_fk;
            document.getElementById("library").value = result.data.biblioteca_fk;

            const activeBadge = document.getElementById("active");
            activeBadge.textContent = result.data.ativo === "Y" ? "Ativo" : "Inativo";
            activeBadge.classList.toggle("bg-success", result.data.ativo === "Y");
            activeBadge.classList.toggle("bg-danger", result.data.ativo === "N");

            await utils.fetchSelect(API_ENDPOINTS.USER, "primeiro_nome ultimo_nome", "users", result.data.utilizador_fk);
            await utils.fetchSelect(API_ENDPOINTS.LIBRARY, "nome", "library", result.data.biblioteca_fk);
        }
    } catch (error) {
        toastr.error(error, "Erro!");
    }
});


