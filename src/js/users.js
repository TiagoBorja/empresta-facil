import * as bdUtils from './bd-utils.js';
import * as utils from './utils.js';
const API_URL = '../administrative/users/code.php';
const ROLE_API_URL = '../administrative/user-roles/code.php';

document.addEventListener("DOMContentLoaded", async function () {
    try {
        // Envia a requisição GET para o PHP
        const response = await fetch(ROLE_API_URL); // ROLE_API_URL deve apontar para o arquivo code.php

        // Verifica se a resposta foi bem-sucedida
        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.statusText);
        }

        // Processa a resposta como JSON
        const result = await response.json();

        // Verifica se há dados ou erro na resposta
        if (result.error) {
            console.error(result.error);
        } else {
            // Exibe os dados no console ou manipula-os da forma que precisar
            console.log(result);
        }
    } catch (error) {
        console.error('Erro ao fazer requisição:', error);
    }
});

