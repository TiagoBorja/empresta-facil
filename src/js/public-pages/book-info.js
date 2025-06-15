import { fetchSelect } from '../utils/utils.js';

const API_ENDPOINTS = {
    BOOK: '../administrative/book/code.php',
    LOCATION: './api/book-location-api.php',
    AUTHOR_BOOK: '../administrative/author-book/code.php'
};

const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get("id");

let bookValue = {};

document.addEventListener('DOMContentLoaded', async function () {
    fillFormData(id);

    const reservationBtn = document.getElementById("reservationBtn");
    const modalElement = document.getElementById("reservationModal");
    const modalHeader = document.getElementById("reservationTitle");

    const reservationModal = new bootstrap.Modal(modalElement);

    reservationBtn.addEventListener('click', () => {
        reservationModal.show();

        modalHeader.textContent = `Reservar - ${bookValue.titulo}`;

        fetchSelect(`${API_ENDPOINTS.LOCATION}?id=${id}`, 'nome', "librarySelect")
    });
});

async function fillFormData(bookId) {
    try {
        const [bookResponse, bookLocationsResponse, authorBookResponse] = await Promise.all([
            fetch(`${API_ENDPOINTS.BOOK}?id=${bookId}`),
            fetch(`${API_ENDPOINTS.LOCATION}?id=${bookId}`),
            fetch(`${API_ENDPOINTS.AUTHOR_BOOK}?id=${bookId}`)
        ]);

        if (!bookResponse.ok || !authorBookResponse.ok || !bookLocationsResponse.ok) {
            throw new Error("Erro na requisição");
        }

        const book = await bookResponse.json();
        const authors = await authorBookResponse.json();
        const locations = await bookLocationsResponse.json();

        if (book.status === 200 && authors.status === 200 && locations.status === 200) {
            bookValue = book.data;
            const authorList = authors.data;
            const bookLocations = locations.data;

            document.getElementById("bookTitle").textContent = bookValue.titulo;
            document.getElementById("bookYear").textContent = bookValue.ano_lancamento;
            document.getElementById("bookLanguage").textContent = bookValue.idioma;
            document.getElementById("bookISBN").textContent = bookValue.isbn;
            document.getElementById("bookPublisher").textContent = bookValue.editora;
            document.getElementById("bookSynopsis").textContent = bookValue.sinopse;
            document.getElementById("bookRating").textContent = bookValue.avaliacao;
            document.getElementById("bookCover").src = bookValue.imagem || "../public/assets/images/big/img1.jpg";

            const authorContainer = document.getElementById("bookAuthor");
            showAuthors(authorContainer, authorList)

            const locationsTableBody = document.getElementById("locationsTableBody");
            showLocations(locationsTableBody, bookLocations);
        }
    } catch (error) {
        console.error("Erro:", error);
        toastr.error("Erro ao carregar o livro.");
    }
}

function showAuthors(authorContainer, authorList) {
    authorContainer.textContent = "";
    authorList.forEach((autor, index) => {
        const span = document.createElement("span");
        span.textContent = autor.nome_completo;
        if (index < authorList.length - 1) span.textContent += ", ";
        authorContainer.appendChild(span);
    });
}

function showLocations(locationsTableBody, bookLocations) {
    locationsTableBody.innerHTML = "";

    bookLocations.forEach(location => {
        const tr = document.createElement("tr");
        tr.classList.add("border-bottom", "border-dark");

        const tdLibrary = document.createElement("td");
        tdLibrary.classList.add("fw-normal", "text-dark");
        tdLibrary.textContent = location.nome;

        const tdAddress = document.createElement("td");
        tdAddress.classList.add("fw-normal", "text-dark");
        tdAddress.textContent = location.morada;

        const tdLocalCode = document.createElement("td");
        tdLocalCode.classList.add("fw-normal", "text-dark");
        tdLocalCode.textContent = location.cod_local;

        const tdQuantity = document.createElement("td");
        tdQuantity.classList.add("fw-normal", "text-dark");
        tdQuantity.textContent = location.quantidade;

        tr.appendChild(tdLibrary);
        tr.appendChild(tdAddress);
        tr.appendChild(tdLocalCode);
        tr.appendChild(tdQuantity);

        locationsTableBody.appendChild(tr);
    });
}