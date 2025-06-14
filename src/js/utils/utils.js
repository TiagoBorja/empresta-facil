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
    } else if (result.status === 422 || result.status === 409) {
        toastr.warning(result.message, "Atenção!");
    }
}

export async function fetchSelect(API_URL, labelValue, elementId, selectedValue = null) {
    try {
        const response = await fetch(API_URL);

        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.statusText);
        }

        const result = await response.json();

        fillSelect(result, labelValue, elementId, selectedValue);
    } catch (error) {
        console.error('Erro ao fazer requisição:', error);
    }
}

function fillSelect(items, labelValue, elementId, selectedValue = null) {
    let option = "";

    const fields = labelValue.split(' - ').map(f => f.trim());

    items.forEach((item) => {
        const label = fields.map(f => item[f] || '').join(' - ');

        const isSelected = selectedValue !== null && item.id == selectedValue ? ' selected' : '';
        option += `<option value="${item.id}"${isSelected}>${label}</option>`;
    });

    const select = document.getElementById(elementId);
    select.innerHTML = option;
}

export async function fillAuthorCheckboxes(authors, labelFields, containerId, selectedValues = []) {
    const container = document.getElementById(containerId);
    container.innerHTML = ''; // limpa antes de adicionar

    const fields = labelFields.split(/[\s\-]+/).map(f => f.trim());
    const separator = labelFields.includes(' - ') ? ' - ' : ' ';

    authors.forEach(author => {
        const label = fields.map(f => author[f] || '').join(separator);
        const isChecked = selectedValues.includes(author.id) ? 'checked' : '';

        const checkboxHTML = `
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="authors" value="${author.id}" id="author-${author.id}" ${isChecked}>
                <label class="form-check-label" for="author-${author.id}">
                    ${label}
                </label>
            </div>
        `;
        container.innerHTML += checkboxHTML;
    });
}

export function showContentAfterLoading(loadingId, contentIds = []) {
    const loading = document.getElementById(loadingId);
    if (loading) loading.style.display = 'none';

    contentIds.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = 'block';
    });
}

export function showLoadingHideContent(loadingId, contentIds = []) {
    const loading = document.getElementById(loadingId);
    if (loading) loading.style.display = 'flex';

    contentIds.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
    });
}

