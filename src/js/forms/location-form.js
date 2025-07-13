import * as utils from '../utils/utils.js';

document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    const LIBRARY_API_URL = '../administrative/library/code.php';

    try {
        const response = await fetch(`../administrative/location/code.php?id=${id}`);

        if (!response.ok) throw new Error("Erro na requisição");

        const result = await response.json();

        if (result.status === 200) {
            document.getElementById("locationName").textContent = `Código de Localização - ${result.data.cod_local}`;
            document.getElementById("id").value = result.data.id;
            document.getElementById("locationCode").value = result.data.cod_local;
            document.getElementById("library").value = result.data.biblioteca_fk;

            const activeBadge = document.getElementById("active");
            activeBadge.textContent = result.data.ativo === "Y" ? "Ativo" : "Inativo";
            activeBadge.classList.toggle("bg-success", result.data.ativo === "Y");
            activeBadge.classList.toggle("bg-danger", result.data.ativo === "N");

            await utils.fetchSelect(LIBRARY_API_URL, "nome", "library", result.data.biblioteca_fk, true);
        }
    } catch (error) {
        toastr.error(error, "Erro!");
    }
});


