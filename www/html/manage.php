<?php
require '../prolog.php';
require INC . '/html_base.php';
require INC . '/html_nav.php';
require PHP . '/db.php';

// Načtení event.xml - DOM soubor
$dom = new DOMDocument();
$dom->load(XML . '/events.xml');

$id_query = dbQuery("SELECT * FROM `events`;");


function getIdEvent()
{
    global $db_conn; 

    $id_query = dbQuery("SELECT `id` FROM `events`;");

    if ($id_query instanceof mysqli_result) {
        while ($row = $id_query->fetch_assoc()) {
            echo 'ID: ' . htmlspecialchars($row['id']) . '<br>';
        }
    } else {
        echo "Chyba při dotazu na databázi.";
    }
}

getIdEvent();

require INC . '/html_footer.php';