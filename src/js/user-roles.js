document.addEventListener("DOMContentLoaded", () => {
    initializeFormSubmission();
    initializeRowSelection();
});


function initializeFormSubmission() {
    const form = document.querySelector("#saveUserRole");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveUserRole", true);

        const modal = bootstrap.Modal.getInstance(document.querySelector("#addUserRole"));
        const myTable = document.getElementById("myTable");

        try {
            const response = await fetch("../administrative/user-roles/code.php", {
                method: "POST",
                body: formData
            });

            const contentType = response.headers.get("Content-Type");
            if (contentType && contentType.includes("application/json")) {
                const result = await response.json();
                handleFormResponse(result, form, modal, myTable);
            }
        } catch (error) {
            console.error("Erro ao processar a solicitação", error);
        }
    });
}

async function handleFormResponse(result, form, modal, myTable) {
    if (result.status === 200) {
        form.reset();
        modal.hide();
        await updateTable(myTable);
        toastr.success(result.message, "Sucesso!");
    } else if (result.status === 422) {
        toastr.warning(result.message, "Atenção!");
    }
}

async function updateTable(myTable) {
    try {
        const newTable = await fetch(location.href).then((res) => res.text());
        const parser = new DOMParser();
        const doc = parser.parseFromString(newTable, "text/html");
        myTable.innerHTML = doc.querySelector("#myTable").innerHTML;
    } catch (error) {
        console.error("Erro ao atualizar a tabela", error);
    }
}


function initializeRowSelection() {
    const selectedRows = document.querySelectorAll("[id*=role-]");

    selectedRows.forEach(row => {
        row.addEventListener("click", () => fetchRoleData(row.id));
    });
}

async function fetchRoleData(rowId) {
    try {
        const roleId = rowId.replace("role-", "");
        const response = await fetch(`../administrative/user-roles/code.php?roleId=${roleId}`);

        if (!response.ok) throw new Error("Erro na requisição");

        const data = await response.json();

        if (data.status === 200) {
            window.location.href = `?page=role-form&roleId=${roleId}`;
        }
    } catch (error) {
        console.error("Erro ao obter os dados da role:", error);
    }
}
