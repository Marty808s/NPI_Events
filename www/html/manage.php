<?php
require '../prolog.php';
require INC . '/html_base.php';
require INC . '/html_nav.php';
require PHP . '/db.php';

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
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($events as $event) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($event['nazev']) . "</td>";
            echo "<td>" . htmlspecialchars($event['datum']) . "</td>";
            echo "<td>" . htmlspecialchars($event['lektor']) . "</td>"; // Zobrazení lektora
            echo "<td>" . htmlspecialchars($event['cena']) . "</td>";
            
            echo "<td>";
            // Přidání tlačítek Bootstrap s třídami pro styl
            echo "<a href='edit_event.php?id=" . htmlspecialchars($event['id']) . "' class='btn btn-primary btn-sm'>Editovat</a> ";
            echo "<a href='/delete_event.php?id=" . htmlspecialchars($event['id']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Opravdu chcete smazat tuto událost?\");'>Smazat</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<?php
require INC . '/html_footer.php';