<?php
require '../prolog.php';
require INC . '/html_base.php';
require INC . '/html_nav.php';
require PHP . '/db.php';
require PHP . '/boxes.php';
?>

<div class="container mt-5">
    <form method="post" action="add_event.php">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category-select">Vyberte kategorii VP:</label>
                    <select class="form-control" id="category-select" name="category-select">
                        <option label="Studia" value="Studia"></option>
                        <option label="DIGI kurzy" value="DIGI kurzy"></option>
                        <option label="Kmenové VP" value="Kmenové VP"></option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nazev_VP">Zadejte název VP:</label>
                    <input type="text" class="form-control" id="nazev_VP" name="nazev_VP" placeholder="Jak se bude kurz jmenovat?">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="eduform-select">Vyberte formu realizace:</label>
                    <select class="form-control" id="eduform-select" name="eduform-select">
                        <option label="Prezenční" value="Prezenční"></option>
                        <option label="Online" value="Online"></option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lektor_VP">Zadejte lektora VP:</label>
                    <input type="text" class="form-control" id="lektor_VP" name="lektor_VP" placeholder="Kdo bude kurz lektorovat?">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="anotace_VP">Vložte anotaci VP:</label>
                    <textarea class="form-control" id="anotace_VP" name="anotace_VP" rows="5" placeholder="Vložte anotaci VP"></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cena_VP">Zadejte cenu kurzu:</label>
                    <input type="number" class="form-control" id="cena_VP" name="cena_VP" placeholder="Zadejte cenu kurzu" min="0" step="1">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="prihlaseni-link">Odkaz na přihlášení:</label>
                    <input type="text" class="form-control" id="prihlaseni-link" name="prihlaseni-link" placeholder="Vložte odkaz na přihlášení">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="multi-terms-checkbox" name="multi-terms-checkbox">
                <label class="form-check-label" for="multi-terms-checkbox">Více termínů VP</label>
            </div>
        </div>

        <div id="multi-terms" class="form-group" style="display:none;">
            <label for="terms-schedule">Rozpis termínů:</label>
            <textarea class="form-control" id="terms-schedule" name="terms-schedule" rows="5" placeholder="Zadejte rozpis termínů"></textarea>
        </div>

        <div id="single-term" class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="datetimepicker-date">Vyberte datum:</label>
                    <div class="input-group date" id="datetimepicker-date" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker-date" name="datetimepicker-date"/>
                        <div class="input-group-append" data-target="#datetimepicker-date" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="datetimepicker-time-start">Čas Od:</label>
                    <div class="input-group date" id="datetimepicker-time-start" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker-time-start" name="datetimepicker-time-start"/>
                        <div class="input-group-append" data-target="#datetimepicker-time-start" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-clock"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="datetimepicker-time-end">Čas Do:</label>
                    <div class="input-group date" id="datetimepicker-time-end" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker-time-end" name="datetimepicker-time-end"/>
                        <div class="input-group-append" data-target="#datetimepicker-time-end" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-clock"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Vložit VP</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
$(document).ready(function(){
    $('#datetimepicker-date').datetimepicker({
        format: 'DD/MM/YYYY'
    });
    $('#datetimepicker-time-start').datetimepicker({
        format: 'HH:mm'
    });
    $('#datetimepicker-time-end').datetimepicker({
        format: 'HH:mm'
    });

    $('#multi-terms-checkbox').change(function() {
        if($(this).is(':checked')) {
            $('#multi-terms').show();
            $('#single-term').hide();
        } else {
            $('#multi-terms').hide();
            $('#single-term').show();
        }
    });
});
</script>


<?php
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
        //print_r($requiredFields);
    } else {
        $requiredFields[] = $date;
        $requiredFields[] = $time_start;
        $requiredFields[] = $time_end;
        //print_r($requiredFields);
    }

    // Kontrola stavu
    foreach ($requiredFields as $field) {
        if (empty($field)) {
            errorBox("Všechny pole musí být vyplněny!!");
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
    successBox("Validace OK! - kurz je zapsaný v XML");

    // Vložeí do DB - jen po validaci!
    if (addEvent($category, $nazev, $form_date, $eduform, $lektor, $anotace, $prihlaseni, $cena)) {
        successBox("Kurz je zapsaný v DB!");
    } else {
        errorBox("Došlo k chybě ze strany DB!");
    }

} else {
    //$tempDom ->save($tempFilePath);
    //file_put_contents($tempFilePath, ''); <- vymaže následně obsah tempu
    errorBox("Vznikla chyba...");
    }
}

require INC . '/html_footer.php';
?>