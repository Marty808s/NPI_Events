<?php
require '../prolog.php';
require INC . '/html_base.php';
require INC . '/html_nav.php';
require PHP . '/db.php';
require PHP . '/boxes.php';

$events = getEvents();

?>
<div class="container mt-5">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Název</th>
                <th>Datum</th>
                <th>Lektor</th>
                <th>Cena</th>
                <th>Forma</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($events as $event) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($event['nazev']) . "</td>";
            echo "<td>" . htmlspecialchars($event['datum']) . "</td>";
            echo "<td>" . htmlspecialchars($event['lektor']) . "</td>";
            echo "<td>" . htmlspecialchars($event['cena']) . "</td>";
            echo "<td>" . htmlspecialchars($event['forma']) . "</td>";
            if (isAdmin()) {
                echo "<td>" . htmlspecialchars($event['organizator']) . "</td>";
            }
            echo "<td>";
            echo "<a href='edit_event.php?id=" . htmlspecialchars($event['id']) . "' class='btn btn-primary btn-sm'>Editovat</a> ";
            echo "<a href='manage.php?id=" . htmlspecialchars($event['id']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Opravdu chcete smazat tuto událost?\");'>Smazat</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<?php

$events = getEvents();

// Načtení event.xml - DOM soubor
$dom = new DOMDocument();
$dom->load(XML . '/events.xml');

function deleteCourseFromXML($dom, $courseName, $courseDate) {
    $categories = $dom->getElementsByTagName('category');
    foreach ($categories as $category) {
        $courses = $category->getElementsByTagName('course');
        foreach ($courses as $course) {
            $nazev = $course->getElementsByTagName('nazev')[0];
            $datum = $course->getElementsByTagName('datum')[0];
            if ($nazev->nodeValue === $courseName && $datum->nodeValue === $courseDate) {
                $category->removeChild($course);
                $dom->save(XML . '/events.xml'); // Ulož změny zpět do souboru
                return true; // Vrátí úspěch po smazání
            }
        }
    }
    return false; // Vrátí neúspěch, pokud se kurz nenašel
}


if (isset($_GET['id'])){
    // Získám Id z GET
    $eventId = $_GET['id'];
    $eventData = getEventById($eventId);

    if ($eventData) {
        // Smazání z DB
        $courseName = $eventData[0]['nazev'];
        $courseDate = $eventData[0]['datum'];

        deleteEventById($eventId);

        if (deleteCourseFromXML($dom, $courseName, $courseDate)) {
            successBox("Vymazání proběhlo úspěšně!");
            echo "<script>setTimeout(function() { window.location.href = '/manage.php'; }, 1000);</script>";
        } else {
            errorBox("Nastala chyba při mazání!");
            echo "<script>setTimeout(function() { window.location.href = '/manage.php'; }, 1000);</script>";
        }

    } else {

    }
}

require INC . '/html_footer.php';