import * as utils from '../utils/utils.js';

const API_ENDPOINTS = {
    BOOK: './book/code.php',
    BOOK_LOCATION: '../php/api/book-location-api.php',
    LIBRARY: './library/code.php',
    LOCATION: './location/code.php',
    USER: './users/code.php',
};

let urlParams = new URLSearchParams(window.location.search);
let id = urlParams.get("id");

document.addEventListener('DOMContentLoaded', async function () {

    try {
        const response = await fetch(`${API_ENDPOINTS.BOOK_LOCATION}?id=${id}`);

        if (!response.ok) throw new Error("Erro na requisição");

        const result = await response.json();
        console.log(result);

        if (result.status === 200) {
            const bookLocationTitle = document.getElementById("bookLocationTitle");
            if (bookLocationTitle) {
                const codLocal = result?.data?.cod_local ?? 'Código Local';
                const titulo = result?.data?.titulo ?? 'Título não definido';
                bookLocationTitle.textContent = `${codLocal} - ${titulo}`;
            }
            document.getElementById("id").value = result.data.livro_localizacao_fk;

            await utils.fetchSelect(API_ENDPOINTS.LOCATION, "cod_local - nome", "locations", result.data.loc_fk);
            await utils.fetchSelect(API_ENDPOINTS.BOOK, "titulo", "book", result.data.id);

            const userLibrary = result.data.biblioteca_utilizador_fk;
        }
    } catch (error) {
        toastr.error(error, "Erro!");
    }
});