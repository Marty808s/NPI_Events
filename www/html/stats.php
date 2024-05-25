<?php
require '../prolog.php';
require INC . '/html_base.php';
require INC . '/html_nav.php';
require PHP . '/boxes.php';
require PHP . '/db.php';
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function createPieChart(labels, data) {
    var ctx = document.getElementById('chartCanvas').getContext('2d');
    var pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40'
                ],
                hoverBackgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    return pieChart;
}
</script>

<?php
if (isUser()){
    $name = $_SESSION['jmeno'];
    $data = generateClicksReportByOrganizer($name);
    $labels = array_column($data, 'nazev');
    $counts = array_column($data, 'zobrazeno');
    ?>
    <div class="container mt-5">
        <h2 class="text-center">Statistiky vzdělávacích programů - prokliky</h2>
        <div class="row">
            <div class="col-md-12">
                <canvas id="chartCanvas"></canvas>
            </div>
        </div>
    </div>
    <script>
        // JS -> na graf - volám funkci createPieChart - naplním daty z php (query)
        document.addEventListener('DOMContentLoaded', function() {
            var labels = <?php echo json_encode($labels); ?>;
            var data = <?php echo json_encode($counts); ?>;
            createPieChart(labels, data);
        });
    </script>



<?php
} else {
    errorBox('Nemáš právo zobrazovat statistiky / Nemáš kurzy - nejsi organizátor!');
}

require INC . '/html_footer.php';
?>
