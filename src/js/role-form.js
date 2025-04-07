import * as utils from './utils.js';

document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    try {
        const response = await fetch(`../administrative/user-roles/code.php?id=${id}`);

        if (!response.ok) throw new Error("Erro na requisição");

        const result = await response.json();

        if (result.status === 200) {
            document.getElementById("permissionName").textContent = `Permissão - ${result.data.tipo}`;
            document.getElementById("id").value = result.data.id;
            document.getElementById("role").value = result.data.tipo;
            document.getElementById("description").value = result.data.descricao;
            const activeBadge = document.getElementById("active");
            activeBadge.textContent = result.data.ativo === "Y" ? "Ativo" : "Inativo";
            activeBadge.classList.toggle("bg-success", result.data.ativo === "Y");
            activeBadge.classList.toggle("bg-danger", result.data.ativo === "N");
        }

        const originalValues = [
            { elementId: 'role', originalValue: document.getElementById("role").value },
            { elementId: 'description', originalValue: document.getElementById("description").value },
        ]

        document.getElementById('clear').addEventListener('click', () => {
            utils.clearInputs(originalValues);
        });
    } catch (error) {
        toastr.error(error, "Erro!");
    }
});

