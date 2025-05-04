import * as utils from './utils.js';

document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    try {
        const response = await fetch(`../administrative/state/code.php?id=${id}`);

        if (!response.ok) throw new Error("Erro na requisição");

        const result = await response.json();

        if (result.status === 200) {
            document.getElementById("stateName").textContent = `Estado - ${result.data.estado}`;
            document.getElementById("id").value = result.data.id;
            document.getElementById("state").value = result.data.estado;
            document.getElementById("observation").value = result.data.observacoes;
            const activeBadge = document.getElementById("active");
            activeBadge.textContent = result.data.ativo === "Y" ? "Ativo" : "Inativo";
            activeBadge.classList.toggle("bg-success", result.data.ativo === "Y");
            activeBadge.classList.toggle("bg-danger", result.data.ativo === "N");
        }

        const originalValues = [
            { elementId: 'state', originalValue: document.getElementById("state").value },
            { elementId: 'observation', originalValue: document.getElementById("observation").value },
        ]

        document.getElementById('clear').addEventListener('click', () => {
            utils.clearInputs(originalValues);
        });
    } catch (error) {
        toastr.error(error, "Erro!");
    }
});

