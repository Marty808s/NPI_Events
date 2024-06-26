<?php
// Připojíme se na DB
$servername = "database";
$username = "admin";
$password = "heslo";
$database = "npi_events";

// Připojení na DB - working
$db_conn = new mysqli($servername, $username, $password, $database);


// Posílání dotazů na DB - s parametry $sql - to je dotaz, na něj navážu parametry přes bind_param
function dbQuery($sql, $params = []) {
    global $db_conn;

    $stmt = $db_conn->prepare($sql);

    //proběhla příprava úspěšně? existuje tabulka?...atd..
    if (!$stmt) {
        error_log("Chyba při přípravě dotazu: " . $db_conn->error);
        return false;
    }

    // pokud nezadám parametry ani dotaz - dochází k navazáí parametrů na dotaz
    if ($params && $stmt->bind_param(str_repeat("s", count($params)), ...$params) === false) {
        error_log("Chyba při vázání parametrů: " . $stmt->error);
        return false;
    }

    // pokud se nevykoná dotaz
    if ($stmt->execute() === false) {
        error_log("Chyba při vykonávání dotazu: " . $stmt->error);
        return false;
    }

    // získání výsledků
    $result = $stmt->get_result();
    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC); 
    } else {
        return []; 
    }
}


// Získej eventy!
function getEvents()
{
    // pokud jsem admin dostavu všechny záznamy - od všech userů
    if (isAdmin()) {
        return dbQuery("SELECT * FROM events");
    } else { // pokud ne, tak jen moje kurzy - uživatele
        return dbQuery("SELECT * FROM events WHERE organizator = ?", [getName()]);
    }
}


// Získej event podle id
function getEventById($id) {
    global $db_conn;
    $res = dbQuery("SELECT * FROM events WHERE id = ?", [$id]);
    if ($res){}
    return $res;
}


// Smaž event z db podle id
function deleteEventById($id) {
    global $db_conn;
    return dbQuery("DELETE FROM events WHERE id = ?", [$id]);
}


// Přidej event podle jednotlivých infromací - parametrů
function addEvent($category, $nazev, $form_date, $eduform, $lektor, $anotace, $prihlaseni, $cena, $organizator) {
    $sql = "INSERT INTO events (kategorie, nazev, datum, forma, lektor, anotace, odkaz, cena, organizator) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [$category, $nazev, $form_date, $eduform, $lektor, $anotace, $prihlaseni, $cena, $organizator];

    // Funkce dbQuery
    $result = dbQuery($sql, $params);
    if ($result === false) {
        error_log("Nepodařilo se vložit událost do databáze.");
        return false;
    }

    return true; // Vrací true, pokud byl dotaz úspěšně proveden
}


// Aktualizuj event v db
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


// Přidej usera / registruj ho
function registerUser($username, $hashedPassword) {
    global $db_conn;

    // Spočti mi počet uživatel v db s tímto jménem
    $stmt = $db_conn->prepare("SELECT COUNT(*) FROM uzivatele WHERE jmeno = ?");
    if (!$stmt) {
        return false; 
    }
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // Pokud jich je víc, vrať false - už je registrovaný
    if ($count > 0) {
        return false;
    }

    // dotaz na db
    $stmt = $db_conn->prepare("INSERT INTO uzivatele (jmeno, heslo) VALUES (?, ?)");
    if (!$stmt) {
        return false;
    }
    // bind parametrů na dotaz
    $stmt->bind_param('ss', $username, $hashedPassword);
    return $stmt->execute();
}


// Ověř uživatele - jeho údaje pro přihlášení
function authUser($username, $password) {
    global $db_conn;

    // Najdi heslo uzivatele ____
    $stmt = $db_conn->prepare("SELECT heslo FROM uzivatele WHERE jmeno = ?");
    if (!$stmt) {
        errorBox("Chyba při přípravě dotazu: " . $db_conn->error);
        return false;
    }
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($hashedPasswordFromDb);
    $stmt->fetch();
    $stmt->close();

    // Vrať mi, jestli hesla sedí nebo ne (hashe), pokud ano, je to on!
    return password_verify($password, $hashedPasswordFromDb);
}

//Onclick funkce - přidej +1 zobrazeno v db pro daný odkaz (TO:DO - pokud budou duplicity? ošetřit!)
function clickLink($link){
    global $db_conn;
    
    // najdi daný kurz a aktualizuj počet zobrazení
    $stmt = $db_conn->prepare("UPDATE events SET zobrazeno = zobrazeno + 1 WHERE odkaz = ?");
    if (!$stmt) {
        errorBox("Chyba při přípravě dotazu: " . $db_conn->error);
        return false;
    }
    $stmt->bind_param('s', $link);
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

// Příprava datasetu z DB pro vizualizaci prokliků kurzů organizátora
function generateClicksReportByOrganizer($organizerName) {
    global $db_conn;

    // Příprava SQL dotazu pro získání počtu prokliků na kurzy podle zadaného organizátora
    if (isAdmin()) {
        $stmt = $db_conn->prepare("SELECT nazev, zobrazeno FROM events ORDER BY zobrazeno DESC");
    } else {
        $stmt = $db_conn->prepare("SELECT nazev, zobrazeno FROM events WHERE organizator = ? ORDER BY zobrazeno DESC");
        $stmt->bind_param('s', $organizerName);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return false;
    }
}

?>
