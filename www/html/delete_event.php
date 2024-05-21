<?php
require '../prolog.php';
require PHP . '/db.php';

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
        echo "Událost byla smazána z DB.";

        if (deleteCourseFromXML($dom, $courseName, $courseDate)) {
            echo "Událost byla smazána z DB i XML.";
        } else {
            echo "Nastala chyba při mazání události z XML.";
        }

    } else {
        echo "Nastala chyba při mazání události.";
    }

    header("Location: /manage_events.php");
    exit;

}
