<?php

// Připojíme se na DB
$servername = "database";
$username = "admin";
$password = "heslo";
$database = "npi_events";

// Připojení na DB - working
$db_conn = new mysqli($servername, $username, $password, $database);

function dbQuery($sql, $params = []) {
    global $db_conn;

    $stmt = $db_conn->prepare($sql);
    if (!$stmt) {
        error_log("Chyba při přípravě dotazu: " . $db_conn->error);
        return false;
    }

    if ($params && $stmt->bind_param(str_repeat("s", count($params)), ...$params) === false) {
        error_log("Chyba při vázání parametrů: " . $stmt->error);
        return false;
    }

    if ($stmt->execute() === false) {
        error_log("Chyba při vykonávání dotazu: " . $stmt->error);
        return false;
    }

    $result = $stmt->get_result();
    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC); 
    } else {
        return []; 
    }
}


function authUser($jmeno,$heslo){
    $result = dbQuery("select id from uzivatele where jmeno=? and heslo=?",[$jmeno,$heslo]);

    if ($result){
        return True;
    }else{
        return False;
    }
}


function getEvents()
{
    global $db_conn;

    $events = dbQuery("SELECT * FROM events;"); 

    if ($events) {
        return $events;
    } else {
        return [];
    }
}


function getEventById($id) {
    global $db_conn;
    $res = dbQuery("SELECT * FROM events WHERE id = ?", [$id]);
    return $res;
}


function deleteEventById($id) {
    global $db_conn;
    return dbQuery("DELETE FROM events WHERE id = ?", [$id]);
}


function addEvent($category, $nazev, $form_date, $eduform, $lektor, $anotace, $prihlaseni, $cena) {
    $sql = "INSERT INTO events (kategorie, nazev, datum, forma, lektor, anotace, odkaz, cena) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [$category, $nazev, $form_date, $eduform, $lektor, $anotace, $prihlaseni, $cena];

    // Funkce dbQuery
    $result = dbQuery($sql, $params);
    if ($result === false) {
        error_log("Nepodařilo se vložit událost do databáze.");
        return false;
    }

    return true; // Vrací true, pokud byl dotaz úspěšně proveden
}


function updateEvent($id, $nazev, $datum, $eduform, $lektor, $anotace, $odkaz, $cena){
    $sql = "UPDATE events SET nazev = ?, datum = ?, forma = ?, lektor = ?, anotace = ?, odkaz = ?, cena = ? WHERE id = ?";
    $params = [$nazev, $datum, $eduform, $lektor, $anotace, $odkaz, $cena, $id];

    $result = dbQuery($sql, $params);
    if ($result === false) {
        error_log("Nepodařilo se vložit událost do databáze.");
        return false;
    }
    return true; // Vrací true, pokud byl dotaz úspěšně proveden
}



// Dodělat EscapeDB - retězce pro SQL - ochrana!...
?>
