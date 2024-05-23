<?php
require '../prolog.php';
require INC . '/html_base.php';
require INC . '/html_nav.php';
require PHP . '/db.php';  // Tento soubor inicializuje $mysqli a obsahuje databázové funkce
require PHP . '/boxes.php';

// pokud mám v SESSION již jméno, tak ho odstraním, tím padém se odhlásím
if (isUser()) {
    setJmeno();
    echo "<script>window.location.href = '/index.php';</script>";
    exit;
}
?>
<!--Formuláře login/register-->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Přihlášení</h2>
            <form method="post" action="/login.php">
                <div class="form-group">
                    <label for="username_input">Přihlašovací jméno</label>
                    <input type="text" class="form-control" name="username_input" id="username_input" placeholder="Uživatel">
                </div>
                <div class="form-group">
                    <label for="passwd_input">Heslo</label>
                    <input type="password" class="form-control" name="passwd_input" id="passwd_input" placeholder="Heslo">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="login">Přihlaste se</button> <!--Tlačítko: post login-->
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <h2>Registrace</h2>
            <form method="post" action="/login.php">
                <div class="form-group">
                    <label for="reg_username_input">Přihlašovací jméno</label>
                    <input type="text" class="form-control" name="reg_username_input" id="reg_username_input" placeholder="Uživatel">
                </div>
                <div class="form-group">
                    <label for="reg_passwd_input">Heslo</label>
                    <input type="password" class="form-control" name="reg_passwd_input" id="reg_passwd_input" placeholder="Heslo">
                </div>
                <div class="form-group">
                    <label for="reg_passwd_input">Opakujte heslo</label>
                    <input type="password" class="form-control" name="reg_passwd_input2" id="reg_passwd_input2" placeholder="Heslo">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="register">Registrujte se</button> <!--Tlačítko: post registrace-->
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Kontrola request metody na stranu server
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) { //pokud jsem odeslal login formulář, tak provádím login
        $name = trim($_POST['username_input']); // získám údaje od uživatele
        $passwd = trim($_POST['passwd_input']);

        if (@authUser($name, $passwd)) { // pokud najdu shodu s DB (@ pro nevyhození chyby)
            setJmeno($name); // Nastavím uživatelské jméno -> do SESSION
            echo "<script>window.location.href = '/index.php';</script>"; // JS na redirect na  index page
        } else { //pokud ne, tak chybová hláška
            errorBox("Uživatel se nenašel nebo heslo nesouhlasí.");
        }
    } elseif (isset($_POST['register'])) { // pokud je post request na registrační form
        $name = trim($_POST['reg_username_input']); // získám data
        $passwd = trim($_POST['reg_passwd_input']); // heslo v plainu
        $passwd2 = trim($_POST['reg_passwd_input2']); // heslo v plainu pro check
        
        if ($passwd !== $passwd2) { // pokud se obě hesla neshodují, tak je konec
            errorBox("Hesla se neshodují!");
            exit;
        }

        $hashedPassword = password_hash($passwd, PASSWORD_DEFAULT); // hashovací funkce

        if (@registerUser($name, $hashedPassword)) { // pokud při porovnání není duplicita u registrace, tak zapisuju
            successBox("Registrace úspěšná, můžete se přihlásit."); // jestli nevracíme false, tak není duplicita na DB -> registrace proběhla
        } else {
            errorBox("Registrace selhala, zkuste to prosím znovu."); // došlo k chybě
        }
    }
}

require INC . '/html_footer.php';
?>
