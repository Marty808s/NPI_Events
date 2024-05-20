<?php

// Připojíme se na DB
$servername = "database";
$username = "admin";
$password = "heslo";
$database = "npi_events";

// Připojení na DB - working
$db_conn = new mysqli($servername, $username, $password, $database);

function dbQuery(string $query): bool|mysqli_result
{
    global $db_conn;
    return $db_conn->query($query);
}


// Dodělat EscapeDB - retězce pro SQL - ochrana!...
// Triger na přidání do mysql...
?>
