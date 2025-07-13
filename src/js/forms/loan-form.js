import * as utils from '../utils/utils.js';

const API_ENDPOINTS = {
    BOOK_LOCATION: '../php/api/book-location-api.php',
    LOAN: '../php/api/loan-api.php',
    RESERVATION: '../php/api/book-reservation-api.php',
    STATE: './state/code.php',
    USER: './users/code.php',
};

let urlParams = new URLSearchParams(window.location.search);
let loanId = urlParams.get("id");
let bookId = urlParams.get("bookId");
let reservationId = urlParams.get("reservationId");

document.addEventListener('DOMContentLoaded', async function () {

    const isEditMode = loanId !== null;
    const isReservationMode = reservationId !== null;
    if (!isEditMode && !isReservationMode) {
        const allBooksData = await fetchAllBooksData();
        createBooksCheckboxes(allBooksData, []);
        document.getElementById("bookDropdownDiv").classList.remove("d-none")
    }

    if (isReservationMode && reservationId) {
        document.getElementById("bookSelectDiv").classList.remove("d-none")
        showSelectedReservation();
        return;
    }

    if (loanId) {
        document.getElementById("bookSelectDiv").classList.remove("d-none")
        document.getElementById("stateReturnDiv").classList.remove("d-none");
        document.getElementById("returnDateDiv").classList.remove("d-none");

        await showSelectedLoan();
        return;
    }

    showNewLoan();
});

async function showNewLoan() {
    try {


        document.getElementById("pageToRedirect").href = "?page=loans";
        document.getElementById("icon").classList.add("mdi-book-open-page-variant");
        document.getElementById("bookToLoan").textContent = "Empréstimo";

        await utils.fetchSelect(API_ENDPOINTS.USER, "primeiro_nome ultimo_nome", "user");
        await utils.fetchSelect(API_ENDPOINTS.BOOK_LOCATION, "titulo", "bookSelect");

        await utils.fetchSelect(`${API_ENDPOINTS.STATE}?type=LIVRO`, "estado", "statePickUp");

    } catch (error) {
        toastr.error(error, "Erro!");
    }
}

async function showSelectedReservation() {
    try {
        const [reservationResponse, loanResponse] = await Promise.all([
            fetch(`${API_ENDPOINTS.RESERVATION}?id=${reservationId}`),
            fetch(`${API_ENDPOINTS.LOAN}?reservationId=${reservationId}`),
        ]);

        if (!reservationResponse.ok || !loanResponse.ok) {
            throw new Error("Erro na requisição");
        }

        const reservation = await reservationResponse.json();
        const loan = await loanResponse.json();
        if (reservation.status === 200) {

            const reservationValue = reservation.data;
            const loanValue = loan.data;

            document.getElementById("pageToRedirect").href = "?page=book-reservations";
            document.getElementById("icon").classList.add("mdi-book-open-page-variant");
            document.getElementById("bookToLoan").textContent = `Reserva de ${reservationValue.nome_completo} - "${reservationValue.titulo}"`;
            document.getElementById("reservationId").value = reservationValue.id;

            await utils.fetchSelect(API_ENDPOINTS.USER, "primeiro_nome ultimo_nome", "user", reservationValue.utilizador_fk, true);
            await utils.fetchSelect(API_ENDPOINTS.BOOK_LOCATION, "titulo", "bookSelect", loanValue.livro_localizacao_fk, true);

            await utils.fetchSelect(`${API_ENDPOINTS.STATE}?type=LIVRO`, "estado", "statePickUp");
        }
    } catch (error) {
        toastr.error(error, "Erro!");
    }
}

async function showSelectedLoan() {
    try {
        const loanResponse = await fetch(`${API_ENDPOINTS.LOAN}?id=${loanId}&bookId=${bookId}`);
        if (!loanResponse.ok) throw new Error("Erro ao buscar empréstimo com bookId");

        const loanData = await loanResponse.json();
        if (loanData.status !== 200) throw new Error("Erro nos dados do empréstimo completo");

        const loanValue = loanData.data;

        // Atualiza a interface com os dados do empréstimo
        document.getElementById("pageToRedirect").href = "?page=loans";
        document.getElementById("icon").classList.add("mdi-book-open-page-variant");
        document.getElementById("bookToLoan").textContent = `Empréstimo de ${loanValue.utilizador} - "${loanValue.titulo}"`;
        document.getElementById("loanId").value = loanValue.id;
        document.getElementById("bookFk").value = bookId;

        document.getElementById("loanStatus").innerHTML = getStatusBadge(loanValue);

        const today = new Date();
        const returnDateValue = new Date(loanValue.data_devolucao);
        const diffInDays = Math.ceil((returnDateValue - today) / (1000 * 60 * 60 * 24));

        const notifyContainer = document.getElementById("notifyContainer");
        notifyContainer.innerHTML = "";

        if (diffInDays <= 3) {
            const button = document.createElement("button");
            button.id = "notificarBtn";
            button.className = "btn btn-primary btn-sm";
            button.innerHTML = `<i class="mdi mdi-bell-ring-outline"></i> Notificar`;
            console.log(diffInDays);

            button.addEventListener("click", async () => {
                try {
                    let url = "";
                    if (diffInDays > 0) {
                        url = `${API_ENDPOINTS.LOAN}?notifyUpcomingLoanExpiration&user=${loanValue.utilizador_fk}&bookFk=${loanValue.livro_localizacao_fk}`;
                    } else {
                        url = `${API_ENDPOINTS.LOAN}?notifyLoanExpiration&user=${loanValue.utilizador_fk}&bookFk=${loanValue.livro_localizacao_fk}`;
                    }

                    const response = await fetch(url);
                    if (!response.ok) throw new Error("Erro ao enviar notificação");

                    const result = await response.json();

                    if (result.status === 200) {
                        toastr.info("O utilizador foi notificado com sucesso!", "Informação");
                    } else {
                        alert("⚠️ Erro ao enviar notificação: " + result.message);
                    }

                } catch (error) {
                    console.error(error);
                    alert("❌ Ocorreu um erro inesperado.");
                }
            });

            notifyContainer.appendChild(button);
        }

        const dueDate = document.getElementById("dueDate");
        dueDate.value = loanValue.data_devolucao;
        dueDate.disabled = true;

        const returnDate = document.getElementById("returnDate");
        returnDate.value = loanValue.data_devolvido;
        returnDate.disabled = loanValue.data_devolvido !== null;

        // Preenche selects relacionados
        await utils.fetchSelect(API_ENDPOINTS.USER, "primeiro_nome ultimo_nome", "user", loanValue.utilizador_fk, true);
        await utils.fetchSelect(API_ENDPOINTS.BOOK_LOCATION, "titulo", "bookSelect", bookId, true, 'livro_localizacao_fk');
        await utils.fetchSelect(`${API_ENDPOINTS.STATE}?type=LIVRO`, "estado", "statePickUp", loanValue.estado_levantou_fk, true);
        await utils.fetchSelect(`${API_ENDPOINTS.STATE}?type=LIVRO`, "estado", "stateReturn", loanValue.estado_devolucao_fk, loanValue.estado_devolucao_fk !== null);

    } catch (error) {
        toastr.error(error, "Erro!");
    }
}



function createBooksCheckboxes(allBooks, associatedBooks) {
    const booksCheckboxesDiv = document.getElementById("booksCheckboxes");
    booksCheckboxesDiv.innerHTML = "";

    if (!Array.isArray(allBooks)) {
        booksCheckboxesDiv.innerHTML = `
            <div class="alert alert-danger">
                Dados de livros inválidos
            </div>
        `;
        return;
    }

    const searchGroup = document.createElement('div');
    searchGroup.className = 'input-group mb-3';

    const searchIcon = document.createElement('span');
    searchIcon.className = 'input-group-text';
    searchIcon.innerHTML = `
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
        </svg>
    `;

    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.id = 'bookSearch';
    searchInput.className = 'form-control';
    searchInput.placeholder = 'Buscar livros...';

    searchGroup.appendChild(searchIcon);
    searchGroup.appendChild(searchInput);

    booksCheckboxesDiv.appendChild(searchGroup);

    const divider = document.createElement("hr");
    divider.className = "my-2";
    booksCheckboxesDiv.appendChild(divider);

    const sortedBooks = [...allBooks].sort((a, b) => {
        const nameA = a.titulo.toLowerCase();
        const nameB = b.titulo.toLowerCase();
        return nameA.localeCompare(nameB);
    });

    if (sortedBooks.length === 0) {
        booksCheckboxesDiv.innerHTML += `
            <div class="alert alert-info">
                Nenhum livro disponível
            </div>
        `;
        return;
    }

    const associatedBookIds = new Set(
        associatedBooks.map(book => book?.livro_localizacao_fk).filter(Boolean)
    );

    sortedBooks.forEach(book => {
        if (!book?.id) return;

        const checkboxId = `book_${book.livro_localizacao_fk}`;
        const isChecked = associatedBookIds.has(book.livro_localizacao_fk);
        const bookName = book.titulo || 'Livro sem nome';

        const wrapper = document.createElement("div");
        wrapper.classList.add("form-check", "mb-2", "px-3");

        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.classList.add("form-check-input");
        checkbox.id = checkboxId;
        checkbox.name = "books[]";
        checkbox.value = book.livro_localizacao_fk;
        checkbox.checked = isChecked;
        checkbox.addEventListener('change', function () {
            const checkedBoxes = booksCheckboxesDiv.querySelectorAll('input[type="checkbox"]:checked');
            if (checkedBoxes.length > 5) {
                this.checked = false;
                toastr.warning('Você só pode selecionar até 5 livros.', 'Limite atingido!');
            }
            updateBooksDropdownText();
        });

        const label = document.createElement("label");
        label.classList.add("form-check-label", "w-100");
        label.htmlFor = checkboxId;
        label.textContent = bookName;

        wrapper.appendChild(checkbox);
        wrapper.appendChild(label);
        booksCheckboxesDiv.appendChild(wrapper);
    });

    searchInput.addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const checkboxes = booksCheckboxesDiv.querySelectorAll('.form-check');

        checkboxes.forEach(wrapper => {
            if (wrapper.classList.contains('input-group')) return;

            const label = wrapper.querySelector('.form-check-label');
            if (label) {
                const text = label.textContent.toLowerCase();
                wrapper.style.display = text.includes(searchTerm) ? 'block' : 'none';
            }
        });
    });

    updateBooksDropdownText();
}

function updateBooksDropdownText() {
    const booksDropdownBtn = document.getElementById('booksDropdown');
    const checkedBoxes = document.querySelectorAll('#booksCheckboxes input[type="checkbox"]:checked');

    if (checkedBoxes.length === 0) {
        booksDropdownBtn.textContent = 'Selecionar livros';
    } else if (checkedBoxes.length === 1) {
        const label = document.querySelector(`label[for="${checkedBoxes[0].id}"]`);
        booksDropdownBtn.textContent = label ? label.textContent.trim() : '1 livro selecionado';
    } else {
        booksDropdownBtn.textContent = `${checkedBoxes.length} livros selecionados`;
    }
}

async function fetchAllBooksData() {
    const response = await fetch(API_ENDPOINTS.BOOK_LOCATION);
    if (!response.ok) {
        const errorText = await response.text();
        throw new Error(`Erro na API: ${response.status} - ${errorText}`);
    }

    const result = await response.json();

    if (!result || typeof result !== 'object') {
        throw new Error("Resposta da API inválida");
    }

    if (result.status && result.status !== 200) {
        throw new Error(result.message || "Livros não encontrados");
    }

    const booksData = result.data || result;

    if (!Array.isArray(booksData)) {
        throw new Error("Formato de dados de livros inválido");
    }

    return booksData;
}

function getStatusBadge(loan) {
    let badgeHtml = "";

    switch (loan.estado_emprestimo) {
        case 'EM ANDAMENTO':
            badgeHtml = '<span class="badge rounded-pill float-end bg-warning">Em Andamento</span>';
            break;
        case 'CONCLUIDO':
            badgeHtml = '<span class="badge rounded-pill float-end bg-success">Concluído</span>';
            break;
        case 'CANCELADO':
            badgeHtml = '<span class="badge rounded-pill float-end bg-secondary">Cancelado</span>';
            break;
        case 'ATRASADO':
            badgeHtml = '<span class="badge rounded-pill float-end bg-danger">Atrasado</span>';
            break;
        default:
            badgeHtml = '<span class="badge rounded-pill float-end bg-light text-dark">Desconhecido</span>';
    }

    return badgeHtml;
}

