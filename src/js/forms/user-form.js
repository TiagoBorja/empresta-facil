import * as utils from '../utils/utils.js';

const ROLE_API_URL = '../administrative/user-roles/code.php';
const LIBRARY_API_URL = '../administrative/library/code.php';
const USER_LIBRARY_API_URL = '../php/api/user-library-api.php';



document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    const isEditMode = id !== null;

    try {
        if (!isEditMode) {
            const allLibrariesData = await fetchAllLibrariesData();
            createLibrariesCheckboxes(allLibrariesData, []);
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
                passwordEl.disabled = true; // Não permite alterar a password
                document.getElementById("profilePreview").src = `./users/${data.img_url}`;

                const activeBadge = document.getElementById("active");
                activeBadge.textContent = data.ativo === "Y" ? "Ativo" : "Inativo";
                activeBadge.classList.toggle("bg-success", data.ativo === "Y");
                activeBadge.classList.toggle("bg-danger", data.ativo === "N");

                await utils.fetchSelect(ROLE_API_URL, 'tipo', "roleSelect", data.tipo_utilizador_fk);

                const allLibrariesData = await fetchAllLibrariesData();
                const userLibraries = await fetchAllUserLibrariesData(data.id);
                console.log(userLibraries);
                
                createLibrariesCheckboxes(allLibrariesData, userLibraries || []);
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

function createLibrariesCheckboxes(allLibraries, associatedLibraries) {
    const librariesCheckboxesDiv = document.getElementById("librariesCheckboxes");
    librariesCheckboxesDiv.innerHTML = "";

    if (!Array.isArray(allLibraries)) {
        librariesCheckboxesDiv.innerHTML = `
            <div class="alert alert-danger">
                Dados de bibliotecas inválidos
            </div>
        `;
        return;
    }

    const searchGroup = document.createElement('div');
    searchGroup.className = 'input-group mb-3';

    const searchIcon = document.createElement('span');
    searchIcon.className = 'input-group-text';
    searchIcon.innerHTML = `
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
        </svg>
    `;

    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.id = 'librarySearch';
    searchInput.className = 'form-control';
    searchInput.placeholder = 'Buscar bibliotecas...';

    searchGroup.appendChild(searchIcon);
    searchGroup.appendChild(searchInput);

    librariesCheckboxesDiv.appendChild(searchGroup);

    const divider = document.createElement("hr");
    divider.className = "my-2";
    librariesCheckboxesDiv.appendChild(divider);

    const sortedLibraries = [...allLibraries].sort((a, b) => a.nome.toLowerCase().localeCompare(b.nome.toLowerCase()));

    if (sortedLibraries.length === 0) {
        librariesCheckboxesDiv.innerHTML += `
            <div class="alert alert-info">
                Nenhuma biblioteca disponível
            </div>
        `;
        return;
    }

    const associatedLibrariesIds = new Set(
        associatedLibraries.map(lib => lib?.id || lib?.biblioteca_fk).filter(Boolean)
    );

    sortedLibraries.forEach(library => {
        if (!library?.id) return;

        const checkboxId = `library_${library.id}`;
        const isChecked = associatedLibrariesIds.has(library.id);
        const libraryName = library.nome || 'Biblioteca sem nome';

        const wrapper = document.createElement("div");
        wrapper.classList.add("form-check", "mb-2", "px-3");

        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.classList.add("form-check-input");
        checkbox.id = checkboxId;
        checkbox.name = "libraries[]";
        checkbox.value = library.id;
        checkbox.checked = isChecked;
        checkbox.addEventListener('change', updateLibrariesDropdownText);

        const label = document.createElement("label");
        label.classList.add("form-check-label", "w-100");
        label.htmlFor = checkboxId;
        label.textContent = libraryName;

        wrapper.appendChild(checkbox);
        wrapper.appendChild(label);
        librariesCheckboxesDiv.appendChild(wrapper);
    });

    searchInput.addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const checkboxes = librariesCheckboxesDiv.querySelectorAll('.form-check');

        checkboxes.forEach(wrapper => {
            // Ignorar o input de pesquisa
            if (wrapper.classList.contains('input-group')) return;

            const label = wrapper.querySelector('.form-check-label');
            if (label) {
                wrapper.style.display = label.textContent.toLowerCase().includes(searchTerm) ? 'block' : 'none';
            }
        });
    });

    updateLibrariesDropdownText();
}

function updateLibrariesDropdownText() {
    const dropdownBtn = document.getElementById('librariesDropdown');
    const checkedBoxes = document.querySelectorAll('#librariesCheckboxes input[type="checkbox"]:checked');

    if (checkedBoxes.length === 0) {
        dropdownBtn.textContent = 'Selecionar bibliotecas';
    } else if (checkedBoxes.length === 1) {
        const label = document.querySelector(`label[for="${checkedBoxes[0].id}"]`);
        dropdownBtn.textContent = label ? label.textContent.trim() : '1 biblioteca selecionada';
    } else {
        dropdownBtn.textContent = `${checkedBoxes.length} bibliotecas selecionadas`;
    }
}

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
