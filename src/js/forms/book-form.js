import { showContentAfterLoading, showLoadingHideContent, fetchSelect } from '../utils/utils.js';

const BASE_API_URL = '../administrative/book/code.php';
const AUTHOR_BOOK_API_URL = '../administrative/author-book/code.php';
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

        const authorBookResponse = await fetch(`${AUTHOR_BOOK_API_URL}?id=${id}`);
        if (!authorBookResponse.ok) throw new Error("Erro na requisição");

        const authorBookResult = await authorBookResponse.json();
        if (authorBookResult.status !== 200) return showForm();

        // Preenche campos do livro
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

        const activeBadge = document.getElementById("active");
        activeBadge.textContent = bookResult.data.ativo === "Y" ? "Ativo" : "Inativo";
        activeBadge.classList.toggle("bg-success", bookResult.data.ativo === "Y");
        activeBadge.classList.toggle("bg-danger", bookResult.data.ativo === "N");

        await fetchSelect(`${PUBLISHER_API_URL}${bookResult.data.editora_fk}`, 'editora', "publisher", bookResult.data.editora_fk);
        await fetchSelect(`${CATEGORY_API_URL}${bookResult.data.categoria_fk}`, 'categoria', "category", bookResult.data.categoria_fk);
        await fetchSelect(`${SUBCATEGORY_API_URL}${bookResult.data.subcategoria_fk}`, 'subcategoria', "subcategory", bookResult.data.subcategoria_fk);

        const authorsCheckboxesDiv = document.getElementById("authorsCheckboxes");
        authorsCheckboxesDiv.innerHTML = ""; // Limpa anterior

        authorBookResult.data.forEach(author => {
            const wrapper = document.createElement("div");
            wrapper.classList.add("form-check");

            const checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.classList.add("form-check-input");
            checkbox.id = `author_${author.autor_fk}`;
            checkbox.name = "authors[]"; 
            checkbox.value = author.autor_fk;
            checkbox.checked = !!author.selected;

            const label = document.createElement("label");
            label.classList.add("form-check-label");
            label.htmlFor = checkbox.id;
            label.textContent = author.nome_completo;

            wrapper.appendChild(checkbox);
            wrapper.appendChild(label);

            authorsCheckboxesDiv.appendChild(wrapper);
        });

        const authorsDropdownBtn = document.getElementById('authorsDropdown');

        function updateButtonText() {
            const checked = authorsCheckboxesDiv.querySelectorAll('input[type="checkbox"]:checked');
            if (checked.length === 0) {
                authorsDropdownBtn.textContent = 'Selecionar autores';
            } else if (checked.length === 1) {
                const label = authorsCheckboxesDiv.querySelector(`label[for="${checked[0].id}"]`);
                authorsDropdownBtn.textContent = label ? label.textContent.trim() : '1 autor selecionado';
            } else {
                authorsDropdownBtn.textContent = `${checked.length} autores selecionados`;
            }
        }

        authorsCheckboxesDiv.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateButtonText);
        });

        updateButtonText();

        showForm();
    } catch (error) {
        toastr.error(error.message || error, "Erro!");
        showContentAfterLoading("loading", ["content"]);
    }
});
