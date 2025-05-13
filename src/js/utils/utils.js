export function clearInputs(inputs) {
    inputs.forEach(({ elementId, originalValue }) => {
        const element = document.getElementById(elementId);
        if (element && element.value !== originalValue) {
            element.value = originalValue;
        }
    });
}

export function initializeRowSelection(API_URL, formRedirect) {
    const selectedRows = document.querySelectorAll("[id*=id-]");

    selectedRows.forEach(row => {
        row.addEventListener("click", () => fetchData(API_URL, row.id, formRedirect));
    });
}

export async function fetchData(API_URL, rowId, formRedirect) {
    try {
        const id = rowId.replace("id-", "");
        const response = await fetch(`${API_URL}?id=${id}`);

        if (!response.ok) throw new Error("Erro na requisição");

        const data = await response.json();

        if (data.status === 200) {
            window.location.href = `${formRedirect}&id=${id}`;
        }
    } catch (error) {
        console.error("Erro ao obter os dados:", error);
    }
}

export async function handleFormResponse(result, form) {
    if (result.status === 200) {
        form.reset();
        toastr.success(result.message, "Sucesso!");
    } else if (result.status === 422) {
        toastr.warning(result.message, "Atenção!");
    }
}