import * as utils from '../utils/utils.js';

const API_ENDPOINTS = {
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
            document.getElementById("bookLocationTitle").textContent = `${result.data.cod_local} - ${result.data.titulo}`;
            document.getElementById("id").value = result.data.livro_localizacao_fk;

            await utils.fetchSelect(API_ENDPOINTS.LOCATION, "cod_local", "locations", result.data.loc_fk);
            await utils.fetchSelect(API_ENDPOINTS.BOOK_LOCATION, "titulo", "book", result.data.id);

            const userLibrary = result.data.biblioteca_utilizador_fk;

            if (userLibrary !== null) {
                await utils.fetchSelect(API_ENDPOINTS.LIBRARY, "nome", "library", userLibrary, true);
            } else {
                await utils.fetchSelect(API_ENDPOINTS.LIBRARY, "nome", "library", result.data.biblioteca_fk);
            }
        }
    } catch (error) {
        toastr.error(error, "Erro!");
    }
});