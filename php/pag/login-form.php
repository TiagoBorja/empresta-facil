<?= include 'includes/header.php'; ?>

<body class="container mt-5 text-center">
    <div class="card">
        <div class="card-body">
            <main class="form-signin">
                <form method="POST" action="./config/user-login/login.php">
                    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

                    <?php
                    if (isset($_SESSION['login-error'])) {
                        ?>
                        <div class="alert alert-warning"><?= $_SESSION['login-error']; ?></div>
                        <?php
                        unset($_SESSION['login-error']);
                    }

                    ?>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="email" required>
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" name="password" required>
                        <label for="floatingPassword">Password</label>
                    </div>

                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                    <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
                </form>
            </main>
        </div>
    </div>
</body>

<?= include 'includes/footer.php'; ?>