import { clearInputs } from '../utils/utils.js';

document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    try {
        const response = await fetch(`../administrative/library/code.php?id=${id}`);

        if (!response.ok) throw new Error("Erro na requisição");

        const result = await response.json();

        if (result.status === 200) {
            const library = result.data[0];
            
            document.getElementById("libraryName").textContent = `Biblioteca - ${library.nome}`;
            document.getElementById("id").value = library.id;
            document.getElementById("name").value = library.nome;
            document.getElementById("email").value = library.email;
            document.getElementById("address").value = library.morada;
            document.getElementById("postalCode").value = library.cod_postal;

            const activeBadge = document.getElementById("active");
            activeBadge.textContent = library.ativo === "Y" ? "Ativo" : "Inativo";
            activeBadge.classList.toggle("bg-success", library.ativo === "Y");
            activeBadge.classList.toggle("bg-danger", library.ativo === "N");


            document.getElementById("user-info").classList.remove("d-none");
            document.getElementById("created-user").textContent = library.criado_por ?? "-";
            document.getElementById("created-date").textContent = library.criado_em ?? "-";
            document.getElementById("updated-user").textContent = library.atualizado_por ?? "-";
            document.getElementById("updated-date").textContent = library.atualizado_em ?? "-";

            const originalValues = [
                { elementId: 'name', originalValue: document.getElementById("name").value },
                { elementId: 'email', originalValue: document.getElementById("email").value },
                { elementId: 'address', originalValue: document.getElementById("address").value },
                { elementId: 'postalCode', originalValue: document.getElementById("postalCode").value },
            ];


            document.getElementById('clear').addEventListener('click', () => {
                clearInputs(originalValues);
            });
        }

    } catch (error) {
        toastr.error(error, "Erro!");
    }
});
