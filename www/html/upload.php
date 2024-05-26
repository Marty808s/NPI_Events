<?php
require '../prolog.php';
require INC . '/html_base.php';
require INC . '/html_nav.php';
require PHP . '/db.php';
require PHP . '/boxes.php';

if (!isUser()){
    echo "<script>setTimeout(function() { window.location.href = '/index.php'; }, 1000);</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Nahrát XML Soubor</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Nahrát XML Soubor</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="xmlFile" class="form-label">Vyberte XML soubor k nahrání:</label>
                        <input type="file" class="form-control" name="xmlFile" id="xmlFile" accept=".xml">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Nahrát</button>
                </form>
            </div>
        </div>
    </div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["xmlFile"])) {
    // Místo pro ukládání uploaded souborů
    $targetDirectory = XML . '/upload/';
    // Celá cesta pro konečné umístění souboru...
    $targetFile = $targetDirectory . basename($_FILES["xmlFile"]["name"]);
    // Přípona souboru
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    if ($fileType != "xml") {
        errorBox("Omlouváme se, jsou povoleny pouze XML soubory.");
        return;
    }

    // Přesun nahraného souboru do cílového adresáře
    if (move_uploaded_file($_FILES["xmlFile"]["tmp_name"], $targetFile)) {
        $dom_upload = new DOMDocument();
        $dom_upload->load($targetFile);

        $eventsDOM = new DOMDocument();
        $eventsDOM->preserveWhiteSpace = false;
        $eventsDOM->formatOutput = true;
        $eventsDOM->load(XML . '/events.xml');

        libxml_use_internal_errors(true);

        //Pokud to projde validací tak:
        if ($dom_upload->schemaValidate(XML . '/validate.xsd')) {
            // Získání kurzů z nahraného souboru
            $uploadedCourses = $dom_upload->getElementsByTagName('course');
            // Projde kurzy a definuje elementy (hodnoty) pro vložení do DB
            foreach ($uploadedCourses as $uploadedCourse) {
                // Aby neřvalo - použít ->item(0)->nodeValue
                $nazev = $uploadedCourse->getElementsByTagName('nazev')[0]->textContent;
                $datum = $uploadedCourse->getElementsByTagName('datum')[0]->textContent;
                $forma = $uploadedCourse->getElementsByTagName('forma')[0]->textContent;
                $lektor = $uploadedCourse->getElementsByTagName('lektor')[0]->textContent;
                $anotace = $uploadedCourse->getElementsByTagName('anotace')[0]->textContent;
                $odkaz = $uploadedCourse->getElementsByTagName('odkaz')[0]->textContent;
                $cena = $uploadedCourse->getElementsByTagName('cena')[0]->textContent;
                $category = $uploadedCourse->parentNode->getAttribute('name');

                $categoryNode = null;
                // Projdeme kategorie events.xml pro následný importNode
                foreach ($eventsDOM->getElementsByTagName('category') as $cat) {
                    if ($cat->getAttribute('name') === $category) {
                        $categoryNode = $cat;
                        break;
                    }
                }

                // Zápis od XML events
                    // Importuju nový kurz jako Node
                $newCourse = $eventsDOM->importNode($uploadedCourse, true);
                    // Přidám nov kurz do příslušné kategorie v events.xml
                $categoryNode->appendChild($newCourse);

                
                // Volání funkce pro vložení do databáze
                $result = addEvent($category, $nazev, $datum, $forma, $lektor, $anotace, $odkaz, $cena, getName());

                if (!$result) {
                    errorBox("Chyba při vkládání kurzu do databáze.");
                }

            }
            // Uložení souboru po všech zápisech
            $eventsDOM->save(XML . '/events.xml');
            successBox("Soubor byl úspěšně nahrán a kurzy přidány do příslušných kategorií a databáze.");
            echo "<script>setTimeout(function() { window.location.href = '/manage.php'; }, 1000);</script>";

        } else {
            // Vypsáni chyby schématu:
            $errorDetails = libxml_get_last_error();
            if ($errorDetails) {
                $errorMessage = "Nahrávaný soubor nevyhovuje požadovanému schématu. Chyba: " . $errorDetails->message . " na řádku " . $errorDetails->line;
                errorBox($errorMessage);
            } else {
                errorBox("Došlo k chybě při validaci XML souboru.");
            }
        }

    } else {
        errorBox("Nastala chyba při nahrávání souboru.");
    }
}
// Vyčistíme výstup z Validate funkce - necháme jen errorbox
libxml_clear_errors();


require INC . '/html_footer.php';

