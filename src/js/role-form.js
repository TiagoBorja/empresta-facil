let originalRoleValue;
let originalDescriptionValue;

document.addEventListener('DOMContentLoaded', async function () {
    const urlParams = new URLSearchParams(window.location.search);
    const roleId = urlParams.get("roleId");

    try {
        const response = await fetch(`../administrative/user-roles/code.php?roleId=${roleId}`);

        if (!response.ok) throw new Error("Erro na requisição");

        const result = await response.json();

        if (result.status === 200) {
            document.getElementById("permissionName").textContent = `Permissão - ${result.data.tipo}`;
            document.getElementById("roleId").value = result.data.id;
            document.getElementById("role").value = result.data.tipo;
            document.getElementById("description").value = result.data.descricao;
            const activeBadge = document.getElementById("active");
            activeBadge.textContent = result.data.ativo === "Y" ? "Ativo" : "Inativo";
            activeBadge.classList.toggle("bg-success", result.data.ativo === "Y");
            activeBadge.classList.toggle("bg-danger", result.data.ativo === "N");
        }


        originalRoleValue = document.getElementById("role").value;
        originalDescriptionValue = document.getElementById("description").value;

    } catch (error) {
        toastr.error(error, "Erro!");
    }
});

function clearInputs() {
    const roleElement = document.getElementById("role");
    const descriptionElement = document.getElementById("description");

    if (roleElement.value !== originalRoleValue) {
        roleElement.value = originalRoleValue;
    }

    if (descriptionElement.value !== originalDescriptionValue) {
        descriptionElement.value = originalDescriptionValue;
    }
}