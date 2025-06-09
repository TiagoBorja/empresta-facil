import { showContentAfterLoading, showLoadingHideContent, fetchSelect } from '../utils/utils.js';


const BASE_API_URL = '../administrative/book/code.php';
const PUBLISHER_API_URL = '../administrative/publisher/code.php';
const CATEGORY_API_URL = '../administrative/category/code.php';
const SUBCATEGORY_API_URL = '../administrative/subcategory/code.php';
const LOCATION_API_URL = '../administrative/location/code.php';
const STATE_API_URL = '../administrative/state/code.php';

document.addEventListener('DOMContentLoaded', async function () {
    showLoadingHideContent("loading", ["content"]);

    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    const showForm = () => showContentAfterLoading("loading", ["content"]);

    try {
        const response = await fetch(`${BASE_API_URL}?id=${id}`);
        if (!response.ok) throw new Error("Erro na requisição");

        const result = await response.json();
        if (result.status !== 200) return showForm();

        // Preencher os campos do formulário com os dados do livro
        document.getElementById("bookTitle").textContent = `Livro - ${result.data.titulo}`;
        document.getElementById("id").value = result.data.id;
        document.getElementById("title").value = result.data.titulo;
        document.getElementById("isbn").value = result.data.isbn;
        document.getElementById("releaseYear").value = result.data.ano_lancamento;
        document.getElementById("language").value = result.data.idioma;
        document.getElementById("quantity").value = result.data.quantidade;
        document.getElementById("resourceType").value = result.data.tipo_recurso;
        document.getElementById("publisher").value = result.data.editora_fk;
        document.getElementById("category").value = result.data.categoria_fk;
        document.getElementById("subcategory").value = result.data.subcategoria_fk;
        document.getElementById("location").value = result.data.localizacao_fk;
        document.getElementById("status").value = result.data.estado;
        document.getElementById("synopsis").value = result.data.sinopse;

        // Badge de estado (ativo/inativo)
        const activeBadge = document.getElementById("active");
        activeBadge.textContent = result.data.ativo === "Y" ? "Ativo" : "Inativo";
        activeBadge.classList.toggle("bg-success", result.data.ativo === "Y");
        activeBadge.classList.toggle("bg-danger", result.data.ativo === "N");

        await fetchSelect(PUBLISHER_API_URL, 'nome', "publisher", result.data.editora_fk);
        await fetchSelect(CATEGORY_API_URL, 'nome', "category", result.data.categoria_fk);
        await fetchSelect(SUBCATEGORY_API_URL, 'nome', "subcategory", result.data.subcategoria_fk);
        await fetchSelect(LOCATION_API_URL, 'nome', "location", result.data.localizacao_fk);
        await fetchSelect(STATE_API_URL, 'estado', "status", result.data.estado);

        showForm();
    } catch (error) {
        toastr.error(error.message || error, "Erro!");
        showContentAfterLoading("loading", ["content"]);
    }
});

