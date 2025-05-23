import * as utils from '../utils/utils.js';
const ROLE_API_URL = '../administrative/user-roles/code.php';

document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    try {
        const response = await fetch(`../administrative/users/code.php?id=${id}`);

        if (!response.ok) throw new Error("Erro na requisição");

        const result = await response.json();

        if (result.status === 200) {
            document.getElementById("userName").textContent = `Utilizador - ${result.data.primeiro_nome} ${result.data.ultimo_nome}`;
            document.getElementById("id").value = result.data.id;
            document.getElementById("firstName").value = result.data.primeiro_nome;
            document.getElementById("lastName").value = result.data.ultimo_nome;
            document.getElementById("nif").value = result.data.nif;
            document.getElementById("cc").value = result.data.cc;
            document.getElementById("gender").value = result.data.genero;
            document.getElementById("birthDay").value = result.data.data_nascimento;
            document.getElementById("address").value = result.data.morada;
            document.getElementById("phoneNumber").value = result.data.telemovel;
            document.getElementById("email").value = result.data.email;
            document.getElementById("username").value = result.data.nome_utilizador;
            // document.getElementById("roleSelect").value = result.data.tipo;
            document.getElementById("profilePreview").src = `./users/${result.data.img_url}`;


            const activeBadge = document.getElementById("active");
            activeBadge.textContent = result.data.ativo === "Y" ? "Ativo" : "Inativo";
            activeBadge.classList.toggle("bg-success", result.data.ativo === "Y");
            activeBadge.classList.toggle("bg-danger", result.data.ativo === "N");

            await utils.fetchSelect(ROLE_API_URL, 'tipo', "roleSelect", result.data.tipo_utilizador_fk);
        }

    } catch (error) {
        toastr.error(error, "Erro!");
    }

    // Previsão de imagem ao escolher novo arquivo
    document.getElementById("imgProfile").addEventListener("change", function (event) {
        const [file] = event.target.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("profilePreview").src = e.target.result;
            };
            reader.readAsDataURL(file); // Lê o arquivo como URL
        }
    });
});
