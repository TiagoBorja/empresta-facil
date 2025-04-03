document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const roleId = urlParams.get("roleId");

    if (roleId) {
        updateUserRole();
        changeActiveStatus();
        return;
    }

    newUserRole();

    initializeRowSelection();
});

function newUserRole() {
    const form = document.querySelector("#roleForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);

        try {
            const response = await fetch("../administrative/user-roles/code.php", {
                method: "POST",
                body: formData
            });

            const contentType = response.headers.get("Content-Type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new Error("Resposta inválida do servidor");
            }

            const result = await response.json();

            if (result.status === 422) {
                toastr.warning(result.message || "Preencha os campos antes de prosseguir!", "Atenção!");
                return;
            }

            handleFormResponse(result, form);

            if (result.status === 200) {
                sessionStorage.setItem('toastMessage', 'success');
                window.location.href = '?page=user-roles';
            }
        } catch (error) {
            console.error("Erro ao processar a solicitação:", error);
            toastr.error("Ocorreu um erro ao processar a solicitação", "Erro!");
        }
    });
}

function updateUserRole() {

    const form = document.querySelector("#roleForm");
    if (!form) return;


    const urlParams = new URLSearchParams(window.location.search);
    const roleId = urlParams.get("roleId");

    form.addEventListener("submit", async function (e) {
        e.preventDefault();
        console.log("Botão de salvar pressionado!");

        const formData = new FormData(this);
        formData.append("saveData", true);
        formData.append("roleId", roleId);

        try {
            const response = await fetch("../administrative/user-roles/code.php", {
                method: "POST",
                body: formData
            });

            const contentType = response.headers.get("Content-Type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new Error("Resposta inválida do servidor");
            }

            const result = await response.json();

            if (result.status === 422) {
                toastr.warning(result.message || "Preencha os campos antes de prosseguir!", "Atenção!");
                return;
            }

            handleFormResponse(result, form);

            if (result.status === 200) {
                sessionStorage.setItem('toastMessage', 'success');
                window.location.href = '?page=user-roles';
            }
        } catch (error) {
            console.error("Erro ao processar a solicitação:", error);
            toastr.error("Ocorreu um erro ao processar a solicitação", "Erro!");
        }
    });
}

function changeActiveStatus() {
    const form = document.querySelector("#changeStatus");
    if (!form) return;

    const urlParams = new URLSearchParams(window.location.search);
    const roleId = urlParams.get("roleId");

    form.addEventListener("submit", async function (e) {
        e.preventDefault();
        console.log("Botão de alteração de status pressionado!");

        const activeBadge = document.getElementById("active");
        const currentStatus = activeBadge.textContent === "Ativo" ? "Y" : "N";

        const formData = new FormData(this);
        formData.append("changeStatus", true);
        formData.append("roleId", roleId);
        formData.append("active", currentStatus);

        try {
            const response = await fetch("../administrative/user-roles/code.php", {
                method: "POST",
                body: formData
            });

            const contentType = response.headers.get("Content-Type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new Error("Resposta inválida do servidor");
            }

            const result = await response.json();

            if (result.status === 200) {
                const newStatus = currentStatus === "Y" ? "N" : "Y";
                activeBadge.textContent = newStatus === "Y" ? "Ativo" : "Inativo";
                activeBadge.classList.toggle("bg-success", newStatus === "Y");
                activeBadge.classList.toggle("bg-danger", newStatus === "N");

                toastr.success(result.message, "Sucesso!");
            } else {
                toastr.error(result.message || "Erro ao alterar status", "Erro!");
            }
        } catch (error) {
            console.error("Erro ao processar a solicitação:", error);
            toastr.error("Ocorreu um erro ao processar a solicitação", "Erro!");
        }
    });
}

async function handleFormResponse(result, form) {
    if (result.status === 200) {
        form.reset();
        toastr.success(result.message, "Sucesso!");
    } else if (result.status === 422) {
        toastr.warning(result.message, "Atenção!");
    }
}
