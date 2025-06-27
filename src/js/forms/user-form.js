import * as utils from '../utils/utils.js';

const ROLE_API_URL = '../administrative/user-roles/code.php';
const LIBRARY_API_URL = '../administrative/library/code.php';
const USER_LIBRARY_API_URL = '../php/api/user-library-api.php';
const checkBoxConfig = {
    containerId: 'librariesCheckboxes',
    nameField: 'nome',
    idField: 'id',
    valueField: 'id',
    checkboxName: 'libraries[]',
    dropdownButtonId: 'librariesDropdown',
    singularLabel: 'biblioteca',
    pluralLabel: 'bibliotecas',
    associationField: 'biblioteca_fk'
}


document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    const isEditMode = id !== null;

    try {
        if (!isEditMode) {
            const allLibrariesData = await fetchAllLibrariesData();
            utils.createGenericCheckboxes(allLibrariesData, [], checkBoxConfig);
            document.getElementById("password").classList.remove("d-none");
        } else {
            const response = await fetch(`../administrative/users/code.php?id=${id}`);
            if (!response.ok) throw new Error("Erro na requisição");

            const result = await response.json();

            if (result.status === 200) {
                const data = result.data;
                document.getElementById("userName").textContent = `Utilizador - ${data.primeiro_nome} ${data.ultimo_nome}`;
                document.getElementById("id").value = data.id;
                document.getElementById("firstName").value = data.primeiro_nome;
                document.getElementById("lastName").value = data.ultimo_nome;
                document.getElementById("nif").value = data.nif;
                document.getElementById("cc").value = data.cc;
                document.getElementById("gender").value = data.genero;
                document.getElementById("birthDay").value = data.data_nascimento;
                document.getElementById("address").value = data.morada;
                document.getElementById("phoneNumber").value = data.telemovel;
                document.getElementById("email").value = data.email;
                document.getElementById("username").value = data.nome_utilizador;

                const passwordEl = document.getElementById("password");
                passwordEl.disabled = true;
                document.getElementById("profilePreview").src = `./users/${data.img_url}`;

                const activeBadge = document.getElementById("active");
                activeBadge.textContent = data.ativo === "Y" ? "Ativo" : "Inativo";
                activeBadge.classList.toggle("bg-success", data.ativo === "Y");
                activeBadge.classList.toggle("bg-danger", data.ativo === "N");

                await utils.fetchSelect(ROLE_API_URL, 'tipo', "roleSelect", data.tipo_utilizador_fk);

                const allLibrariesData = await fetchAllLibrariesData();
                const userLibraries = await fetchAllUserLibrariesData(data.id);

                utils.createGenericCheckboxes(allLibrariesData, userLibraries, checkBoxConfig);


                document.getElementById("libraryDropdownDiv").classList.remove("d-none");
            }
        }

    } catch (error) {
        toastr.error(error.message || error, "Erro!");
    }

    document.getElementById("imgProfile").addEventListener("change", function (event) {
        const [file] = event.target.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("profilePreview").src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});

async function fetchAllLibrariesData() {
    const response = await fetch(`${LIBRARY_API_URL}?activeOnly=true`);
    if (!response.ok) {
        const errorText = await response.text();
        throw new Error(`Erro na API: ${response.status} - ${errorText}`);
    }

    const result = await response.json();

    if (!result || typeof result !== 'object') {
        throw new Error("Resposta da API inválida");
    }

    if (result.status && result.status !== 200) {
        throw new Error(result.message || "Bibliotecas não encontradas");
    }

    const librariesData = result.data || result;

    if (!Array.isArray(librariesData)) {
        throw new Error("Formato de dados de bibliotecas inválido");
    }

    return librariesData;
}

async function fetchAllUserLibrariesData(userId) {
    const response = await fetch(`${USER_LIBRARY_API_URL}?&id=${userId}`);
    if (!response.ok) {
        const errorText = await response.text();
        throw new Error(`Erro na API: ${response.status} - ${errorText}`);
    }

    const result = await response.json();

    if (!result || typeof result !== 'object') {
        throw new Error("Resposta da API inválida");
    }

    if (result.status && result.status !== 200) {
        throw new Error(result.message || "Bibliotecas não encontradas");
    }

    const librariesData = result.data || result;

    if (!Array.isArray(librariesData)) {
        throw new Error("Formato de dados de bibliotecas inválido");
    }

    return librariesData;
}
