import * as utils from '../utils/utils.js';

document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    try {
        const response = await fetch(`../administrative/publisher/code.php?id=${id}`);

        if (!response.ok) throw new Error("Erro na requisição");

        const result = await response.json();

        if (result.status === 200) {
            document.getElementById("publisherTitle").textContent = `Editora - ${result.data.editora}`;
            document.getElementById("id").value = result.data.id;
            document.getElementById("publisherName").value = result.data.editora;

            const activeBadge = document.getElementById("active");
            activeBadge.textContent = result.data.ativo === "Y" ? "Ativo" : "Inativo";
            activeBadge.classList.toggle("bg-success", result.data.ativo === "Y");
            activeBadge.classList.toggle("bg-danger", result.data.ativo === "N");

            document.getElementById("user-info").classList.remove("d-none");
            document.getElementById("created-user").textContent = result.data.criado_por ?? "-";
            document.getElementById("created-date").textContent = result.data.criado_em ?? "-";
            document.getElementById("updated-user").textContent = result.data.atualizado_por ?? "-";
            document.getElementById("updated-date").textContent = result.data.atualizado_em ?? "-";


            const originalValues = [
                { elementId: 'publisherName', originalValue: document.getElementById("publisherName").value },
            ]

            document.getElementById('clear').addEventListener('click', () => {
                utils.clearInputs(originalValues);
            });
        }
    } catch (error) {
        toastr.error(error, "Erro!");
    }
});


