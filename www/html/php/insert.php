<?php
require(__DIR__ . '/../../prolog.php');
require(PHP . '/db.php');

// Získám vstupy z formulářů - 'Přidej VP'
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category-select'];
    $nazev = trim($_POST['nazev_VP']);
    $eduform = trim($_POST['eduform-select']);
    $lektor = trim($_POST['lektor_VP']);
    $anotace = trim($_POST['anotace_VP']);
    $cena = trim($_POST['cena_VP']);

    // Možná nechat 0 - ale až při interpretaci na webu? - aby XSD bylo xs:string?
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
    
    
    // Kontrola ze strany serveru - zda ve všech možnostech byly vyplněny pole
    $requiredFields = [
        $nazev, $eduform, $lektor, $anotace, $cena, $prihlaseni
    ];

    if ($multi_terms) {
        $requiredFields[] = $terms_schedule;
        print_r($requiredFields);
    } else {
        $requiredFields[] = $date;
        $requiredFields[] = $time_start;
        $requiredFields[] = $time_end;
        print_r($requiredFields);
    }

    // Kontrola stavu
    foreach ($requiredFields as $field) {
        if (empty($field)) {
            echo "Všechny položky musí být vyplněny! - Chyba.";
            exit;
        }
    }

    if ($multi_terms) {
        // Přiřadím date - mám textové pole - rozpis termínů
        $form_date = $terms_schedule;
    } else {
        // Přiřadím date - spojím jednotlivé pickery
        $form_date = $date . " " . $time_start . " - " . $time_end;
    }


    // Načtení XML souboru - pro všechny VP + Temp file pro validaci
    $filePath = XML . '/events.xml';
    $tempFilePath = XML. 'temp.xml';
    
    // Temp XML file - pro kontrolu
    $tempDom = new DOMDocument();
    $tempDom->preserveWhiteSpace = false;
    $tempDom->formatOutput = true;

    // Nahrání kořenu - 'element' tag
    $tempDom->loadXML('<education></education>');

    // Element - 'category'
    $newCategory = $tempDom->createElement('category');
    // Následně přidám atribut s hodnotou kategorie z formu
    $newCategory ->setAttribute('name', $category);
    // Vytvořím element 'course'
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

    // Do tempu ahraju elementy i s hodnotami - přidám jako potomka do elementu 'course'
    foreach ($elements as $tag => $value) {
        $element = $tempDom->createElement($tag, $value);
        $newCourse->appendChild($element);
    }

    // Přidání poromka
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

    // Importování Node do DOM events.xml
    $importedNode = $dom->importNode($newCourse, true);
    $categoryElement->appendChild($importedNode);
    $dom->save(XML . '/events.xml');
    echo "Vloženo do XML souboru - XML je valid.";

    // Vložeí do DB - jen po validaci!
    if (addEvent($category, $nazev, $form_date, $eduform, $lektor, $anotace, $prihlaseni, $cena)) {
        echo "Událost byla úspěšně vložena do databáze.";
    } else {
        echo "Nastala chyba při vkládání události.";
    }

} else {
    //$tempDom ->save($tempFilePath);
    //file_put_contents($tempFilePath, ''); <- vymaže následně obsah tempu
    echo "XML je invalid. Změny nebyly provedeny.";
    }
}
?>