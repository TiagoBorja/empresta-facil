document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");

    try {
        const response = await fetch(`../administrative/library/code.php?id=${id}`);

        if (!response.ok) throw new Error("Erro na requisição");

        const result = await response.json();

        if (result.status === 200) {
            document.getElementById("libraryName").textContent = `Biblioteca - ${result.data.nome}`;
            document.getElementById("id").value = result.data.id;
            document.getElementById("name").value = result.data.nome;
            document.getElementById("address").value = result.data.morada;
            document.getElementById("postalCode").value = result.data.cod_postal;


            const activeBadge = document.getElementById("active");
            activeBadge.textContent = result.data.ativo === "Y" ? "Ativo" : "Inativo";
            activeBadge.classList.toggle("bg-success", result.data.ativo === "Y");
            activeBadge.classList.toggle("bg-danger", result.data.ativo === "N");
        }

    } catch (error) {
        toastr.error(error, "Erro!");
    }
});
