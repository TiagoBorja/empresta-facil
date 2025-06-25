export function clearInputs(inputs) {
    inputs.forEach(({ elementId, originalValue }) => {
        const element = document.getElementById(elementId);
        if (element && element.value !== originalValue) {
            element.value = originalValue;
        }
    });
}

export function initializeRowSelection(API_URL, formRedirect, specificRedirect) {
    const selectedRows = document.querySelectorAll("[id*=id-]");


    selectedRows.forEach(row => {
        row.addEventListener("click", () => {
            fetchData(API_URL, row.id, formRedirect, specificRedirect);
        });
    });
}

export async function fetchData(API_URL, rowId, formRedirect, specificRedirect, options = {}) {
    try {
        const id = rowId.replace("id-", "");
        const rowElement = document.getElementById(rowId);

        // Verifica se há um bookId no data-attribute (nova funcionalidade)
        const bookId = rowElement ? rowElement.getAttribute('data-bookid') : null;

        // Faz a requisição (mantém compatibilidade)
        const url = bookId ? `${API_URL}?id=${id}&bookId=${bookId}` : `${API_URL}?id=${id}`;
        const response = await fetch(url);

        if (!response.ok) throw new Error("Erro na requisição");

        const data = await response.json();

        if (data.status === 200) {
            const paramKey = specificRedirect ? specificRedirect : "id";
            // Se tiver bookId, inclui na URL (nova funcionalidade)
            const redirectUrl = bookId
                ? `${formRedirect}&${paramKey}=${id}&bookId=${bookId}`
                : `${formRedirect}&${paramKey}=${id}`;

            window.location.href = redirectUrl;
        }
    } catch (error) {
        console.error("Erro ao obter os dados:", error);
        toastr.error("Erro ao processar a seleção", "Erro!");
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

export async function fetchSelect(API_URL, labelValue, elementId, selectedValue = null, blockSelect = false, specificId) {
    try {
        const response = await fetch(API_URL);

        if (!response.ok) {
            throw new Error('Erro na requisição: ' + response.statusText);
        }

        const result = await response.json();
        if ('data' in result) {
            fillSelect(result.data, labelValue, elementId, selectedValue, blockSelect, specificId);
            return;
        }

        fillSelect(result, labelValue, elementId, selectedValue, blockSelect, specificId);
    } catch (error) {
        console.error('Erro ao fazer requisição:', error);
    }
}

function fillSelect(items, labelValue, elementId, selectedValue = null, blockSelect = false, specificId) {
    try {
        let option = "";

        const separator = labelValue.includes(' - ') ? ' - ' : ' ';
        const fields = labelValue.split(separator).map(f => f.trim());

        items.forEach((item) => {
            const label = fields.map(f => item[f] || '').join(separator);

            const value = item[specificId] ?? item.id;

            const isSelected = selectedValue !== null && value == selectedValue ? ' selected' : '';
            option += `<option value="${value}"${isSelected}>${label}</option>`;
        });

        const select = document.getElementById(elementId);
        select.innerHTML = option;

        if (blockSelect) {
            select.addEventListener('mousedown', function (e) {
                e.preventDefault();
            });
            select.style.pointerEvents = 'none';
            select.style.backgroundColor = '#eee';
        }
    } catch (error) {
        console.error('Erro ao fazer requisição:', error);
    }
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

export function formatDate(dateString) {

    if (dateString === null) {
        return ' - ';
    }

    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0'); // mm (0-indexed)
    const year = date.getFullYear();                          // yyyy
    return `${day}-${month}-${year}`;
}

export function onSelectLoan(API_URL, formRedirect) {
    // Remove todos os listeners existentes primeiro
    const rows = document.querySelectorAll("[id*=id-]");
    rows.forEach(row => {
        const newRow = row.cloneNode(true);
        row.parentNode.replaceChild(newRow, row);
    });

    document.querySelectorAll("[id*=id-]").forEach(row => {
        row.addEventListener("click", function () {
            const id = this.id.replace("id-", "");
            const bookId = this.getAttribute('data-bookid');

            console.log(`Redirecionando com ID: ${id}, BookID: ${bookId}`);

            if (bookId) {
                window.location.href = `${formRedirect}&id=${id}&bookId=${bookId}`;
                return;
            }
            window.location.href = `${formRedirect}&id=${id}`;

        });
    });
}

