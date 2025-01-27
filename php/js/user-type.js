
document.addEventListener("DOMContentLoaded", () => {
    console.log("JavaScript carregado com sucesso!");
    document.querySelector("#saveUserType").addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveUserType", true);

        const modal = bootstrap.Modal.getInstance(document.querySelector("#addUserType"));
        const myTable = document.getElementById("myTable");

        try {
            const response = await fetch('./config/user-type/code.php', {
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
});

