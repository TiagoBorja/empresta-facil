<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg rounded-4 p-4" style="max-width: 400px; width: 100%;">
        <div class="card-body">
            <main class="form-signin">
                <form method="POST" action="./config/auth/login.php">
                    <h1 class="h3 mb-4 fw-bold text-center">Iniciar Sessão</h1>

                    <?php
                    if (isset($_SESSION['login-error'])) {
                        ?>
                        <div class="alert alert-warning text-center"><?= $_SESSION['login-error']; ?></div>
                        <?php
                        unset($_SESSION['login-error']);
                    }
                    ?>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="usernameOrEmail" required
                            placeholder="Nome de Utilizador ou Email">
                        <label for="floatingInput">Nome de Utilizador ou Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" name="password" required
                            placeholder="Palavra-passe">
                        <label for="floatingPassword">Palavra-passe</label>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                        <label class="form-check-label" for="rememberMe">
                            Manter sessão iniciada
                        </label>
                    </div>

                    <button class="w-100 btn btn-lg btn-primary mb-3" type="submit">Entrar</button>

                    <div class="text-center">
                        <small class="text-muted">
                            Ainda não tem conta? <a href="?page=register" class="text-decoration-none">Registe-se
                                aqui</a>.
                        </small>
                    </div>

                    <p class="mt-4 mb-0 text-muted text-center">&copy; 2017–2025</p>
                </form>
            </main>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const toastMessage = sessionStorage.getItem('toastMessage');

        if (toastMessage === 'success') {
            toastr.success("Registo realizado com sucesso! Um email chegará à sua caixa de correio.", "Sucesso!");
        } else if (toastMessage === 'error') {
            toastr.error("Ocorreu um erro ao processar a solicitação.", "Erro!");
        }
        sessionStorage.removeItem('toastMessage');
    });
</script>