import { showContentAfterLoading, showLoadingHideContent, fetchSelect } from '../utils/utils.js';


const BASE_API_URL = '../administrative/book/code.php';
const PUBLISHER_API_URL = '../administrative/publisher/code.php?activeOnly=true&returnedId=';
const CATEGORY_API_URL = '../administrative/category/code.php?activeOnly=true&returnedId=';
const SUBCATEGORY_API_URL = '../administrative/subcategory/code.php?activeOnly=true&returnedId=';

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

        document.getElementById("bookTitle").textContent = `Livro - ${result.data.titulo}`;
        document.getElementById("id").value = result.data.id;
        document.getElementById("title").value = result.data.titulo;
        document.getElementById("isbn").value = result.data.isbn;
        document.getElementById("releaseYear").value = result.data.ano_lancamento;
        document.getElementById("language").value = result.data.idioma;
        document.getElementById("quantity").value = result.data.quantidade;
        document.getElementById("publisher").value = result.data.editora_fk;
        document.getElementById("category").value = result.data.categoria_fk;
        document.getElementById("subcategory").value = result.data.subcategoria_fk;
        document.getElementById("synopsis").value = result.data.sinopse;

        // Badge de estado (ativo/inativo)
        const activeBadge = document.getElementById("active");
        activeBadge.textContent = result.data.ativo === "Y" ? "Ativo" : "Inativo";
        activeBadge.classList.toggle("bg-success", result.data.ativo === "Y");
        activeBadge.classList.toggle("bg-danger", result.data.ativo === "N");

        await fetchSelect(`${PUBLISHER_API_URL}${result.data.editora_fk}`, 'editora', "publisher", result.data.editora_fk);
        await fetchSelect(`${CATEGORY_API_URL}${result.data.categoria_fk}`, 'categoria', "category", result.data.categoria_fk);
        await fetchSelect(`${SUBCATEGORY_API_URL}${result.data.subcategoria_fk}`, 'subcategoria', "subcategory", result.data.subcategoria_fk);

        showForm();
    } catch (error) {
        toastr.error(error.message || error, "Erro!");
        showContentAfterLoading("loading", ["content"]);
    }
});

