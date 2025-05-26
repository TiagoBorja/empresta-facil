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

        }
    } catch (error) {
        toastr.error(error, "Erro!");
    }
});


