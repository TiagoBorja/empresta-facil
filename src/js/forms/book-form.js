import { showContentAfterLoading, showLoadingHideContent, fetchSelect } from '../utils/utils.js';


const BASE_API_URL = '../administrative/book/code.php';
const AUTHOR_API_URL = '../administrative/author/code.php';
const PUBLISHER_API_URL = '../administrative/publisher/code.php?activeOnly=true&returnedId=';
const CATEGORY_API_URL = '../administrative/category/code.php?activeOnly=true&returnedId=';
const SUBCATEGORY_API_URL = '../administrative/subcategory/code.php?activeOnly=true&returnedId=';

document.addEventListener('DOMContentLoaded', async function () {
    showLoadingHideContent("loading", ["content"]);

    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    const showForm = () => showContentAfterLoading("loading", ["content"]);

    try {
        const bookResponse = await fetch(`${BASE_API_URL}?id=${id}`);
        if (!bookResponse.ok) throw new Error("Erro na requisição");

        const bookResult = await bookResponse.json();
        if (bookResult.status !== 200) return showForm();

        const authorResponse = await fetch(`${BASE_API_URL}?id=${id}`);
        if (!authorResponse.ok) throw new Error("Erro na requisição");

        const authorResult = await authorResponse.json();
        if (authorResult.status !== 200) return showForm();

        document.getElementById("bookTitle").textContent = `Livro - ${bookResult.data.titulo}`;
        document.getElementById("id").value = bookResult.data.id;
        document.getElementById("title").value = bookResult.data.titulo;
        document.getElementById("isbn").value = bookResult.data.isbn;
        document.getElementById("releaseYear").value = bookResult.data.ano_lancamento;
        document.getElementById("language").value = bookResult.data.idioma;
        document.getElementById("quantity").value = bookResult.data.quantidade;
        document.getElementById("publisher").value = bookResult.data.editora_fk;
        document.getElementById("category").value = bookResult.data.categoria_fk;
        document.getElementById("subcategory").value = bookResult.data.subcategoria_fk;
        document.getElementById("synopsis").value = bookResult.data.sinopse;

        // Badge de estado (ativo/inativo)
        const activeBadge = document.getElementById("active");
        activeBadge.textContent = bookResult.data.ativo === "Y" ? "Ativo" : "Inativo";
        activeBadge.classList.toggle("bg-success", bookResult.data.ativo === "Y");
        activeBadge.classList.toggle("bg-danger", bookResult.data.ativo === "N");

        await fetchSelect(`${PUBLISHER_API_URL}${bookResult.data.editora_fk}`, 'editora', "publisher", bookResult.data.editora_fk);
        await fetchSelect(`${CATEGORY_API_URL}${bookResult.data.categoria_fk}`, 'categoria', "category", bookResult.data.categoria_fk);
        await fetchSelect(`${SUBCATEGORY_API_URL}${bookResult.data.subcategoria_fk}`, 'subcategoria', "subcategory", bookResult.data.subcategoria_fk);
        await fetchSelect(`${AUTHOR_API_URL}`, 'primeiro_nome', "authors", authorResult.data.primeiro_nome);

        showForm();
    } catch (error) {
        toastr.error(error.message || error, "Erro!");
        showContentAfterLoading("loading", ["content"]);
    }
});

