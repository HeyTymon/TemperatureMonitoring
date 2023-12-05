<?php 
	session_start(); 
	if(!isset($_SESSION['isLogined'])) { 
		header('Location: index.php');
		exit();
	}	

	require_once "connection.php";
	$connection = mysqli_connect($host, $user, $password, $dbName);

	function echoTable($sqlQuery, $columnName, $connection) {

		if($connection->connect_errno != 0) {
			echo "Error: ".$connection->connect_errno;
		} else {
			if($result = $connection->query($sqlQuery)) {
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						echo "<tr>";
						echo "<td>" . $row["$columnName"] . "</td>";
						echo "<td>" . $row["date"] . "</td>";
						if(isset($_SESSION["sensorNameSession"])) echo "<td>" . $row["sensorName"] . "</td>";
                        echo "<td>" . $row["cluster"] . "</td>";
						echo "</tr>";
							}
						} else {
							echo "No data";
						}
						} else {
							echo "Error SQL" . $connection->error;
						}
					}
	}

    if(isset($_SESSION['filterDaysValues1']) && isset($_SESSION['filterDaysValues2'])) {
        $sqlQuery1 = $_SESSION['filterDaysValues1'];
        $sqlQuery2 = $_SESSION['filterDaysValues2'];
        $columnName1 = $_SESSION['columnName1'];
        $columnName2 = $_SESSION['columnName2'];

        unset($_SESSION['filterDaysValues1']);
        unset($_SESSION['filterDaysValues2']);
        unset($_SESSION['columnName1']);
        unset($_SESSION['columnName2']);
    } else {
        $sqlQuery1 = "SELECT `id`, MAX(temperature) AS maxTemperature, CAST(`date` AS DATE) AS date, `sensorName`, `cluster` FROM `measurementstoday` GROUP BY CAST(`date` AS DATE)";
        $sqlQuery2 = "SELECT `id`, MAX(humidity) AS maxHumidity, CAST(`date` AS DATE) AS date, `sensorName`, `cluster` FROM `measurementstoday` GROUP BY CAST(`date` AS DATE)";
        $columnName1 = "maxTemperature";
        $columnName2 = "maxHumidity";
		$_SESSION["sensorNameSession"] = 1;
    }

?>	

<!DOCTYPE html>
<html>
	<head>
		<title>Other days stats</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href = "styleDays.css" type = "text/css"/>
		<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	</head>
	<body>
		<main>
			<article id = "mainArticle">

                <section id = "filterTheMeasurements"> 
                    <h1>Filter the measurements</h1>
					<form  action = "filterDays.php" method = "post">
						<label for = "parameter">Choose parameter:</label>
						<select name = "parameter">
							<option>Maximum values</option>
							<option>Minimum values</option>
                            <option>Average values</option>
                            <option>Amplitude</option>
						</select><br>
						<br>
						<label for = "dateFilter">Choose date filter:</label>
						<select name = "dateFilter">
							<option>ASC</option>
							<option>DESC</option>
						</select><br>
                        <input type ="submit" value = "Filter">
                    </form>
				</section>

				<section id = "tempSection">
					<table border="1" name = "tabel1">

							<tr>
								<th>Temperature</th>
								<th>Date</th>
								<?php 
									if(isset($_SESSION["sensorNameSession"])) echo "<th>Sensor name</th>";
								?>
                                <th>Cluster</th>
							</tr>

							<?php
								echoTable($sqlQuery1,$columnName1,$connection);
							?>

					</table><br><br>
				</section>

				<section id = "humiditySection">
					<table border="1" name = "tabel2">
							<tr>
								<th>Humidity</th>
								<th>Date</th>
								<?php 
									if(isset($_SESSION["sensorNameSession"])) echo "<th>Sensor name</th>";
								?>
                                <th>Cluster</th>
							</tr>

							<?php
								echoTable($sqlQuery2,$columnName2,$connection);
							?>

					</table><br><br>
				</section>

				<button onclick="window.location.href='main.php'">Main page</button>

				<?php 
					unset($_SESSION["sensorNameSession"]);
					$connection->close(); 
				?>
			</article>

			<article id = "chartsArcitle">
				<section id = "temperatureChartSection">
					<h2>Temperatura</h2>
					<canvas id="temperatureChart" width="400" height="200"></canvas>
				</section>

				<section id = "humidityChartSection">
					<h2>Wilgotność</h2>
					<canvas id="humidityChart" width="400" height="200"></canvas>
				</section>
			</article>

			<script>
        // Pobierz dane z bazy danych
        fetch('getData.php')
            .then(response => response.json())
            .then(data => {
                // Przetwórz dane
                const labels = [...new Set(data.map(entry => entry.hour))];
                const sensors = [...new Set(data.map(entry => entry.sensorName))]; // Unikalne sensory

                const datasetsTemperature = sensors.map((sensor, index) => ({
                    label: `Temperatura - Sensor ${sensor}`,
                    data: labels.map(hour => {
                        const entry = data.find(entry => entry.sensorName === sensor && entry.hour === hour);
                        return entry ? entry.avg_temperature : null;
                    }),
                    borderColor: getRandomColor(index),
                    borderWidth: 2,
                    fill: false
                }));

                const datasetsHumidity = sensors.map((sensor, index) => ({
                    label: `Wilgotność - Sensor ${sensor}`,
                    data: labels.map(hour => {
                        const entry = data.find(entry => entry.sensorName === sensor && entry.hour === hour);
                        return entry ? entry.avg_humidity : null;
                    }),
                    borderColor: getRandomColor(index),
                    borderWidth: 2,
                    fill: false
                }));

                // Utwórz wykres Temperatury
                const ctxTemperature = document.getElementById('temperatureChart').getContext('2d');
                const temperatureChart = new Chart(ctxTemperature, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: datasetsTemperature
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

                // Utwórz wykres Wilgotności
                const ctxHumidity = document.getElementById('humidityChart').getContext('2d');
                const humidityChart = new Chart(ctxHumidity, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: datasetsHumidity
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

                // Inicjalizuj Datepicker
                $(function() {
                    $("#datepicker").datepicker({
                        dateFormat: 'dd/mm/yy',
                        onSelect: function(dateText, inst) {
                            // Znajdź indeks wszystkich wystąpień daty w danych
                            const selectedDate = new Date(dateText);
                            const indices = labels.reduce((acc, label, index) => {
                                const labelDate = new Date(label); // Bez konieczności zamiany kropki na ukośniki
                                if (labelDate.toDateString() === selectedDate.toDateString()) {
                                    acc.push(index);
                                }
                                return acc;
                            }, []);

                            if (indices.length > 0) {
                                // Zaktualizuj dane wykresów na podstawie wybranej daty
                                temperatureChart.data.labels = indices.map(index => labels[index]);
                                temperatureChart.data.datasets.forEach((dataset, datasetIndex) => {
                                    dataset.data = indices.map(index => datasetsTemperature[datasetIndex].data[index]);
                                });
                                temperatureChart.update();

                                humidityChart.data.labels = indices.map(index => labels[index]);
                                humidityChart.data.datasets.forEach((dataset, datasetIndex) => {
                                    dataset.data = indices.map(index => datasetsHumidity[datasetIndex].data[index]);
                                });
                                humidityChart.update();
                            }
                        }
                    });
                });

                // Funkcja generująca losowy kolor w formie RGBA
                function getRandomColor(index) {
                    const hue = (index * 137.508) % 360;
                    return `hsla(${hue}, 75%, 50%, 1)`;
                }
            });
    </script>

		</main>
	</body>
</html>

