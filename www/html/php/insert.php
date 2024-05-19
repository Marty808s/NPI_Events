<?php
require(__DIR__ . '/../../prolog.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category-select'];
    $nazev = trim($_POST['nazev_VP']);
    $eduform = trim($_POST['eduform-select']);
    $lektor = trim($_POST['lektor_VP']);
    $anotace = trim($_POST['anotace_VP']);
    $cena = trim($_POST['cena_VP']);

    if ($cena == '0') {
        $cena = "ZDARMA";
    }
    $prihlaseni = trim($_POST['prihlaseni-link']);

    $multi_terms = isset($_POST['multi-terms-checkbox']);
    $terms_schedule = trim($_POST['terms-schedule']);
    $date = trim($_POST['datetimepicker-date']);
    $time_start = trim($_POST['datetimepicker-time-start']);
    $time_end = trim($_POST['datetimepicker-time-end']);

    /*
        trim() - odebere mezery na konci a na začátku stringu
        isset() - vraci T/F jestli existuje proměná - je definována
    */ 
    
    $requiredFields = [
        $nazev, $eduform, $lektor, $anotace, $cena, $prihlaseni
    ];

    if ($multi_terms) {
        $requiredFields[] = $terms_schedule;
    } else {
        $requiredFields[] = $date;
        $requiredFields[] = $time_start;
        $requiredFields[] = $time_end;
    }

    foreach ($requiredFields as $field) {
        if (empty($field)) {
            echo "Všechny položky musí být vyplněny! - Chyba.";
            exit;
        }
    }

    if ($multi_terms) {
        $form_date = $terms_schedule;
    } else {
        $form_date = $date . " " . $time_start . " - " . $time_end;
    }

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

    // Validace aktualizovaného XML dokumentu proti XSD
    if ($dom->schemaValidate(XML . '/validate.xsd')) {
        // Pokud je validní, uložení aktualizovaného XML souboru
        $dom->save($filePath);
        echo "Vloženo do XML souboru - XML je valid.";
    } else {
        // Pokud není validní, odstraňte nový kurz
        $categoryElement->removeChild($newCourse);
        echo "XML je invalid. Proběhne vymazání vloženého kurzu.";
    }
} else {
    echo "Formulář nebyl odeslán.";
}
?>
