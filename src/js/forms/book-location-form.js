import * as utils from '../utils/utils.js';

const API_ENDPOINTS = {
    BOOK: './book/code.php',
    BOOK_LOCATION: '../php/api/book-location-api.php',
    LOCATION: './location/code.php',
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
                const codLocal = result?.data[0]?.cod_local ?? 'Código Local';
                const titulo = result?.data[0]?.titulo ?? 'Título não definido';
                bookLocationTitle.textContent = `${codLocal} - ${titulo}`;
            }
            document.getElementById("id").value = result.data[0].livro_localizacao_fk;
            document.getElementById("quantity").value = result.data[0].quantidade;

            await utils.fetchSelect(`${API_ENDPOINTS.LOCATION}?activeOnly=true`, "cod_local - nome", "locations", result.data[0].loc_fk);
            await utils.fetchSelect(API_ENDPOINTS.BOOK, "titulo", "book", result.data.id);
        }
    } catch (error) {
        toastr.error(error, "Erro!");
    }
});