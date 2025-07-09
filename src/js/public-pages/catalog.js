const BOOK_API_URL = '../administrative/book/code.php';
const AUTHOR_BOOK_API_URL = '../administrative/author-book/code.php';
const DEFAULT_BOOK_IMAGE = '../public/assets/images/no-book-image.jpg';

let urlParams;
let id;
let enrichedBooks = [];
document.addEventListener("DOMContentLoaded", async () => {
    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    const mostRequested = urlParams.get("mostRequested");
    if (mostRequested !== null && mostRequested !== undefined) {
        getMostRequested();
        return;
    }
    const userRecommend = urlParams.get("userRecommend");
    if (userRecommend !== null && userRecommend !== undefined) {
        getUserRecommends();
        return;
    }
    getAll();
});

async function getAll() {
    try {
        const [bookResponse, authorBookResponse] = await Promise.all([
            fetch(BOOK_API_URL),
            fetch(AUTHOR_BOOK_API_URL)
        ]);

        if (!bookResponse.ok || !authorBookResponse.ok) {
            throw new Error("Erro nas respostas das APIs");
        }

        const books = await bookResponse.json();
        const authorLinks = await authorBookResponse.json();

        const authorsByBook = {};
        authorLinks.forEach((item) => {
            if (!authorsByBook[item.livro_fk]) {
                authorsByBook[item.livro_fk] = [];
            }
            authorsByBook[item.livro_fk].push(item.nome_completo);
        });

        enrichedBooks = books.map(book => {
            const autores = authorsByBook[book.id] || ['Autor desconhecido'];
            return {
                ...book,
                autor: autores.join(', ')
            };
        });

        showBooks(enrichedBooks);
        setupSearchFilter(); // Configura os listeners de pesquisa

    } catch (error) {
        console.error("Erro ao obter dados:", error);
        toastr.warning("Não foi possível carregar os dados. Tenta novamente mais tarde.", "Atenção!");
    }
}


async function getMostRequested() {
    try {
        const [bookResponse, authorBookResponse] = await Promise.all([
            fetch(`${BOOK_API_URL}?mostRequested=true`),
            fetch(AUTHOR_BOOK_API_URL)
        ]);

        if (!bookResponse.ok || !authorBookResponse.ok) {
            throw new Error("Erro nas respostas das APIs");
        }

        const books = await bookResponse.json();
        console.log(books);

        const authorLinks = await authorBookResponse.json();

        const authorsByBook = {};
        authorLinks.forEach((item) => {
            if (!authorsByBook[item.livro_fk]) {
                authorsByBook[item.livro_fk] = [];
            }
            authorsByBook[item.livro_fk].push(item.nome_completo);
        });

        enrichedBooks = books.map(book => {
            const autores = authorsByBook[book.id] || ['Autor desconhecido'];
            return {
                ...book,
                autor: autores.join(', ')
            };
        });

        showMostRequested(enrichedBooks);

    } catch (error) {
        console.error("Erro ao obter dados:", error);
        toastr.warning("Não foi possível carregar os dados. Tenta novamente mais tarde.", "Atenção!");
    }
}

async function getUserRecommends() {
    try {
        const [bookResponse, authorBookResponse] = await Promise.all([
            fetch(`${BOOK_API_URL}?userRecommend=true`),
            fetch(AUTHOR_BOOK_API_URL)
        ]);

        if (!bookResponse.ok || !authorBookResponse.ok) {
            throw new Error("Erro nas respostas das APIs");
        }

        const booksData = await bookResponse.json();
        const authorLinks = await authorBookResponse.json();

        // Verifica se não há recomendações (status 204)
        if (booksData.status === 204) {
            toastr.info(booksData.message, "Sem recomendações");
            showEmptyRecommendationsMessage(); // <-- opcional: pode criar esta função para mostrar algo visual
            return;
        }

        const authorsByBook = {};
        authorLinks.forEach((item) => {
            if (!authorsByBook[item.livro_fk]) {
                authorsByBook[item.livro_fk] = [];
            }
            authorsByBook[item.livro_fk].push(item.nome_completo);
        });

        enrichedBooks = booksData.data.map(book => {
            const autores = authorsByBook[book.id] || ['Autor desconhecido'];
            return {
                ...book,
                autor: autores.join(', ')
            };
        });

        showBooks(enrichedBooks);

    } catch (error) {
        console.error("Erro ao obter dados:", error);
        toastr.warning("Não foi possível carregar os dados. Tenta novamente mais tarde.", "Atenção!");
    }
}


function showBooks(books) {
    const bookContainer = document.getElementById('bookInfo');
    bookContainer.innerHTML = '';

    if (!books.length) {
        bookContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="mdi mdi-book-remove-outline display-4 text-muted"></i>
                <p class="mt-3">Nenhum livro encontrado</p>
            </div>`;
        return;
    }

    bookContainer.append(...books.map(book => {
        const card = document.createElement('div');
        card.className = 'col-lg-4 col-md-6 mb-3';

        card.innerHTML = `
            <div class="card shadow-lg">
                <div class="el-card-item position-relative">
                    <div class="el-card-avatar el-overlay-1">
                        <img src="../administrative/book/upload/${book.img_url || DEFAULT_BOOK_IMAGE}" 
                             alt="Capa do livro" 
                             class="card-img-top" 
                             style="height: 200px; object-fit: cover;">
                    </div>
                    <div class="el-card-content p-3">
                        <a class="h5 d-block text-dark fw-semibold mb-1 text-decoration-none" href="?page=book-info&id=${book.id}">
                            ${book.titulo}
                        </a>
                        <span class="text-muted small d-block mb-2">${book.autor}</span>
                        <div class="mt-2">
                            ${book.categoria ? `<span class="badge bg-primary">${book.categoria}</span>` : ''}
                            ${book.subcategoria ? `<span class="badge bg-secondary">${book.subcategoria}</span>` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;

        return card;
    }));
}

function showMostRequested(books) {
    const bookContainer = document.getElementById('bookInfo');
    bookContainer.innerHTML = '';

    if (!books.length) {
        bookContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="mdi mdi-book-remove-outline display-4 text-muted"></i>
                <p class="mt-3">Nenhum livro mais requisitado encontrado</p>
            </div>`;
        return;
    }

    bookContainer.append(...books.map(book => {
        const card = document.createElement('div');
        card.className = 'col-lg-4 col-md-6 mb-3';

        card.innerHTML = `
            <div class="card shadow-lg">
                <div class="el-card-item position-relative">
                    <div class="el-card-avatar el-overlay-1">
                        <img src="../administrative/book/upload/${book.img_url ?? DEFAULT_BOOK_IMAGE}" 
                             alt="Capa do livro" 
                             class="card-img-top" 
                             style="height: 200px; object-fit: cover;">
                        ${book.total_emprestimos ? `
                        <span class="position-absolute top-0 start-0 badge bg-danger m-2">
                            <i class="mdi mdi-fire"></i> ${book.total_emprestimos} empréstimos
                        </span>` : ''}
                    </div>
                    <div class="el-card-content p-3">
                        <a class="h5 d-block text-dark fw-semibold mb-1 text-decoration-none" href="?page=book-info&id=${book.id}">
                            ${book.titulo}
                        </a>
                        <span class="text-muted small d-block mb-2">${book.autor}</span>
                        <div class="mt-2">
                            ${book.categoria ? `<span class="badge bg-primary">${book.categoria}</span>` : ''}
                            ${book.subcategoria ? `<span class="badge bg-secondary">${book.subcategoria}</span>` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;

        return card;
    }));
}

function showUserRecommends(books) {
    const bookContainer = document.getElementById('bookInfo');
    bookContainer.innerHTML = '';

    if (!books.length) {
        bookContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="mdi mdi-book-remove-outline display-4 text-muted"></i>
                <p class="mt-3">Nenhum livro encontrado</p>
            </div>`;
        return;
    }

    bookContainer.append(...books.map(book => {
        const card = document.createElement('div');
        card.className = 'col-lg-4 col-md-6 mb-3';

        card.innerHTML = `
            <div class="card shadow-lg">
                <div class="el-card-item position-relative">
                    <div class="el-card-avatar el-overlay-1">
                        <img src="../administrative/book/upload/${book.img_url || DEFAULT_BOOK_IMAGE}" 
                             alt="Capa do livro" 
                             class="card-img-top" 
                             style="height: 200px; object-fit: cover;">
                    </div>
                    <div class="el-card-content p-3">
                        <a class="h5 d-block text-dark fw-semibold mb-1 text-decoration-none" href="?page=book-info&id=${book.id}">
                            ${book.titulo}
                        </a>
                        <span class="text-muted small d-block mb-2">${book.autor}</span>
                        <div class="mt-2">
                            ${book.categoria ? `<span class="badge bg-primary">${book.categoria}</span>` : ''}
                            ${book.subcategoria ? `<span class="badge bg-secondary">${book.subcategoria}</span>` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;

        return card;
    }));
}

function showEmptyRecommendationsMessage() {
    const container = document.getElementById("bookInfo");
    container.innerHTML = `
        <div class="alert alert-info w-100 text-center">
            Ainda não temos recomendações para si. <br>
            Reserve ou levante um livro para começar a receber sugestões personalizadas!
        </div>
    `;
}

function getPlaceholderText(filter) {
    switch (filter) {
        case 'categoria':
            return 'Pesquisar por categoria...';
        case 'autor':
            return 'Pesquisar por autor...';
        case 'título':
            return 'Pesquisar por título...';
        default:
            return 'Pesquisar por título, autor, título...';
    }
}
function setupSearchFilter() {
    const filterDropdown = document.getElementById('filterDropdown');
    const dropdownItems = document.querySelectorAll('.dropdown-item[data-filter]');
    const searchInput = document.getElementById('searchInput');

    let currentFilter = 'geral'; // Filtro padrão

    // Atualiza o dropdown quando um filtro é selecionado
    dropdownItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            currentFilter = item.getAttribute('data-filter');
            filterDropdown.textContent = item.textContent;

            // Atualiza o placeholder com base no filtro selecionado
            const placeholderText = getPlaceholderText(currentFilter);
            searchInput.placeholder = placeholderText;

            // Dispara a pesquisa se já houver texto no input
            if (searchInput.value.trim()) {
                filterBooks(currentFilter, searchInput.value.trim());
            }
        });
    });

    // Listener para o input de pesquisa
    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.trim();
        filterBooks(currentFilter, searchTerm);
    });
}
// Função principal de filtragem
function filterBooks(filterType, searchTerm) {
    if (!searchTerm) {
        showBooks(enrichedBooks);
        return;
    }

    const filteredBooks = enrichedBooks.filter(book => {
        const searchTermLower = searchTerm.toLowerCase();

        switch (filterType) {
            case 'categoria':
                return (book.categoria && book.categoria.toLowerCase().includes(searchTermLower)) ||
                    (book.subcategoria && book.subcategoria.toLowerCase().includes(searchTermLower));
            case 'autor':
                return book.autor.toLowerCase().includes(searchTermLower);
            case 'titulo':
                // Assumindo que 'titulo' pode ser buscado no título ou descrição
                return book.titulo.toLowerCase().includes(searchTermLower) ||
                    (book.descricao && book.descricao.toLowerCase().includes(searchTermLower));
            default: // 'geral'
                return (
                    book.titulo.toLowerCase().includes(searchTermLower) ||
                    book.autor.toLowerCase().includes(searchTermLower) ||
                    (book.categoria && book.categoria.toLowerCase().includes(searchTermLower)) ||
                    (book.subcategoria && book.subcategoria.toLowerCase().includes(searchTermLower)) ||
                    (book.descricao && book.descricao.toLowerCase().includes(searchTermLower))
                );
        }
    });

    showBooks(filteredBooks);
}