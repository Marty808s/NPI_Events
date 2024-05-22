<nav class="navbar navbar-expand-lg navbar-dark my-navbar-color">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="/images/npi_icon.png" alt="NPI Karlovy Vary Logo" height="60" width="89">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav text-center">
                <li class="nav-item m-3 p-2">
                    <a class="nav-link" href="index.php">Kurzy</a>
                </li>

                <?php if (isUser()): ?>
                <li class="nav-item m-3 p-2">
                    <a class="nav-link" href="add_event.php">Přidej VP</a>
                </li>
                <li class="nav-item m-3 p-2">
                    <a class="nav-link" href="manage.php">Správa kurzů</a>
                </li>
                <li class="nav-item m-3 p-2">
                    <a class="nav-link" href="login.php"><?= "Uživatel: " . htmlspecialchars($_SESSION['jmeno']); ?></a>
                </li>
                <?php else: ?>
                <li class="nav-item m-3 p-2">
                    <a class="nav-link" href="login.php">Přihlaste se</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
