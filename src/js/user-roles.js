import * as bdUtils from './bdUtils.js';

const API_URL = '../administrative/user-roles/code.php';
let urlParams;
let roleId;

document.addEventListener("DOMContentLoaded", () => {
    urlParams = new URLSearchParams(window.location.search);
    roleId = urlParams.get("roleId");

    if (roleId) {
        updateUserRole();
        changeActiveStatus();
        return;
    }

    newUserRole();
});

function newUserRole() {
    const form = document.querySelector("#roleForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.newData(API_URL, formData, form, '?page=user-roles');
    });
}

function updateUserRole() {

    const form = document.querySelector("#roleForm");
    if (!form) return;

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("saveData", true);
        bdUtils.updateData(API_URL, formData, form, '?page=user-roles');
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
        formData.append("roleId", roleId);
        formData.append("active", currentStatus);

        bdUtils.changeActiveStatus(API_URL, formData, activeBadge, currentStatus)
    });
}
