<?php
require '../prolog.php';
require INC . '/html_base.php';
require INC . '/html_nav.php';
require PHP . '/boxes.php';
require PHP . '/db.php';
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

// piechart
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
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'left',
                align: 'start',
                labels: {
                    fontColor: '#333',
                    fontSize: 14,
                    boxWidth: 20
                }
            }
        }
    });
    return pieChart;
}

// barplot
function createBarPlot(labels, data) {
    var ctx = document.getElementById('chartCanvas2').getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Dataset',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            legend: {
                display: false
            }
        }
    });
    return barChart;
}

</script>

<?php
if (isUser()){
    $name = $_SESSION['jmeno'];
    $data = generateClicksReportByOrganizer($name);
    if ($data) {
        $labels = array_column($data, 'nazev');
        $counts = array_column($data, 'zobrazeno');
    } else {
        errorBox('Nemáš data k zpracování - zkus uploadnou nějaký kurz..');
        exit;
    }
    ?>
    <div class="container mt-5">
        <h2 class="text-center">Statistiky vzdělávacích programů - prokliky</h2>
        <p class="text-center">Všechny prokliky Vašich vypsaných vzdělávacích akcích můžete sledovat zde:</p>
        <div class="row">
            <div class="col-md-6">
                <canvas id="chartCanvas" style="max-width: 600px; max-height: 400px;"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="chartCanvas2" style="max-width: 600px; max-height: 400px;"></canvas>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var labels = <?php echo json_encode($labels); ?>;
                    var data = <?php echo json_encode($counts); ?>;
                    createPieChart(labels, data);
                    createBarPlot(labels, data);
                });
            </script>
        </div>
        <table class="table table-striped table-hover mt-5 mb-5">
            <tr>
                <th>Název</th>
                <th>Zobrazeno</th>
            </tr>
            <?php foreach ($data as $row) { ?>
                <tr>
                    <td><?php echo $row['nazev']; ?></td>
                    <td><?php echo $row['zobrazeno']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>





<?php
} else {
    errorBox('Nemáš právo zobrazovat statistiky / Nemáš kurzy - nejsi organizátor!');
}

require INC . '/html_footer.php';
?>
