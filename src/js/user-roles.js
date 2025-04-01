
document.addEventListener("DOMContentLoaded", () => {

    document.querySelector("#saveUserRole").addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveUserRole", true);

        const modal = bootstrap.Modal.getInstance(document.querySelector("#addUserRole"));
        const myTable = document.getElementById("myTable");

        try {
            const response = await fetch('../administrative/user-roles/code.php', {
                method: 'POST',
                body: formData
            });

            const contentType = response.headers.get('Content-Type');
            if (contentType && contentType.includes('application/json')) {
                const result = await response.json();

                if (result.status === 200) {
                    this.reset();
                    modal.hide();

                    const newTable = await fetch(location.href).then((res) => res.text());
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(newTable, "text/html");
                    myTable.innerHTML = doc.querySelector("#myTable").innerHTML;

                    toastr.success(result.message, "Sucesso!");
                } else if (result.status === 422) {
                    toastr.warning(result.message, "Atenção!");
                }
            }
        } catch (error) {
            console.error("Erro ao processar a solicitação", error);
        }
    });

    const selectedRows = Array.from(document.querySelectorAll('[id*=role-]'));

    selectedRows.forEach(row => {
        row.onclick = async function () {
            try {
                const roleId = row.id.replace('role-', '');
                const response = await fetch(`../administrative/user-roles/code.php?roleId=${roleId}`);

                if (!response.ok) throw new Error('Erro na requisição');

                const data = await response.json();

                console.log(data);

                if (data.status === 200) {
                    // Armazena os dados no localStorage antes de redirecionar
                    localStorage.setItem('roleData', JSON.stringify(data.data));

                    // Redireciona para o formulário
                    window.location.href = '?page=role-form';
                } else {
                    console.warn("Aviso:", data.message);
                }
            } catch (error) {
                console.error('Erro:', error);
            }
        };
    });



});

