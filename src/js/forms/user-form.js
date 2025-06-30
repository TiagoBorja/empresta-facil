import * as utils from '../utils/utils.js';

const ROLE_API_URL = '../administrative/user-roles/code.php';
const LIBRARY_API_URL = '../administrative/library/code.php';

document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    const employeeLibraryId = document.getElementById("employeeLibraryId").value;
    const isEditMode = id !== null;

    // Guardar referências de elementos usados várias vezes
    const passwordEl = document.getElementById("password");
    const profilePreviewEl = document.getElementById("profilePreview");
    const activeBadgeEl = document.getElementById("active");

    try {
        if (!isEditMode) {
            // Modo de criação: mostrar password
            passwordEl.classList.remove("d-none");
        } else {
            // Modo edição: buscar dados do utilizador
            const response = await fetch(`../administrative/users/code.php?id=${id}`);
            if (!response.ok) throw new Error("Erro na requisição");

            const result = await response.json();

            if (result.status === 200) {
                const data = result.data;

                // Preencher campos
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

                // Desativar campo password e atualizar preview da imagem
                passwordEl.disabled = true;
                profilePreviewEl.src = `./users/upload/${data.img_url}`;
                console.log(data.img_url);
                                

                // Atualizar badge de ativo/inativo
                const isActive = data.ativo === "Y";
                activeBadgeEl.textContent = isActive ? "Ativo" : "Inativo";
                activeBadgeEl.classList.toggle("bg-success", isActive);
                activeBadgeEl.classList.toggle("bg-danger", !isActive);

                // Buscar roles e preencher select
                await utils.fetchSelect(ROLE_API_URL, 'tipo', "roleSelect", data.tipo_utilizador_fk);
            }
        }

        // Preencher select da biblioteca (sempre, mesmo no modo edição)
        await utils.fetchSelect(
            `${LIBRARY_API_URL}?id=${employeeLibraryId}`,
            'nome',
            "librarySelect",
            null,
            true);

    } catch (error) {
        toastr.error(error.message || error, "Erro!");
    }

    // Preview da imagem ao carregar arquivo
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
