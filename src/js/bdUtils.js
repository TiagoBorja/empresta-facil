export async function newData(API_URL, formData, form, pageRedirect) {
    try {
        const response = await fetch(API_URL, {
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
            window.location.href = pageRedirect;
        }
    } catch (error) {
        console.error("Erro ao processar a solicitação:", error);
        toastr.error("Ocorreu um erro ao processar a solicitação", "Erro!");
    }
}

export async function updateData(API_URL, formData, form, pageRedirect) {
    try {
        const response = await fetch(API_URL, {
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
            window.location.href = pageRedirect;
        }
    } catch (error) {
        console.error("Erro ao processar a solicitação:", error);
        toastr.error("Ocorreu um erro ao processar a solicitação", "Erro!");
    }
}

export async function changeActiveStatus(API_URL, formData, activeBadge, currentStatus) {
    try {
        const response = await fetch(API_URL, {
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
}