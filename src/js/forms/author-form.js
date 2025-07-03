import { showContentAfterLoading, showLoadingHideContent } from '../utils/utils.js';

document.addEventListener('DOMContentLoaded', async function () {

    showLoadingHideContent("loading", ["content"]);

    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    const imgPreview = document.getElementById("imgPreview");

    const showForm = () => showContentAfterLoading("loading", ["content"]);


    try {
        const response = await fetch(`../administrative/author/code.php?id=${id}`);
        if (!response.ok) throw new Error("Erro na requisição");

        const result = await response.json();
        if (result.status !== 200) return showForm();

        document.getElementById("authorName").textContent = `Autor - ${result.data.primeiro_nome} ${result.data.ultimo_nome}`;
        document.getElementById("id").value = result.data.id;
        document.getElementById("firstName").value = result.data.primeiro_nome;
        document.getElementById("lastName").value = result.data.ultimo_nome;
        document.getElementById("nationality").value = result.data.nacionalidade;
        document.getElementById("biography").value = result.data.biografia;
        document.getElementById("gender").value = result.data.genero;
        document.getElementById("birthDay").value = result.data.data_nascimento;

        const activeBadge = document.getElementById("active");
        activeBadge.textContent = result.data.ativo === "Y" ? "Ativo" : "Inativo";
        activeBadge.classList.toggle("bg-success", result.data.ativo === "Y");
        activeBadge.classList.toggle("bg-danger", result.data.ativo === "N");

        const hasImage = result.data.img_url && result.data.img_url.trim() !== '';
        if (!hasImage) {
            imgPreview.style.display = 'none';
            document.getElementById("btnDeleteImg").style.display = 'none';
            return showForm();
        }

        imgPreview.src = `./author/upload/${result.data.img_url}`;
        imgPreview.onload = showForm;
        imgPreview.onerror = showForm;

    } catch (error) {
        toastr.error(error.message || error, "Erro!");
        showContentAfterLoading("loading", ["content"]);
    }

    document.getElementById("imgProfile").addEventListener("change", function (event) {
        const [file] = event.target.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imgPreview.src = e.target.result;
                imgPreview.style.display = 'inline-block';
                document.getElementById("btnDeleteImg").style.display = 'inline-block';
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById("btnDeleteImg").addEventListener("click", function () {
        imgPreview.src = '';
        imgPreview.style.display = 'none';
        document.getElementById("imgProfile").value = '';
        document.getElementById("btnDeleteImg").style.display = 'none';
    });
});
