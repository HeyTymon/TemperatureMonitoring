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
						echo "<td>" . $row["sensorName"] . "</td>";
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
    }

?>	

<!DOCTYPE html>
<html>
	<head>
		<title>Other days stats</title>
		<link rel="stylesheet" href = "styleDays.css" type = "text/css"/>
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
								<th>Sensor name</th>
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
								<th>Sensor name</th>
                                <th>Cluster</th>
							</tr>

							<?php
								echoTable($sqlQuery2,$columnName2,$connection);
							?>

					</table><br><br>
				</section>

				<button onclick="window.location.href='main.php'">Main page</button>

				<?php 
					$connection->close(); 
				?>
			</article>
		</main>
	</body>
</html>

