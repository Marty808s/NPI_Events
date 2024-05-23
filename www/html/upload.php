<?php
require '../prolog.php';
require INC . '/html_base.php';
require INC . '/html_nav.php';
require PHP . '/db.php';
require PHP . '/boxes.php';
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
    $targetDirectory = XML . '/upload/';
    $targetFile = $targetDirectory . basename($_FILES["xmlFile"]["name"]);
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($fileType != "xml") {
        errorBox("Omlouváme se, jsou povoleny pouze XML soubory.");
        return;
    }

    if (move_uploaded_file($_FILES["xmlFile"]["tmp_name"], $targetFile)) {
        $dom_upload = new DOMDocument();
        $dom_upload->load($targetFile);

        $eventsDOM = new DOMDocument();
        $eventsDOM->preserveWhiteSpace = false;
        $eventsDOM->formatOutput = true;
        $eventsDOM->load(XML . '/events.xml');

        if ($dom_upload->schemaValidate(XML . '/validate.xsd')) {
            $uploadedCourses = $dom_upload->getElementsByTagName('course');
            foreach ($uploadedCourses as $uploadedCourse) {
                // Aby neřvalo - použít ->item(0)->nodeValue
                $nazev = $uploadedCourse->getElementsByTagName('nazev')[0]->textContent;
                $datum = $uploadedCourse->getElementsByTagName('datum')[0]->textContent;
                $forma = $uploadedCourse->getElementsByTagName('forma')[0]->textContent;
                $lektor = $uploadedCourse->getElementsByTagName('lektor')[0]->textContent;
                $anotace = $uploadedCourse->getElementsByTagName('anotace')[0]->textContent;
                $odkaz = $uploadedCourse->getElementsByTagName('odkaz')[0]->textContent;
                $cena = $uploadedCourse->getElementsByTagName('cena')[0]->textContent;
                $category = $uploadedCourse->parentNode->getAttribute('name'); // Předpokládáme, že <course> je přímo pod <category>

                $categoryNode = null;
                foreach ($eventsDOM->getElementsByTagName('category') as $cat) {
                    if ($cat->getAttribute('name') === $category) {
                        $categoryNode = $cat;
                        break;
                    }
                }

                // Zápis od XML events
                $newCourse = $eventsDOM->importNode($uploadedCourse, true);
                $categoryNode->appendChild($newCourse);

                
                // Volání funkce pro vložení do databáze
                $result = addEvent($category, $nazev, $datum, $forma, $lektor, $anotace, $odkaz, $cena);

                if (!$result) {
                    errorBox("Chyba při vkládání kurzu do databáze.");
                }

            }

            $eventsDOM->save(XML . '/events.xml');
            successBox("Soubor byl úspěšně nahrán a kurzy přidány do příslušných kategorií a databáze.");

        } else {
            errorBox("Nahrávaný soubor nevyhovuje požadovanému schématu.");
        }

    } else {
        errorBox("Nastala chyba při nahrávání souboru.");
    }
}

require INC . '/html_footer.php';
