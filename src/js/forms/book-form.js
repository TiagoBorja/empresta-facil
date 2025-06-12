import { showContentAfterLoading, showLoadingHideContent, fetchSelect } from '../utils/utils.js';

const API_ENDPOINTS = {
    BOOK: '../administrative/book/code.php',
    AUTHOR_BOOK: '../administrative/author-book/code.php',
    PUBLISHER: '../administrative/publisher/code.php?activeOnly=true&returnedId=',
    CATEGORY: '../administrative/category/code.php?activeOnly=true&returnedId=',
    SUBCATEGORY: '../administrative/subcategory/code.php?activeOnly=true&returnedId=',
    AUTHORS: '../administrative/author/code.php'
};

document.addEventListener('DOMContentLoaded', async function () {
    showLoadingHideContent("loading", ["content"]);

    try {
        const bookId = new URLSearchParams(window.location.search).get("id");
        if (!bookId) throw new Error("ID do livro não fornecido");

        const [bookData, authorBookData] = await Promise.all([
            fetchBookData(bookId),
            fetchAuthorBookData(bookId)
        ]);

        let allAuthorsData = [];
        try {
            allAuthorsData = await fetchAllAuthorsData();
        } catch (error) {
            console.error("Erro ao carregar autores:", error);
            document.getElementById("authorsCheckboxes").innerHTML = `
                <div class="alert alert-warning">
                    Não foi possível carregar a lista de autores: ${error.message}
                </div>
            `;
        }

        populateBookForm(bookData);
        await populateSelectFields(bookData);

        if (allAuthorsData.length > 0) {
            createAuthorsCheckboxes(allAuthorsData, authorBookData);
        }

        showContentAfterLoading("loading", ["content"]);
    } catch (error) {
        console.error("Erro principal:", error);
        toastr.error(error.message || "Erro ao carregar dados do livro", "Erro!");
        showContentAfterLoading("loading", ["content"]);
    }
});

async function fetchBookData(bookId) {
    const response = await fetch(`${API_ENDPOINTS.BOOK}?id=${bookId}`);
    if (!response.ok) throw new Error("Erro ao buscar dados do livro");

    const result = await response.json();
    if (result.status !== 200) throw new Error(result.message || "Livro não encontrado");

    return result.data;
}

async function fetchAuthorBookData(bookId) {
    const response = await fetch(`${API_ENDPOINTS.AUTHOR_BOOK}?id=${bookId}`);
    if (!response.ok) throw new Error("Erro ao buscar autores do livro");

    const result = await response.json();
    if (result.status !== 200) throw new Error(result.message || "Autores não encontrados");

    return result.data;
}

async function fetchAllAuthorsData() {
    const response = await fetch(API_ENDPOINTS.AUTHORS);

    if (!response.ok) {
        const errorText = await response.text();
        throw new Error(`Erro na API: ${response.status} - ${errorText}`);
    }

    const result = await response.json();

    // Verifica se a resposta tem a estrutura esperada
    if (!result || typeof result !== 'object') {
        throw new Error("Resposta da API inválida");
    }

    // Algumas APIs retornam sucesso sem status 200
    if (result.status && result.status !== 200) {
        throw new Error(result.message || "Autores não encontrados");
    }

    // Se não houver status, assume que o array direto é os dados
    const authorsData = result.data || result;

    if (!Array.isArray(authorsData)) {
        throw new Error("Formato de dados de autores inválido");
    }

    return authorsData;
}


function populateBookForm(bookData) {
    document.getElementById("bookTitle").textContent = `Livro - ${bookData.titulo}`;
    document.getElementById("id").value = bookData.id;
    document.getElementById("title").value = bookData.titulo;
    document.getElementById("isbn").value = bookData.isbn;
    document.getElementById("releaseYear").value = bookData.ano_lancamento;
    document.getElementById("language").value = bookData.idioma;
    document.getElementById("quantity").value = bookData.quantidade;
    document.getElementById("publisher").value = bookData.editora_fk;
    document.getElementById("category").value = bookData.categoria_fk;
    document.getElementById("subcategory").value = bookData.subcategoria_fk;
    document.getElementById("synopsis").value = bookData.sinopse;

    const activeBadge = document.getElementById("active");
    activeBadge.textContent = bookData.ativo === "Y" ? "Ativo" : "Inativo";
    activeBadge.classList.toggle("bg-success", bookData.ativo === "Y");
    activeBadge.classList.toggle("bg-danger", bookData.ativo === "N");
}

// Função para preencher os selects (comboboxes)
async function populateSelectFields(bookData) {
    await Promise.all([
        fetchSelect(`${API_ENDPOINTS.PUBLISHER}${bookData.editora_fk}`, 'editora', "publisher", bookData.editora_fk),
        fetchSelect(`${API_ENDPOINTS.CATEGORY}${bookData.categoria_fk}`, 'categoria', "category", bookData.categoria_fk),
        fetchSelect(`${API_ENDPOINTS.SUBCATEGORY}${bookData.subcategoria_fk}`, 'subcategoria', "subcategory", bookData.subcategoria_fk)
    ]);
}

function createAuthorsCheckboxes(allAuthors, associatedAuthors) {
    const authorsCheckboxesDiv = document.getElementById("authorsCheckboxes");
    authorsCheckboxesDiv.innerHTML = "";

    if (!Array.isArray(allAuthors)) {
        console.error('allAuthors não é um array:', allAuthors);
        authorsCheckboxesDiv.innerHTML = `
            <div class="alert alert-danger">
                Dados de autores inválidos
            </div>
        `;
        return;
    }

    const associatedAuthorIds = new Set(
        Array.isArray(associatedAuthors)
            ? associatedAuthors.map(author => author?.autor_fk).filter(Boolean)
            : []
    );

    const sortedAuthors = [...allAuthors].sort((a, b) => {
        const nameA = String(a?.nome_completo || '').toLowerCase();
        const nameB = String(b?.nome_completo || '').toLowerCase();
        return nameA.localeCompare(nameB);
    });

    if (sortedAuthors.length === 0) {
        authorsCheckboxesDiv.innerHTML = `
            <div class="alert alert-info">
                Nenhum autor disponível para seleção
            </div>
        `;
        return;
    }

    const getFullName = (author) => {
        const firstName = author?.primeiro_nome || '';
        const lastName = author?.ultimo_nome || '';

        return `${firstName.trim()} ${lastName.trim()}`.trim();
    };

    sortedAuthors.forEach(author => {
        if (!author?.id) {
            console.warn('Autor sem ID válido:', author);
            return;
        }

        const checkboxId = `author_${author.id}`;
        const isChecked = associatedAuthorIds.has(author.id);
        const authorName = getFullName(author) || 'Autor sem nome';

        const wrapper = document.createElement("div");
        wrapper.classList.add("form-check", "mb-2");

        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.classList.add("form-check-input");
        checkbox.id = checkboxId;
        checkbox.name = "authors[]";
        checkbox.value = author.id;
        checkbox.checked = isChecked;
        checkbox.addEventListener('change', updateAuthorsDropdownText);

        const label = document.createElement("label");
        label.classList.add("form-check-label");
        label.htmlFor = checkboxId;
        label.textContent = authorName;

        wrapper.append(checkbox, label);
        authorsCheckboxesDiv.appendChild(wrapper);
    });

    updateAuthorsDropdownText();
}

function updateAuthorsDropdownText() {
    const authorsDropdownBtn = document.getElementById('authorsDropdown');
    const checkedBoxes = document.querySelectorAll('#authorsCheckboxes input[type="checkbox"]:checked');

    if (checkedBoxes.length === 0) {
        authorsDropdownBtn.textContent = 'Selecionar autores';
    } else if (checkedBoxes.length === 1) {
        const label = document.querySelector(`label[for="${checkedBoxes[0].id}"]`);
        authorsDropdownBtn.textContent = label ? label.textContent.trim() : '1 autor selecionado';
    } else {
        authorsDropdownBtn.textContent = `${checkedBoxes.length} autores selecionados`;
    }
}