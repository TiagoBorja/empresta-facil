const BOOK_API_URL = '../administrative/book/code.php';
const AUTHOR_BOOK_API_URL = '../administrative/author-book/code.php';

document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    try {

        const [bookResponse, authorBookResponse] = await Promise.all([
            fetch(`${BOOK_API_URL}?id=${id}`),
            fetch(`${AUTHOR_BOOK_API_URL}?id=${id}`)
        ]);

        if (!bookResponse.ok || !authorBookResponse.ok) throw new Error("Erro na requisição");

        const book = await bookResponse.json();
        const authors = await authorBookResponse.json();

        if (book.status === 200 & authors.status === 200) {
            const bookValue = book.data;
            const authorList = authors.data;


            document.getElementById("bookTitle").textContent = bookValue.titulo;
            document.getElementById("bookYear").textContent = bookValue.ano_lancamento;
            document.getElementById("bookLanguage").textContent = bookValue.idioma;
            document.getElementById("bookISBN").textContent = bookValue.isbn;
            document.getElementById("bookPublisher").textContent = bookValue.editora;
            document.getElementById("bookSynopsis").textContent = bookValue.sinopse;
            document.getElementById("bookRating").textContent = bookValue.avaliacao;
            document.getElementById("bookCover").src = bookValue.imagem || "../public/assets/images/big/img1.jpg";

            const authorContainer = document.getElementById("bookAuthor");
            authorContainer.textContent = "";

            authorList.forEach((autor, index) => {
                const span = document.createElement("span");
                span.textContent = autor.nome_completo;

                if (index < authorList.length - 1) span.textContent += ", ";

                authorContainer.appendChild(span)
            });
        }
    } catch (error) {
        console.error("Erro:", error);
        toastr.error("Erro ao carregar o livro.");
    }
});
