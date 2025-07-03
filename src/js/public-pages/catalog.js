const BOOK_API_URL = '../administrative/book/code.php';
const AUTHOR_BOOK_API_URL = '../administrative/author-book/code.php';
const DEFAULT_BOOK_IMAGE = '../public/assets/images/big/img1.jpg';
let urlParams;
let id;

document.addEventListener("DOMContentLoaded", async () => {
    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    const mostRequested = urlParams.get("mostRequested");
    if (mostRequested !== null || mostRequested !== undefined) {
        getMostRequested();
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

        const enrichedBooks = books.map(book => {
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

        const enrichedBooks = books.map(book => {
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

    books.forEach((book) => {
        const card = document.createElement('div');
        card.className = 'col-lg-4 col-md-6 mb-3';

        card.innerHTML = `
            <div class="card shadow-lg">
                <div class="el-card-item">
                    <div class="el-card-avatar el-overlay-1">
                        <img src="${book.imagem || DEFAULT_BOOK_IMAGE}" alt="Capa do livro" class="card-img-top">
                    </div>
                    <div class="el-card-content p-3">
                        <a class="h5 d-block text-dark fw-semibold mb-1 text-decoration-none" href="?page=book-info&id=${book.id}">
                            ${book.titulo}
                        </a>
                        <span class="text-muted small d-block mb-2">${book.autor}</span>
                        <div class="mt-2">
                            <span class="badge bg-primary">${book.categoria}</span>
                            <span class="badge bg-secondary">${book.subcategoria}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;

        bookContainer.appendChild(card);
    });
}

function showMostRequested(books) {
    const bookContainer = document.getElementById('bookInfo');
    bookContainer.innerHTML = '';

    if (!books.length) {
        bookContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="mdi mdi-book-remove-outline display-4 text-muted"></i>
                <p class="mt-3">No most requested books found</p>
            </div>`;
        return;
    }

    bookContainer.append(...books.map(book => {
        const card = document.createElement('div');
        card.className = 'col-lg-4 col-md-6 mb-4';

        card.innerHTML = `
            <div class="card h-100 shadow-sm">
                <div class="position-relative">
                    <img src="${book.imagem || DEFAULT_BOOK_IMAGE}" 
                         alt="Cover of ${book.titulo}" 
                         class="card-img-top" 
                         style="height: 200px; object-fit: cover;">
                    ${book.requestCount ? `
                    <span class="position-absolute top-0 start-0 badge bg-danger m-2">
                        <i class="mdi mdi-fire"></i> ${book.requestCount} requests
                    </span>` : ''}
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">
                        <a href="?page=book-info&id=${book.id}" class="text-decoration-none">
                            ${book.titulo}
                        </a>
                    </h5>
                    <p class="card-text text-muted small">${book.autor}</p>
                    <div class="mt-auto">
                        <div class="d-flex flex-wrap gap-1">
                            ${book.categoria ? `<span class="badge bg-primary">${book.categoria}</span>` : ''}
                            ${book.subcategoria ? `<span class="badge bg-secondary">${book.subcategoria}</span>` : ''}
                        </div>
                    </div>
                </div>
            </div>`;

        return card;
    }));
}


