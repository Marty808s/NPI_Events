<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category-select'];
    $nazev = $_POST['nazev_VP'];
    $eduform = $_POST['eduform-select'];
    $lektor = $_POST['lektor_VP'];
    $anotace = $_POST['anotace_VP'];
    $cena = $_POST['cena_VP'];

    if ($cena == '0') {
        $cena = "ZDARMA";
    } else {

    }
    $prihlaseni = $_POST['prihlaseni-link'];

    $multi_terms = isset($_POST['multi-terms-checkbox']);
    $terms_schedule = $_POST['terms-schedule'];
    $date = $_POST['datetimepicker-date'];
    $time_start = $_POST['datetimepicker-time-start'];
    $time_end = $_POST['datetimepicker-time-end'];

    echo "Kategorie: $category<br>";
    echo "Název: $nazev<br>";
    echo "Forma realizace: $eduform<br>";
    echo "Lektor: $lektor<br>";
    echo "Anotace: $anotace<br>";
    echo "Cena: $cena<br>";
    echo "Přihlášení: $prihlaseni<br>";

    if ($multi_terms) {
        echo "Více termínů: Ano<br>";
        echo "Rozpis termínů: $terms_schedule<br>";
    } else {
        echo "Datum: $date<br>";
        echo "Čas Od: $time_start<br>";
        echo "Čas Do: $time_end<br>";
        $terms_schedule = $date . " " . $time_start . " - " . $time_end;
        echo "Rozpis termínů: $terms_schedule";
    }
}else {
    echo "Formulář nebyl odeslán.";
}
