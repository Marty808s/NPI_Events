<?php
require '../prolog.php';
require INC . '/html_base.php';
require INC . '/html_nav.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <form method="post" action="/php/user_login.php">
        <div class="form-group">
            <label for="username_input">Přihlašovácí jméno</label>
            <input type="username_input" class="form-control" id="username_input" placeholder="Uživatel">
        </div>

        <div class="form-group">
            <label for="passwd_input">Heslo</label>
            <input type="passwd_input" class="form-control" id="passwd_input" placeholder="Heslo">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Přihlaste se</button>
        </div>

        </form>
    </div>
</div>

<?php
require INC . '/html_footer.php'
?>