const API_ENDPOINTS = {
    BOOK: './book/code.php',
    BOOK_LOCATION: '../php/api/book-location-api.php',
    LOAN: '../php/api/loan-api.php',
    LIBRARY: './library/code.php',
    LOCATION: './location/code.php',
    USER: './users/code.php',
    EMPLOYEE: '../php/api/employee-api.php'
};

document.addEventListener('DOMContentLoaded', async function () {
    try {
        const id = document.getElementById("employeeId").value;

        const [employeeResponse, bookResponse, loanResponse, userResponse] = await Promise.all([
            fetch(`${API_ENDPOINTS.EMPLOYEE}?id=${id}`),
            fetch(`${API_ENDPOINTS.BOOK}?getBookCount`),
            fetch(`${API_ENDPOINTS.LOAN}?getLoanCount=1&stateType=EM ANDAMENTO`),
            fetch(`${API_ENDPOINTS.USER}?getPendentUserCount=1`),
        ]);

        if (!employeeResponse.ok || !bookResponse.ok || !loanResponse.ok || !userResponse.ok) throw new Error("Erro na requisição");

        const employee = await employeeResponse.json();
        const book = await bookResponse.json();
        const loan = await loanResponse.json();
        const user = await userResponse.json();

        if (employee.status === 200 && book.status === 200) {
            document.getElementById("userName").textContent = `Seja bem-vindo, ${employee.data.nome_completo}!`;
            const libraryName = employee.data.biblioteca_nome;
            document.getElementById("userLibrary").textContent = libraryName ? libraryName : 'Acesso a Todas Bibliotecas';
            document.getElementById("bookCount").textContent = `${book.data}`;
            document.getElementById("activeLoansCount").textContent = `${loan.data}`;
            document.getElementById("pendentUsersCount").textContent = `${user.data}`;
        } else {
            toastr.error("Funcionário não encontrado", "Erro!");
        }
    } catch (error) {
        toastr.error(error.message, "Erro!");
    }
});

