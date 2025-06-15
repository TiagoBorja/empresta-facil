import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';

const BOOK_API_URL = '../administrative/book/code.php';
const AUTHOR_BOOK_API_URL = '../administrative/author-book/code.php';

let urlParams;
let id;

document.addEventListener("DOMContentLoaded", async () => {
    getAll();
});

async function getAll() {
    try {
        const [bookResponse, authorBookResponse] = await Promise.all([
            fetch(BOOK_API_URL),
            fetch(`${AUTHOR_BOOK_API_URL}`)
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
            console.log(authorsByBook);
            console.log(book.id);


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
                        <img src="${book.imagem || '../public/assets/images/big/img1.jpg'}" alt="Capa do livro" class="card-img-top">
                    </div>
                    <div class="el-card-content p-3">
                        <a class="h5 d-block text-dark fw-semibold mb-1 text-decoration-none" href="?page=view-info&id=${book.id}">
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


