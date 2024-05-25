<nav class="navbar navbar-expand-lg navbar-light my-navbar-color">
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
                <li class="nav-item dropdown m-3 p-2">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Přidej VP
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="add_event.php">Formulářem</a>
                        <a class="dropdown-item" href="upload.php">Nahraj XML</a>
                    </div> 
                </li>
                <li class="nav-item dropdown m-3 p-2">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Správa kurzů
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenu2">
                        <a class="dropdown-item" href="manage.php">Spravování VP</a>
                        <a class="dropdown-item" href="stats.php">Statistika kurzů</a>
                    </div> 
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
