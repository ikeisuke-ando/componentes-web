@props(['filteredData', 'type', 'chart'])

<div>
    <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div style="width:75%;">
    <h1>Gráfico de Evolução das Estrelas</h1>

    <canvas id="chart" width="400" height="200"></canvas>
    <script>
        const ctx = document.getElementById('myChart')
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($filteredData)) !!},
                datasets: [{
                    label: 'Stars',
                    data: {!! json_encode(array_values($filteredData)) !!},
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</div>
