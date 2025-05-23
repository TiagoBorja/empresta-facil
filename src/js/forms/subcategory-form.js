import * as utils from '../utils/utils.js';

document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    const CATEGORIES_API_URL = '../administrative/category/code.php';

    try {
        const response = await fetch(`../administrative/subcategory/code.php?id=${id}`);

        if (!response.ok) throw new Error("Erro na requisição");

        const result = await response.json();

        if (result.status === 200) {
            document.getElementById("subcategoryName").textContent = `Subcategoria - ${result.data.subcategoria}`;
            document.getElementById("id").value = result.data.id;
            document.getElementById("subcategory").value = result.data.subcategoria;
            document.getElementById("description").value = result.data.descricao;

            const activeBadge = document.getElementById("active");
            activeBadge.textContent = result.data.ativo === "Y" ? "Ativo" : "Inativo";
            activeBadge.classList.toggle("bg-success", result.data.ativo === "Y");
            activeBadge.classList.toggle("bg-danger", result.data.ativo === "N");

            await utils.fetchSelect(CATEGORIES_API_URL, "categoria", "category", result.data.categoria_id);
        }
    } catch (error) {
        toastr.error(error, "Erro!");
    }
});


