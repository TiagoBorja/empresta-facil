export function clearInputs(inputs) {
    inputs.forEach(({ elementId, originalValue }) => {
        const element = document.getElementById(elementId);
        if (element && element.value !== originalValue) {
            element.value = originalValue;
        }
    });
}

export function initializeRowSelection(API_URL, formRedirect, specificRedirect, options = {}) {
    const { onPendingClick, onOtherClick } = options;

    const selectPendingUsers = document.querySelectorAll("tr[data-active='P']");
    const otherRows = document.querySelectorAll("[id*=id-]:not([data-active='P'])");

    selectPendingUsers.forEach(row => {
        if (typeof onPendingClick === 'function') {
            row.addEventListener("click", () => onPendingClick(row));
            return;
        }
        row.addEventListener("click", () => alert('Linha P clicada'));
    });

    otherRows.forEach(row => {
        if (typeof onOtherClick === 'function') {
            row.addEventListener("click", () => onOtherClick(row));
            return;
        }
        row.addEventListener("click", () => fetchData(API_URL, row.id, formRedirect, specificRedirect));
    });
}


export async function fetchData(API_URL, rowId, formRedirect, specificRedirect) {
    try {
        const id = rowId.replace("id-", "");
        const paramKey = specificRedirect || "id";
        const url = `${API_URL}?${paramKey}=${id}`;

        const response = await fetch(url);
        if (!response.ok) throw new Error("Erro na requisição");

        const data = await response.json();

        if (data.status === 200) {
            const separator = formRedirect.includes('?') ? '&' : '?';
            const redirectUrl = `${formRedirect}${separator}${paramKey}=${id}`;
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
    } else if (result.status === 422 || result.status === 409 || result.status === 400 || result.status === 401) {
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
            select.style.backgroundColor = '#cccccc';
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

export function createGenericCheckboxes(allItems, associatedItems, config) {
    const {
        containerId,
        nameField = 'nome',
        idField = 'id',
        valueField = 'id',
        checkboxName = 'items[]',
        dropdownButtonId = null,
        singularLabel = 'item',
        pluralLabel = 'itens',
        emptyMessage = 'Nenhum item disponível',
        errorMessage = 'Dados inválidos',
        associationField = null // ← Novo campo para identificar qual campo usar de associatedItems
    } = config;

    const container = document.getElementById(containerId);
    container.innerHTML = '';

    if (!Array.isArray(allItems)) {
        container.innerHTML = `<div class="alert alert-danger">${errorMessage}</div>`;
        return;
    }

    // Campo de busca
    const searchGroup = document.createElement('div');
    searchGroup.className = 'input-group mb-3';
    searchGroup.innerHTML = `
        <span class="input-group-text">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
        </span>
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
    `;
    container.appendChild(searchGroup);

    const divider = document.createElement('hr');
    divider.className = 'my-2';
    container.appendChild(divider);

    const sortedItems = [...allItems].sort((a, b) => {
        const nameA = (a[nameField] || '').toLowerCase();
        const nameB = (b[nameField] || '').toLowerCase();
        return nameA.localeCompare(nameB);
    });

    if (sortedItems.length === 0) {
        container.innerHTML += `<div class="alert alert-info">${emptyMessage}</div>`;
        return;
    }

    // Identifica os IDs dos itens associados, usando o campo apropriado
    const associatedIds = new Set(
        associatedItems.map(item =>
            item?.[associationField ?? idField]
        ).filter(Boolean)
    );

    // Cria os checkboxes
    sortedItems.forEach(item => {
        const id = item?.[idField];
        const labelName = item?.[nameField] || `${singularLabel} sem nome`;
        const value = item?.[valueField];

        if (!id) return;

        const checkboxId = `${containerId}_${id}`;
        const wrapper = document.createElement('div');
        wrapper.className = 'form-check mb-2 px-3';

        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.className = 'form-check-input';
        checkbox.id = checkboxId;
        checkbox.name = checkboxName;
        checkbox.value = value;
        checkbox.checked = associatedIds.has(id);
        checkbox.addEventListener('change', () => updateDropdownText(dropdownButtonId, containerId, singularLabel, pluralLabel));

        const label = document.createElement('label');
        label.className = 'form-check-label w-100';
        label.htmlFor = checkboxId;
        label.textContent = labelName;

        wrapper.appendChild(checkbox);
        wrapper.appendChild(label);
        container.appendChild(wrapper);
    });

    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const checkboxes = container.querySelectorAll('.form-check');

        checkboxes.forEach(wrapper => {
            const label = wrapper.querySelector('label');
            if (label) {
                wrapper.style.display = label.textContent.toLowerCase().includes(searchTerm) ? 'block' : 'none';
            }
        });
    });

    updateDropdownText(dropdownButtonId, containerId, singularLabel, pluralLabel);
}


function updateDropdownText(dropdownId, containerId, singularLabel, pluralLabel) {
    if (!dropdownId) return;

    const dropdown = document.getElementById(dropdownId);
    const checked = document.querySelectorAll(`#${containerId} input[type="checkbox"]:checked`);

    if (checked.length === 0) {
        dropdown.textContent = `Selecionar ${pluralLabel}`;
    } else if (checked.length === 1) {
        const label = document.querySelector(`label[for="${checked[0].id}"]`);
        dropdown.textContent = label ? label.textContent.trim() : `1 ${singularLabel} selecionado`;
    } else {
        dropdown.textContent = `${checked.length} ${pluralLabel} selecionados`;
    }
}


export function truncateText(text, maxLength) {
    if (text.length > maxLength) {
        return text.substring(0, maxLength) + '...';
    }
    return text;
}