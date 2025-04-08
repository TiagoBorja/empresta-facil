import * as bdUtils from './bd-utils.js';
import * as utils from './utils.js';
const API_URL = '../administrative/users/code.php';
const ROLE_API_URL = '../administrative/user-roles/code.php';

document.addEventListener("DOMContentLoaded", async function () {
    try {
        const response = await fetch(ROLE_API_URL);

        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.statusText);
        }

        const result = await response.json();


        if (result.error) {
            console.error(result.error);
        } else {
            console.log(result);
        }
    } catch (error) {
        console.error('Erro ao fazer requisição:', error);
    }
});

