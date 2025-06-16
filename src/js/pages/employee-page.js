import * as bdUtils from '../utils/bd-utils.js';
import * as utils from '../utils/utils.js';

const API_ENDPOINTS = {
    EMPLOYEE: '../php/api/employee-api.php',
    LIBRARY: './library/code.php',
    USER: './users/code.php',
};

let urlParams;
let id;

document.addEventListener("DOMContentLoaded", async () => {

    const currentPath = window.location.search;
    urlParams = new URLSearchParams(currentPath);
    id = urlParams.get("id");

    if (currentPath === '?page=employees') {
        await getAll();
        return;
    }

    if (id) {
        update();
        changeActiveStatus();
        return;
    }

    await utils.fetchSelect(API_ENDPOINTS.USER, "primeiro_nome ultimo_nome", "users");
    await utils.fetchSelect(API_ENDPOINTS.LIBRARY, "nome", "library");

    create();
    return;
});

async function getAll() {

    try {
        const [employeeResponse, libraryResponse] = await Promise.all([
            fetch(API_ENDPOINTS.EMPLOYEE),
            fetch(API_ENDPOINTS.LIBRARY)
        ]);

        if (!employeeResponse.ok || !libraryResponse.ok) {
            throw new Error("Erro na requisição");
        }

        const employee = await employeeResponse.json();

        showEmployees(employee);

        utils.initializeRowSelection(API_ENDPOINTS.EMPLOYEE, '?page=employee-form');
    } catch (error) {
        console.error("Erro ao obter bibliotecas:", error);
        toastr.warning("Não foi possível carregar as bibliotecas. Tenta novamente mais tarde.", "Atenção!");
    }
}
function showEmployees(employees) {

    if ($.fn.DataTable.isDataTable('#zero_config')) {
        $('#zero_config').DataTable().destroy();
    }

    const tableBody = $('#zero_config tbody');
    tableBody.empty();

    employees.forEach((employee) => {
        const active = employee.ativo === 'Y'
            ? '<span class="badge rounded-pill bg-success">Ativo</span>'
            : (employee.ativo === 'N'
                ? '<span class="badge rounded-pill bg-danger">Inativo</span>'
                : '');

        tableBody.append(`
            <tr id="id-${employee.id}" class="selectable-row">
                <td>${employee.primeiro_nome}</td>
                <td>${employee.ultimo_nome}</td>
                <td>${employee.biblioteca ?? 'Todas'}</td>
                <td>${employee.permissao}</td>
                <td>${active}</td>
            </tr>`
        );
    });

    $('#zero_config').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese.json'
        }
    });
}


function create() {
    const form = document.querySelector("#libraryForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.newData(API_ENDPOINTS.EMPLOYEE, formData, form, '?page=employees');
    });
}

function update() {

    const form = document.querySelector("#libraryForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        formData.append("id", id);
        bdUtils.updateData(API_ENDPOINTS.EMPLOYEE, formData, form, '?page=employees');
    });
}

function changeActiveStatus() {
    const form = document.querySelector("#changeStatus");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const activeBadge = document.getElementById("active");
        const currentStatus = activeBadge.textContent === "Ativo" ? "Y" : "N";

        const formData = new FormData(this);
        formData.append("changeStatus", true);
        formData.append("id", id);
        formData.append("active", currentStatus);

        bdUtils.changeActiveStatus(API_ENDPOINTS.EMPLOYEE, formData, activeBadge, currentStatus)
    });
}
