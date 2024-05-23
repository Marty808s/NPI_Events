<?php
require '../prolog.php';
require INC . '/html_base.php';
require INC . '/html_nav.php';
require PHP . '/db.php';
require PHP . '/boxes.php';

if (isset($_GET['id'])){
    $eventId = $_GET['id'];
    $_SESSION['eventId'] = $eventId;

    $eventData = getEventById($eventId);

    if ($eventData){
        //print_r($eventData);
    ?>
    <div class="container mt-5">
        <form method="post" action="edit_event.php">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nazev_VP">Název VP:</label>
                        <input type="text" class="form-control" id="nazev_VP" name="nazev_VP" value="<?php echo htmlspecialchars($eventData[0]['nazev']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="datum_VP">Datum:</label>
                        <input type="text" class="form-control" id="datum_VP" name="datum_VP" value="<?php echo htmlspecialchars($eventData[0]['datum']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="lektor_VP">Lektor:</label>
                        <input type="text" class="form-control" id="lektor_VP" name="lektor_VP" value="<?php echo htmlspecialchars($eventData[0]['lektor']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="odkaz_VP">Odkaz:</label>
                        <input type="text" class="form-control" id="odkaz_VP" name="odkaz_VP" value="<?php echo htmlspecialchars($eventData[0]['odkaz']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="cena_VP">Cena kurzu:</label>

                        <?php
                            $cena = htmlspecialchars($eventData[0]['cena']);
                            if ($cena === "ZDARMA"){
                                $cena=0;
                            }
                            echo "<input type='number'class='form-control' id='cena_VP' name='cena_VP' value='$cena' min='0' step='1' required>"
                         ?>
                    
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="eduform-select">Forma realizace:</label>
                        <select class="form-control" id="eduform-select" name="eduform-select">
                            <?php
                            $currentForm = htmlspecialchars($eventData[0]['forma']);
                            $options = ['Prezenční', 'Online'];
                            foreach ($options as $option) {
                                $selected = ($currentForm === $option) ? ' selected' : '';
                                echo "<option value='$option'$selected>$option</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="anotace_VP">Anotace:</label>
                        <textarea class="form-control" id="anotace_VP" name="anotace_VP" required><?php echo htmlspecialchars($eventData[0]['anotace']); ?></textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Uložit změny</button>
        </form>
    </div>

<?php
    }else {
        errorBox("Kurz který chcete upravit není v DB");
    }
}

//Logika
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $eventId = $_SESSION['eventId'];
    $eventData = getEventById($eventId);

    // Získám vstupy z formuláře
    $nazev = trim($_POST['nazev_VP']);
    $datum = trim($_POST['datum_VP']);
    $eduform = trim($_POST['eduform-select']);
    $lektor = trim($_POST['lektor_VP']);
    $anotace = trim($_POST['anotace_VP']);
    $cena = trim($_POST['cena_VP']);
    $odkaz = trim($_POST['odkaz_VP']);


    // Načtení DOM souvoru - events.xml
    $filePath = XML . '/events.xml';
    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->load($filePath);

    $categories = $dom->getElementsByTagName('category');
    foreach ($categories as $category) {
        $courses = $category->getElementsByTagName('course');
        foreach ($courses as $course) {
            $c_nazev = $course->getElementsByTagName('nazev')->item(0);
            //echo $c_nazev->nodeValue;
            $c_datum = $course->getElementsByTagName('datum')->item(0);
            //echo $c_datum->nodeValue;

            if ($c_nazev->nodeValue === $eventData[0]['nazev'] && $c_datum->nodeValue === $eventData[0]['datum'] ) {
                //echo "Našel jsem kurz!";
                $c_nazev->nodeValue = $nazev;
                $c_datum->nodeValue = $datum;
                $course->getElementsByTagName('forma')->item(0)->nodeValue = $eduform;
                $course->getElementsByTagName('anotace')->item(0)->nodeValue = $anotace;
                $course->getElementsByTagName('odkaz')->item(0)->nodeValue = $odkaz;
                $course->getElementsByTagName('cena')->item(0)->nodeValue = $cena;

                // AKtualizace DB
                $update = updateEvent($eventId, $nazev, $datum, $eduform, $lektor, $anotace, $odkaz, $cena);

                if ($update){
                    successBox("Došlo k aktualizaci záznamu [DB i XML]");
                    echo "<script>setTimeout(function() { window.location.href = '/index.php'; }, 1000);</script>";
                }else{
                    errorBox("Došlo k chybě při aktualizaci");
                }

                $dom->save($filePath);
            }
        }
    }
}

require INC . '/html_footer.php';
?>