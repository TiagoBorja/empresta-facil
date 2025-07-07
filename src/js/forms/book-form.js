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

    const urlParams = new URLSearchParams(window.location.search);
    const bookId = urlParams.get("id");
    const isEditMode = bookId !== null; // Se tem ID, está editando
    try {
        if (!isEditMode) {
            const allAuthorsData = await fetchAllAuthorsData();
            createAuthorsCheckboxes(allAuthorsData, []); // Array vazio para autores associados
        } else {
            const [bookData, authorBookData, allAuthorsData] = await Promise.all([
                fetchBookData(bookId),
                fetchAuthorBookData(bookId),
                fetchAllAuthorsData()
            ]);

            populateBookForm(bookData);
            await populateSelectFields(bookData);
            createAuthorsCheckboxes(allAuthorsData, authorBookData);
        }


        showContentAfterLoading("loading", ["content"]);
    } catch (error) {
        toastr.error(error.message || "Erro ao carregar dados", "Erro!");
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

    if (!result || typeof result !== 'object') {
        throw new Error("Resposta da API inválida");
    }

    if (result.status && result.status !== 200) {
        throw new Error(result.message || "Autores não encontrados");
    }

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
    document.getElementById("publisher").value = bookData.editora_fk;
    document.getElementById("category").value = bookData.categoria_fk;
    document.getElementById("subcategory").value = bookData.subcategoria_fk;
    document.getElementById("synopsis").value = bookData.sinopse;
    
    const bookPreviewEl = document.getElementById("bookPreview");
    bookPreviewEl.src = `./book/upload/${bookData.img_url}`;

    const activeBadge = document.getElementById("active");
    activeBadge.textContent = bookData.ativo === "Y" ? "Ativo" : "Inativo";
    activeBadge.classList.toggle("bg-success", bookData.ativo === "Y");
    activeBadge.classList.toggle("bg-danger", bookData.ativo === "N");
}

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
        authorsCheckboxesDiv.innerHTML = `
            <div class="alert alert-danger">
                Dados de autores inválidos
            </div>
        `;
        return;
    }

    const searchGroup = document.createElement('div');
    searchGroup.className = 'input-group mb-3';

    const searchIcon = document.createElement('span');
    searchIcon.className = 'input-group-text';
    searchIcon.innerHTML = `
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
        </svg>
    `;

    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.id = 'authorSearch';
    searchInput.className = 'form-control';
    searchInput.placeholder = 'Buscar autores...';

    searchGroup.appendChild(searchIcon);
    searchGroup.appendChild(searchInput);

    authorsCheckboxesDiv.appendChild(searchGroup);

    const divider = document.createElement("hr");
    divider.className = "my-2"; // Bootstrap: margem vertical
    authorsCheckboxesDiv.appendChild(divider);


    const getFullName = (author) => {
        const firstName = author?.primeiro_nome || '';
        const lastName = author?.ultimo_nome || '';
        return `${firstName.trim()} ${lastName.trim()}`.trim();
    };

    const sortedAuthors = [...allAuthors].sort((a, b) => {
        const nameA = getFullName(a).toLowerCase();
        const nameB = getFullName(b).toLowerCase();
        return nameA.localeCompare(nameB);
    });

    if (sortedAuthors.length === 0) {
        authorsCheckboxesDiv.innerHTML += `
            <div class="alert alert-info">
                Nenhum autor disponível
            </div>
        `;
        return;
    }

    const associatedAuthorIds = new Set(
        associatedAuthors.map(author => author?.autor_fk).filter(Boolean)
    );

    sortedAuthors.forEach(author => {
        if (!author?.id) return;

        const checkboxId = `author_${author.id}`;
        const isChecked = associatedAuthorIds.has(author.id);
        const authorName = getFullName(author) || 'Autor sem nome';

        const wrapper = document.createElement("div");
        wrapper.classList.add("form-check", "mb-2", "px-3");

        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.classList.add("form-check-input");
        checkbox.id = checkboxId;
        checkbox.name = "authors[]";
        checkbox.value = author.id;
        checkbox.checked = isChecked;
        checkbox.addEventListener('change', updateAuthorsDropdownText);

        const label = document.createElement("label");
        label.classList.add("form-check-label", "w-100");
        label.htmlFor = checkboxId;
        label.textContent = authorName;

        wrapper.append(checkbox, label);
        authorsCheckboxesDiv.appendChild(wrapper);
    });

    searchInput.addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const checkboxes = authorsCheckboxesDiv.querySelectorAll('.form-check');

        checkboxes.forEach(wrapper => {
            if (wrapper.classList.contains('input-group')) return; // Pular o campo de busca

            const label = wrapper.querySelector('.form-check-label');
            if (label) {
                const text = label.textContent.toLowerCase();
                wrapper.style.display = text.includes(searchTerm) ? 'block' : 'none';
            }
        });
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