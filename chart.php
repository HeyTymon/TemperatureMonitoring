<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wykresy liniowe</title>
    <!-- Dodaj link do biblioteki Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Wykresy liniowe z danych SQL</h1>

    <!-- Wykres Temperatury -->
    <div style="margin-bottom: 20px;">
        <h2>Temperatura</h2>
        <canvas id="temperatureChart" width="400" height="200"></canvas>
    </div>

    <!-- Wykres Wilgotności -->
    <div>
        <h2>Wilgotność</h2>
        <canvas id="humidityChart" width="400" height="200"></canvas>
    </div>

    <script>
        // Pobierz dane z bazy danych
        fetch('getData.php')
            .then(response => response.json())
            .then(data => {
                // Przetwórz dane
                const labels = data.map(entry => new Date(entry.date).toLocaleDateString());
                const temperatureValues = data.map(entry => entry.temperature);
                const humidityValues = data.map(entry => entry.humidity);

                // Stwórz wykres Temperatury
                const ctxTemperature = document.getElementById('temperatureChart').getContext('2d');
                const temperatureChart = new Chart(ctxTemperature, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Temperatura',
                                data: temperatureValues,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 2,
                                fill: false
                            }
                        ]
                    },
                    options: {
                        scales: {
                            x: [{
                                type: 'category',
                                position: 'bottom'
                            }]
                        }
                    }
                });

                // Stwórz wykres Wilgotności
                const ctxHumidity = document.getElementById('humidityChart').getContext('2d');
                const humidityChart = new Chart(ctxHumidity, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Wilgotność',
                                data: humidityValues,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 2,
                                fill: false
                            }
                        ]
                    },
                    options: {
                        scales: {
                            x: [{
                                type: 'category',
                                position: 'bottom'
                            }]
                        }
                    }
                });
            });
    </script>
</body>
</html>
