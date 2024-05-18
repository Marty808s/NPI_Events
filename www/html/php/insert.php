<?php
require(__DIR__ . '/../../prolog.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category-select'];
    $nazev = $_POST['nazev_VP'];
    $eduform = $_POST['eduform-select'];
    $lektor = $_POST['lektor_VP'];
    $anotace = $_POST['anotace_VP'];
    $cena = $_POST['cena_VP'];

    if ($cena == '0') {
        $cena = "ZDARMA";
    }
    $prihlaseni = $_POST['prihlaseni-link'];

    $multi_terms = isset($_POST['multi-terms-checkbox']);
    $terms_schedule = $_POST['terms-schedule'];
    $date = $_POST['datetimepicker-date'];
    $time_start = $_POST['datetimepicker-time-start'];
    $time_end = $_POST['datetimepicker-time-end'];

    $form_date = $date . " " . $time_start . " - " . $time_end;

    // Načtení XML souboru
    $filePath = XML . '/events.xml';
    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->load($filePath);

    // Najít kořenový prvek
    $root = $dom->documentElement;

    // Najít příslušnou kategorii
    $categoryElement = null;
    foreach ($root->getElementsByTagName('category') as $cat) {
        if ($cat->getAttribute('name') === $category) {
            $categoryElement = $cat;
            break;
        }
    }

    // Vytvoření nového kurzu
    $newCourse = $dom->createElement('course');
    $categoryElement->appendChild($newCourse);

    // Přidání jednotlivých prvků kurzu
    $elements = [
        'nazev' => $nazev,
        'datum' => $form_date,
        'forma' => $eduform,
        'lektor' => $lektor,
        'anotace' => $anotace,
        'odkaz' => $prihlaseni,
        'cena' => $cena
    ];

    foreach ($elements as $tag => $value) {
        $element = $dom->createElement($tag, $value);
        $newCourse->appendChild($element);
    }

    // Uložení aktualizovaného XML souboru
    $dom->save($filePath);

    echo "Vloženo do XML souboru!";
} else {
    echo "Formulář nebyl odeslán.";
}
?>
