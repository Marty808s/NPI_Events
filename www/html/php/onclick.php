<?php
require '../../prolog.php';
require PHP . '/db.php';

// Pokud kliknu na link, tak přičtu zobrazeno v DB
if (isset($_GET['link'])) {
    $link = $_GET['link'];
    // Ověření, že link je platná URL
    if (filter_var($link, FILTER_VALIDATE_URL) && clickLink($link)) {
        echo "<script>window.location.href='" . htmlspecialchars($link) . "';</script>";
        exit;
    } else {
        errorBox('Chyba při zobrazení kurzu - špatný odkaz');
        echo "<script>setTimeout(function() { window.location.href = '../index.php'; }, 1000);</script>";
        exit;
    }
}
?>