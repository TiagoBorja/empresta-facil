document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    try {
        const response = await fetch(`../administrative/category/code.php?id=${id}`);

        if (!response.ok) throw new Error("Erro na requisição");

        const result = await response.json();

        if (result.status === 200) {
            document.getElementById("category").textContent = `Categoria - ${result.data.categoria}`;
            document.getElementById("id").value = result.data.id;
            document.getElementById("category").value = result.data.categoria;
            document.getElementById("description").value = result.data.descricao;


            const activeBadge = document.getElementById("active");
            activeBadge.textContent = result.data.ativo === "Y" ? "Ativo" : "Inativo";
            activeBadge.classList.toggle("bg-success", result.data.ativo === "Y");
            activeBadge.classList.toggle("bg-danger", result.data.ativo === "N");
        }

    } catch (error) {
        toastr.error(error, "Erro!");
    }
});
