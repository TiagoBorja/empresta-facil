const BOOK_API_URL = '../administrative/book/code.php';
const BOOK_LOCATIONS = './api/book-location-api.php';
const AUTHOR_BOOK_API_URL = '../administrative/author-book/code.php';

document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    try {
        const [bookResponse, bookLocationsResponse, authorBookResponse] = await Promise.all([
            fetch(`${BOOK_API_URL}?id=${id}`),
            fetch(`${BOOK_LOCATIONS}?id=${id}`),
            fetch(`${AUTHOR_BOOK_API_URL}?id=${id}`)
        ]);

        if (!bookResponse.ok || !authorBookResponse.ok || !bookLocationsResponse.ok) {
            throw new Error("Erro na requisição");
        }

        const book = await bookResponse.json();
        const authors = await authorBookResponse.json();
        const locations = await bookLocationsResponse.json();

        if (book.status === 200 && authors.status === 200 && locations.status === 200) {
            const bookValue = book.data;
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
});

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

        const tdLocation = document.createElement("td");
        tdLocation.classList.add("fw-normal", "text-dark");
        tdLocation.textContent = location.nome;

        const tdLocalCode = document.createElement("td");
        tdLocalCode.classList.add("fw-normal", "text-dark");
        tdLocalCode.textContent = location.cod_local;

        const tdQuantity = document.createElement("td");
        tdQuantity.classList.add("fw-normal", "text-dark");
        tdQuantity.textContent = location.quantidade; // ajuste o nome da propriedade se necessário

        tr.appendChild(tdLocation);
        tr.appendChild(tdLocalCode);
        tr.appendChild(tdQuantity);

        locationsTableBody.appendChild(tr);
    });
}