import * as utils from '../utils/utils.js';

document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    try {
        const response = await fetch(`../administrative/author/code.php?id=${id}`);

        if (!response.ok) throw new Error("Erro na requisição");

        const result = await response.json();

        if (result.status === 200) {

            document.getElementById("authorName").textContent = `Autor - ${result.data.primeiro_nome} ${result.data.ultimo_nome}`;
            document.getElementById("id").value = result.data.id;
            document.getElementById("firstName").value = result.data.primeiro_nome;
            document.getElementById("lastName").value = result.data.ultimo_nome;

            document.getElementById("nationality").value = result.data.nacionalidade;
            document.getElementById("biography").value = result.data.biografia;
            document.getElementById("gender").value = result.data.genero;
            document.getElementById("birthDay").value = result.data.data_nascimento;

            if (result.data.img_url === null || result.data.img_url === undefined || result.data.img_url === '') {
                document.getElementById("imgPreview").style.display = 'none'
                document.getElementById("btnDeleteImg").style.display = 'none'
            }

            document.getElementById("imgPreview").src = `./author/${result.data.img_url}`;
            const activeBadge = document.getElementById("active");
            activeBadge.textContent = result.data.ativo === "Y" ? "Ativo" : "Inativo";
            activeBadge.classList.toggle("bg-success", result.data.ativo === "Y");
            activeBadge.classList.toggle("bg-danger", result.data.ativo === "N");

        }

    } catch (error) {
        toastr.error(error, "Erro!");
    }

    document.getElementById("imgProfile").addEventListener("change", function (event) {
        const [file] = event.target.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("imgPreview").src = e.target.result;
                document.getElementById("imgPreview").style.display = 'inline-block'
                document.getElementById("btnDeleteImg").style.display = 'inline-block'
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById("btnDeleteImg").addEventListener("click", function () {

        document.getElementById("imgPreview").src = '';
        document.getElementById("imgProfile").value = '';
        document.getElementById("imgPreview").style.display = 'none'

        document.getElementById("btnDeleteImg").style.display = 'none'
    });
});
