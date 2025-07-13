import * as utils from '../utils/utils.js';

const ROLE_API_URL = '../administrative/user-roles/code.php';
const LIBRARY_API_URL = '../administrative/library/code.php';

document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    const employeeLibraryId = document.getElementById("employeeLibraryId").value;
    const isEditMode = id !== null;

    const userRole = document.getElementById("userRole").value;
    const passwordEl = document.getElementById("password");
    const multiSelectEl = document.getElementById("libraryDropdownDiv");
    const selectEl = document.getElementById("librarySelectDiv");
    const profilePreviewEl = document.getElementById("profilePreview");
    const activeBadgeEl = document.getElementById("active");

    try {
        if (!isEditMode) {
            passwordEl.classList.remove("d-none");
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

                passwordEl.disabled = true;
                profilePreviewEl.src = `./users/upload/${data.img_url}`;

                const isActive = data.ativo === "Y";
                activeBadgeEl.textContent = isActive ? "Ativo" : "Inativo";
                activeBadgeEl.classList.toggle("bg-success", isActive);
                activeBadgeEl.classList.toggle("bg-danger", !isActive);

                await utils.fetchSelect(ROLE_API_URL, 'tipo', "roleSelect", data.tipo_utilizador_fk);
            }
        }

        if (userRole !== 'Administrador') {
            selectEl.classList.remove("d-none");
            await utils.fetchSelect(
                `${LIBRARY_API_URL}?id=${employeeLibraryId}`,
                'nome',
                "librarySelect",
                null,
                true);
        }

        if(userRole === 'Administrador'){
            multiSelectEl.classList.remove("d-none");
        }
    } catch (error) {
        toastr.error(error.message || error, "Erro!");
    }

    document.getElementById("imgProfile").addEventListener("change", function (event) {
        const [file] = event.target.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                profilePreviewEl.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});
