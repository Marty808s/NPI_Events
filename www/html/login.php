<?php
require '../prolog.php';
require INC . '/html_base.php';
require INC . '/html_nav.php';
require PHP . '/db.php';
require PHP . '/boxes.php';

if (isUser()){
    setJmeno();
    successBox("Jste odhlášeni..");
    echo "<script>setTimeout(function() { window.location.href = '/index.php'; }, 1000);</script>";
    exit;
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <form method="post" action="/login.php">
            <div class="form-group">
                <label for="username_input">Přihlašovácí jméno</label>
                <input type="text" class="form-control" name="username_input" id="username_input" placeholder="Uživatel">
            </div>

            <div class="form-group">
                <label for="passwd_input">Heslo</label>
                <input type="password" class="form-control" name="passwd_input" id="passwd_input" placeholder="Heslo">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Přihlaste se</button>
            </div>
        </form>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = trim($_POST['username_input']);
    $passwd = trim($_POST['passwd_input']);

    $auth = authUser($name,$passwd);
    if ($auth){
        setJmeno($name);
        echo "<script>window.location.href = '/index.php';</script>";
    } else {
        errorBox("Uživatel se nenašel");
    }
}

require INC . '/html_footer.php';
?>
