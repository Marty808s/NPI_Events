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
        isset() - vraci T/F jestli existuje proměnná - je definována
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


    // Načtení XML souboru - pro všechny VP + Temp file pro validaci
    $filePath = XML . '/events.xml';
    $tempFilePath = XML. 'temp.xml';
    
    // Temp XML file - pro kontrolu
    $tempDom = new DOMDocument();
    $tempDom->preserveWhiteSpace = false;
    $tempDom->formatOutput = true;
    $tempDom->loadXML('<education></education>');

    $newCategory = $tempDom->createElement('category');
    $newCategory ->setAttribute('name', $category);
    $newCourse = $tempDom->createElement('course');

    // Definnování elementů
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
        $element = $tempDom->createElement($tag, $value);
        $newCourse->appendChild($element);
    }

    $newCategory->appendChild($newCourse);
    $tempDom->documentElement->appendChild($newCategory);

   // Validace Temp souboru s XSD - pokud OK, tak přidávám do events.xml
   if ($tempDom->schemaValidate(XML . '/validate.xsd')) {
    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->load($filePath);

    // Najdu element příslušné kategorie - pak do něj importuju Node z Tempu
    $categoryElement = null;
    foreach ($dom->getElementsByTagName('category') as $cat) {
        if ($cat->getAttribute('name') === $category) {
            $categoryElement = $cat;
            break;
        }
    }

    // Importování Node
    $importedNode = $dom->importNode($newCourse, true);
    $categoryElement->appendChild($importedNode);
    $dom->save(XML . '/events.xml');
    echo "Vloženo do XML souboru - XML je valid.";

} else {
    //$tempDom ->save($tempFilePath);
    //file_put_contents($tempFilePath, ''); <- vymaže následně obsah tempu
    echo "XML je invalid. Změny nebyly provedeny.";
    }
}
?>