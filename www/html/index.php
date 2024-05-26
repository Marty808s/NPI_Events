<?php
require '../prolog.php';
require INC . '/html_base.php';
require INC . '/html_nav.php';
require PHP . '/boxes.php';
?>

<div class="container mt-5">
    <h1>Vítejte na rozcestníku vzdělávacích kurzů</h1>
    <p>
    Vítejte na oficiálním rozcestníku vzdělávacích kurzů krajského pracoviště Národního pedagogického institutu (NPI) v Karlových Varech. Naše kurzy jsou zaměřeny na poskytování kvalitního vzdělávání a odborného rozvoje pro učitele a pedagogické pracovníky. Nabízíme širokou škálu kurzů, které pokrývají různé aspekty pedagogiky a vzdělávací praxe, od moderních výukových metod po specifické programy pro rozvoj kompetencí.
    Prozkoumejte naši nabídku kurzů níže a najděte ten pravý, který nejlepší odpovídá vašim profesním potřebám a osobnímu rozvoji.
    </p>
</div>

<?php
// VYtvořím DOM, načtu events.xml
$dom = new DOMDocument();
$dom ->load(XML . '/events.xml');
$dom->preserveWhiteSpace = false;

echo '<div class="container mt-5 mb-5">';

// Všechny kurzy vizualizuju jako div card
$categories = $dom ->getElementsByTagName('category'); // Získám kategorie VP
foreach ($categories as $category) {
    echo '<hr>';
    echo "<h2 class='mb-3'>" . $category->getAttribute('name') . "</h2>";
    echo '<div class="row">';

    $courses = $category->getElementsByTagName('course');
    foreach($courses as $course) {
        echo '<div class="col-md-6 mb-5">';
        echo '<div class="card">';
        echo '<div class="card-body">';

        // Název
        echo "<h5 class='card-title'>" . $course->getElementsByTagName('nazev')[0]->nodeValue . "</h5>";

        // Datum
        echo "<h6 class='card-subtitle mb-2 text-muted'>" . "Datum:" . " " . $course->getElementsByTagName('datum')[0]->nodeValue . "</h6>";

        // Forma
        echo '<div class="form-info mb-2">';
        echo "<h6 class='card-subtitle mb-2 text-muted'>" . "Forma:" . " " . $course->getElementsByTagName('forma')[0]->nodeValue . "</h6>";
        echo "</div>";

        // Anotace
        echo "<p class='card-text'>" . $course->getElementsByTagName('anotace')[0]->nodeValue . "</p>";

        // Odkaz - tady bude redirect přes onclick.php pro sbírání dat o návštěvnosti webu
        $link = $course->getElementsByTagName('odkaz')[0]->nodeValue;
        echo "<form action='php/onclick.php' method='get'>";
        echo "<input type='hidden' name='link' value='" . htmlspecialchars($link) . "'>";
        echo "<button type='submit' class='btn btn-primary'><strong>Více informací!</strong></button>";
        echo "</form>";

        // Kontrola formátu ceny
        $cena = $course->getElementsByTagName('cena')[0]->nodeValue;
        if (ctype_digit($cena) && $cena > 0) { // Zkontrolujte, zda je cena číselná a větší než 0
            echo "<p class='text-right font-weight-bold mt-2'>" . $cena . " Kč" . "</p>";
        } else {
            echo "<p class='text-right font-weight-bold mt-2'>" . "ZDARMA!" . "</p>";
        }

        echo '</div>';  
        echo '</div>';  
        echo '</div>';
    };
    echo '</div>';
};
echo '<hr>';
echo '</div>';

require INC . '/html_footer.php';
?>
